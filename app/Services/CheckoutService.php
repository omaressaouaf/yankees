<?php

namespace App\Services;

use App\Models\Order;
use App\Events\UserCharged;
use App\Events\OrderCreated;
use App\Events\UserRefunded;
use App\Events\OrderStatusChanged;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Events\PaymentConfirmationRequired;
use Laravel\Cashier\Exceptions\PaymentFailure;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CheckoutService
{

    public function checkout($address_id, $name_on_card, $payment_mode, $payment_method)
    {
        $msg = 'success';
        $status = 200;
        /** @var \App\Models\User */
        $authUser = auth()->user();
        $authUserAddress = $authUser->addresses()->findOrFail($address_id);

        try {
            DB::beginTransaction();
            $order = $authUser->orders()->create([
                'email' => $authUser->email,
                "phone" => $authUser->phone,
                "address_line" => $authUserAddress->line,
                "address_details" => $authUserAddress->details,
                "address_latitude" => $authUserAddress->latitude,
                "address_longitude" => $authUserAddress->longitude,
                "tax_price" => Cart::tax(),
                "delivery_price" => config('delivery.price'),
                "subtotal" => Cart::subtotal(),
                'total' => Cart::total() + config('delivery.price'),
                "name_on_card" => $name_on_card,
                "payment_mode" => $payment_mode,
                "status" => "pending"
            ]);
            foreach (Cart::content() as $item) {
                $order->meals()->attach($item->model->id, [
                    'qty' => $item->qty,
                    'meal_subtotal' => $item->subtotal,
                    "user_selected_options" => $item->options->user_selected_options
                ]);
            }

            if ($payment_mode == "stripe") {
                if (Gate::denies('checkout-with-stripe')) {
                    throw new UnauthorizedException("Stripe Payment is not allowed");
                }
                $authUser->createOrGetStripeCustomer();
                if ($authUser->hasDefaultPaymentMethod()) {
                    $authUser->deletePaymentMethods();
                }
                $authUser->updateDefaultPaymentMethod($payment_method);
            }
            DB::commit();
            Cart::destroy();
            OrderCreated::dispatch($order);
        } catch (UnauthorizedException $e) {
            DB::rollback();
            $msg = "Failed ." . $e->getMessage();
            $status = 401;
        } catch (\Exception $e) {
            DB::rollback();
            $msg = "Failed ." . $e->getMessage();
            $status = 500;
        } finally {
            return ['msg' => $msg, 'status' => $status];
        }
    }
    public function chargeUser(Order $order)
    {
        $msg = 'user charged successfully';
        $status = 200;
        $payment = "";
        try {
            DB::beginTransaction();
            $order->update([
                'user_charged' => true,
            ]);
            $user = $order->user;
            if (!$user) {
                throw new ModelNotFoundException();
            }
            $paymentMethod = $user->defaultPaymentMethod();
            $payment =  $user->charge($order->total * 100, $paymentMethod->id, [
                'metadata' => [
                    'order_id' => $order->id
                ]
            ]);

            DB::commit();

            UserCharged::dispatch($order);
        } catch (PaymentFailure | ModelNotFoundException  $e) {
            DB::rollback();
            $order->update([
                'status' => 'failed',
            ]);
            $status = 400;
            $msg = $e instanceof PaymentFailure ?   "The payment did not pass successfully" : "The user was not found (deleted)";
            if ($order->user_id  != null && auth()->id() !=  $order->user_id) {
                OrderStatusChanged::dispatch($order);
            }
        } catch (PaymentActionRequired  $e) {
            DB::rollback();
            $order->update([
                'payment_confirmation_required' => true,
            ]);
            $payment = $e->payment;
            $msg = "The payment requires additional confirmation. a notification will be sent to the client in order to confirm and pay . you will get notified when the payment is confirmed";
            $status = 406;
            PaymentConfirmationRequired::dispatch($order, $payment);
        } catch (\Exception $e) {
            DB::rollback();
            $msg = "Failed ." . $e->getMessage();
            $status = 500;
        } finally {
            $order->update([
                'payment_id' => $payment->id
            ]);
            return ['msg' => $msg, 'status' => $status];
        }
    }
    public function refundUser($order)
    {
        $msg = 'user refunded successfully';
        $status = 200;
        try {
            DB::beginTransaction();

            $order->update([
                'user_refunded' => true,
            ]);
            $user = $order->user;
            if (!$user) {
                throw new ModelNotFoundException();
            }
            $user->refund($order->payment_id);
            DB::commit();
            UserRefunded::dispatch($order);
        } catch (ModelNotFoundException  $e) {
            DB::rollback();
            $status = 400;
            $msg = "The user was not found (deleted)";
        } catch (\Exception $e) {
            DB::rollback();
            $msg = "Failed ." . $e->getMessage();
            $status = 500;
        } finally {
            return ['msg' => $msg, 'status' => $status];
        }
    }
}

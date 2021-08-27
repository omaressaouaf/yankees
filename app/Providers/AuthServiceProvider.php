<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Spatie\OpeningHours\OpeningHours;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // For Clients
        Gate::define('checkout', function (User $user = null) {
            return Cart::total()  >= config('cart.min_order_price') && Cart::count() > 0;
        });
        Gate::define('track_order', function (User $user, $status) {
            return $status != "cancelled" && $status != "failed";
        });
        Gate::define('cancel_order', function (User $user, Order $order) {
            return $order->status == "pending" && $order->created_at->diffInMinutes(Carbon::now()) > 5;
        });
        Gate::define('shop', function (User $user =null) {
            $openingHours = OpeningHours::create(array_merge(['overflow' => true],  config('schedule.openingHours')));
            $forcedClose = config('schedule.forcedClose');
            return $openingHours->isOpen() &&  !$forcedClose;
        });
        Gate::define('checkout-with-stripe', function (User $user) {
            return config('payment.stripeEnabled')  === true;
        });
        // For admins/managers/delivery men
        Gate::define("manage-partially", function (User $user) {
            return $user->hasAnyRole(['admin', 'manager']);
        });
        Gate::define("manage-fully", function (User $user) {
            return $user->hasRole('admin');
        });
        Gate::define('charge', function (User $user, Order $order) {
            return ($user->hasAnyRole(['admin', 'manager']) && $order->payment_mode == "stripe"  &&
                !$order->user_charged &&
                !$order->payment_confirmation_required &&
                $order->status != "pending" &&
                $order->status != "cancelled" &&
                $order->status != "failed");
        });
        Gate::define('refund', function (User $user, Order $order) {
            return ($user->hasAnyRole(['admin', 'manager']) && $order->payment_mode == "stripe"  &&
                $order->user_charged &&
                !$order->user_refunded &&
                $order->status == "cancelled");
        });
        Gate::define('update-order', function (User $user, $order, $request_deliveryman_id, $request_status) {
            if ($order->status == 'failed' || $order->status == "cancelled") {
                return false;
            }
            if (!$user->hasAnyRole(['admin', 'manager'])) {
                return $order->status == "out_for_delivery"
                ? ($order->deliveryman_id == $request_deliveryman_id)
                && $request_status == "delivered"
                 : false;
            }
            return (!$request_deliveryman_id) && ($request_status == "out_for_delivery" || $request_status == "delivered") ? false : true;
        });
        Gate::define('read-order', function (User $user, $order) {
            return $user->hasAnyRole(['admin', 'manager']) || $user->id == $order->deliveryman_id;
        });
    }
}

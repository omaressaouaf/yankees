<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('deliveryman_id')->nullable();
            $table->foreign('deliveryman_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->string('email');
            $table->string('phone');
            $table->text('address_line');
            $table->text('address_details');
            $table->double('address_latitude');
            $table->double('address_longitude');
            $table->integer('delivery_price');
            $table->integer('tax_price');
            $table->integer('subtotal');
            $table->integer('total');
            /* For Stripe */
            $table->string('payment_id')->nullable();
            $table->string('name_on_card')->nullable();
            $table->enum('payment_mode', ['cash', 'stripe']);
            $table->enum('status', ['pending', 'processing', 'out_for_delivery', 'delivered', 'cancelled', 'failed'])->default('pending');
            $table->boolean('user_charged')->default(0);
            $table->boolean('user_refunded')->default(0);
            $table->boolean('payment_confirmation_required')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

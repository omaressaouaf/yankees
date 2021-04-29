<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_meal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extra_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('meal_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->json('admin_selected_options');
            $table->integer('min');
            $table->integer('max');
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
        Schema::dropIfExists('extra_meal');
    }
}

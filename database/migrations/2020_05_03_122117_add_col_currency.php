<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('selling_price_euro')->after('selling_price')->nullable();
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->string('prefered_currency')->default(1)->before('created_at')->nullable();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('pay_currency')->default(1)->before('created_at')->nullable();
            $table->string('order_token')->before('created_at')->nullable();
        });
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->string('order_token')->before('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

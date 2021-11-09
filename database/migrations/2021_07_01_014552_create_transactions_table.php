<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('total', 18, 4)->unsigned();
           // $table->timestamp('payment_purchased')->nullable();
            $table->decimal('total_vendor', 18, 4)->unsigned();
            // Payment date === created_at
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
        Schema::dropIfExists('payments');
    }
}

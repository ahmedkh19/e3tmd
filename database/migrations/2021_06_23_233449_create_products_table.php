<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\EncryptionController;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /*
     * PRICING METHODS *
     *   Fixed Price  *
     *     Auction    *
     */
    // Start_bid_amount required if the pricing_method is auction

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('pricing_method');
            $table->boolean('isSold')->default(0);
            $table->boolean('isPaid')->default(0);
            $table->decimal('price', 18, 2)->unsigned()->nullable();
            $table->unsignedInteger('commission')->unsigned()->nullable();
            $table->string("os")->nullable()->default("o"); // mean other
            $table->string("currency")->default("rs");

            $table->decimal('start_bid_amount', 18, 4)->unsigned()->nullable();
            $table->timestamp('auction_start')->nullable();
            $table->timestamp('auction_end')->nullable();

            $table->string('main_image')->nullable(); // Featured image
            $table->string('account_email')->nullable();
            $table->string('account_password')->nullable();
            $table->string('account_security_questions')->nullable();
            $table->integer('viewed')->unsigned()->default(0);
            $table->unsignedInteger('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}

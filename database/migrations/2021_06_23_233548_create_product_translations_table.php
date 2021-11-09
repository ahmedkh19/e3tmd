<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('locale');
            $table->string('name');
            $table->longText('description');
            $table->text('short_description')->nullable();

            $table->unique(['product_id', 'locale']);
        });
        DB::statement('ALTER TABLE product_translations ADD FULLTEXT(name)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_translations');
    }
}

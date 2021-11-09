<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /**
     * Users Status
     * 1 = Active
     * 2 = inActive
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->decimal('balance', 18, 4)->default(0);
            $table->text('roles_name');
            $table->unsignedInteger('status');
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}

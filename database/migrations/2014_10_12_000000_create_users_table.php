<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('email', 150)->default(000)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('enrolment')->nullable();
            $table->nullableMorphs('userable');
            $table->string('role', 20)->nullable();
            $table->string('cpf', 14)->nullable();
            $table->string('birth_date', 20)->nullable();
            $table->string('other_document')->default(000);
            $table->string('area_code', 6)->default(32);
            $table->string('phone', 16)->default(000);
            $table->string('address')->nullable();
            $table->string('postcode', 12)->nullable();
            $table->string('number', 10)->nullable();
            $table->string('complement', 150)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('neighborhood', 150)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('password');
            $table->rememberToken();
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

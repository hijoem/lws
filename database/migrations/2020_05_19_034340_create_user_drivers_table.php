<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_drivers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
            $table->string('url_sim')->nullable();
            $table->string('url_stnk')->nullable();
            $table->string('no_plat')->nullable();
            $table->string('model')->nullable();
            $table->boolean('is_online')->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::dropIfExists('user_drivers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('url_img')->nullable();
            $table->string('no_hp')->unique()->nullable();
            $table->boolean('no_hp_confirmed')->nullable();
            $table->text('status')->nullable();
            $table->string('address')->nullable();
            $table->string('birthday')->nullable();
            $table->string('rt')->nullable();
            $table->string('shop')->nullable();
            $table->string('community')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('user_details');
    }
}

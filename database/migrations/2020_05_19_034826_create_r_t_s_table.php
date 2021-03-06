<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRTSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_t_s', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
            $table->text('name')->nullable();
            $table->text('url_sk')->nullable();
            $table->string('lang')->nullable();
            $table->string('lat')->nullable();
            $table->text('url_img')->nullable();
            $table->text('detail')->nullable();
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
        Schema::dropIfExists('r_t_s');
    }
}

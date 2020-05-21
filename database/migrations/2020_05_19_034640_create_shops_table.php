<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
            $table->string('name')->nullable();
            $table->string('jenis')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('lang')->nullable();
            $table->string('lat')->nullable();
            $table->text('url_img')->nullable();
            $table->text('status')->nullable();
            $table->text('opr_hour')->nullable();
            $table->boolean('is_open')->default(false);
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
        Schema::dropIfExists('shops');
    }
}

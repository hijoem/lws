<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('cat_info')->nullable();
            $table->text('url_file')->nullable();
            $table->text('url_img1')->nullable();
            $table->text('url_img2')->nullable();
            $table->text('url_img3')->nullable();
            $table->text('name')->nullable();
            $table->text('detail')->nullable();
            $table->boolean('is_published')->default(true);
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
        Schema::dropIfExists('infos');
    }
}

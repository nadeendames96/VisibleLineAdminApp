<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('image_select')->default(0)->nullable();
            $table->string('news')->nullable();
            $table->integer('time_entry');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

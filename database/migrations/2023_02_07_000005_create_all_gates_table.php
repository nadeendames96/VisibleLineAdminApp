<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllGatesTable extends Migration
{
    public function up()
    {
        Schema::create('all_gates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gates_name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

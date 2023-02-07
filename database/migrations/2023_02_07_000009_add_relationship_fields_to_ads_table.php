<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAdsTable extends Migration
{
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->unsignedBigInteger('gate_name_id')->nullable();
            $table->foreign('gate_name_id', 'gate_name_fk_7991152')->references('id')->on('all_gates');
        });
    }
}

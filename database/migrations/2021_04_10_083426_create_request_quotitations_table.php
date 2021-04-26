<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestQuotitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_quotitations', function (Blueprint $table) {
            $table->id();
            $table->string('nameUnidadGasto');
            $table->string('aplicantName');
            $table->date('requestDate');
            $table->integer('amount');
            $table->string('status')->nullable()->default('pendiente');
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
        Schema::dropIfExists('request_quotitations');
    }
}

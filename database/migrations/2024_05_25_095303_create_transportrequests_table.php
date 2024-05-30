<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportrequests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("client_id")->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();

            $table->unsignedBigInteger("destination_id")->nullable();
            $table->foreign('destination_id')->references('id')->on('destinations')->cascadeOnDelete();

            $table->unsignedBigInteger("transporter_id")->nullable();
            $table->foreign('transporter_id')->references('id')->on('transporters')->cascadeOnDelete();

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
        Schema::dropIfExists('transportrequests');
    }
}

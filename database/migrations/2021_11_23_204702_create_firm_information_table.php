<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firm_informations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('logo')->nullable();
            $table->integer('city')->nullable();
            $table->integer('town')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();
            $table->string('lat')->nullable();
            $table->string('lang')->nullable();
            $table->integer('area')->nullable();
            $table->integer('capacity')->nullable();
            $table->string('productionTypes')->nullable();
            $table->string('market')->nullable();
            $table->text('about')->nullable();
            $table->string('storeAmount')->nullable();
            $table->string('storeArea')->nullable();
            $table->string('productTypes')->nullable();
            $table->text('address')->nullable();
            $table->string('partners')->nullable();
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
        Schema::dropIfExists('firm_information');
    }
}

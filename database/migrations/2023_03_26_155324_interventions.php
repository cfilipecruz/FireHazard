<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('place');
            $table->integer('car_id')->nullable();
            $table->integer('client_id');
            $table->integer('user_id');
            $table->text('observations')->nullable();
            $table->integer('internalNumber');
            $table->string('serialNumber');
            $table->integer('fluid_type_id');
            $table->integer('capacity'); //kilograms
            $table->boolean('pressure');
            $table->string('factoryName');
            $table->dateTime('factoryDate');
            $table->boolean('ceMarking');
            $table->text('localization');
            $table->dateTime('lastCharged');
            $table->dateTime('lastHydraulicTest');
            $table->boolean('maintenanceMNT');
            $table->boolean('chargeMNTAD');
            $table->text('type');
            $table->integer('co2Weight');
            $table->boolean('hydraulicProve');
            $table->boolean('securityStamp');
            $table->boolean('oRing');
            $table->boolean('peg');
            $table->boolean('manometer');
            $table->boolean('diffuser');
            $table->boolean('plasticBase');
            $table->boolean('label');
            $table->boolean('sparkles');
            $table->boolean('approved');
            $table->boolean('new');
            $table->boolean('outofservice');
            $table->text('rejectedMotive')->nullable();
            $table->integer('invoice_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};

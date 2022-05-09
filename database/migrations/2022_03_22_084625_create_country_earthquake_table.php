<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryEarthquakeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_earthquake', function (Blueprint $table) {
            $table->id();
            $table->foreignId('earthquake_id')->constrained('earthquakes')->delete('cascade');
            $table->foreignId('country_id')->constrained('countries')->delete('cascade');
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
        Schema::dropIfExists('country_earthquake');
    }
}

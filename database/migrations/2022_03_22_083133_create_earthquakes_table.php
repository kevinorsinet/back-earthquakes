<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarthquakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earthquakes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->datetime('date');
            $table->decimal('magnitude');
            $table->integer('radius');
            $table->foreignId('icon_id')->constrained('icons');
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
        Schema::dropIfExists('earthquakes');
    }
}

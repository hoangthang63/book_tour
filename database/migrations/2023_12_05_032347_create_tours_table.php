<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->date('start_at');
            $table->date('end_at');
            $table->integer('price')->nullable();
            $table->string('type', 20)->nullable();
            $table->text('description');
            $table->integer('id_company')->nullable();
            $table->string('departure_place', 255)->nullable();
            $table->text('image');
            $table->integer('slot')->nullable();
            $table->integer('slot_available')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
};

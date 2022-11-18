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
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->text('category');
            $table->string('year');
            $table->string('first_quart');
            $table->string('second_quart')->nullable();
            $table->string('third_quart')->nullable();
            $table->string('fourth_quart')->nullable();
            $table->string('annual')->nullable();
            $table->string('director_report')->nullable();
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
        Schema::dropIfExists('statements');
    }
};

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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_number');
            $table->string('company_name');
            $table->string('commercial_register')->nullable();
            $table->string('website')->nullable();
            $table->text('sector');
            $table->string('share_manager_name')->nullable();
            $table->string('share_manager_phone')->nullable();
            $table->unsignedFloat('share_price');
            $table->string('company_evaluation');
            $table->text('logo')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('companies');
    }
};

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
        Schema::create('troubled_companies', function (Blueprint $table) {
            $table->id();
            $table->text('platform_name');
            $table->text('company_name');
            $table->date('loan_date');
            $table->date('due_date');
            $table->text('category');
            $table->unsignedInteger('delay');
            $table->text('status');
            $table->text('notes');
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
        Schema::dropIfExists('troubled_companies');
    }
};

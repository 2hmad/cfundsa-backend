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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->nullable();
            $table->string('type_color')->nullable();
            $table->date('publish_date');
            $table->longText('content');
            $table->string('companies')->nullable();
            $table->string('fund_ids')->nullable();
            $table->string('tags');
            $table->unsignedInteger('views');
            $table->unsignedInteger('comments');
            $table->string('pin');
            $table->string('image');
            $table->text('article_type');
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
        Schema::dropIfExists('articles');
    }
};

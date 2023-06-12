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
        Schema::create('project_completion_statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('es_project_id');
            $table->integer('user_id');
            $table->boolean('closed');
            $table->string('completion_path');
            $table->string('final_conclusion');
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
        Schema::dropIfExists('project_completion_statistics');
    }
};

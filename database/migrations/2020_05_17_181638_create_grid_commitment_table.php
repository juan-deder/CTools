<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGridCommitmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grid_commitment', function (Blueprint $table) {
            $table->foreignId('grid_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->set('roles', ['creator', 'approver'])->default('creator');
            $table->unique(['grid_id', 'user_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grid_commitment');
    }
}

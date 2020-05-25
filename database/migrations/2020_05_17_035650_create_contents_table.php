<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->timestamp('planned_for');
            $table->set('channels', ['facebook', 'instagram', 'twitter', 'tiktok', 'whatsapp', 'snapchat']);
            $table->string('title');
            $table->string('description');
            $table->string('tags');
            $table->string('location');
            $table->foreignId('grid_id')->constrained();
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
        Schema::dropIfExists('contents');
    }
}

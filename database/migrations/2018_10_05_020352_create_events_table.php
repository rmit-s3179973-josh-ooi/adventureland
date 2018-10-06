<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_title');
            $table->text('event_description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->boolean('is_active')->default(1);            
            $table->timestamps();
        });

        Schema::create('event_user', function(Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('event_id');
            $table->boolean('is_creator')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('event_id')
            ->references('id')->on('events')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_user', function($table) {
            $table->dropForeign('event_user_user_id_foreign');
            $table->dropForeign('event_user_event_id_foreign');
        });

        Schema::dropIfExists('events');
        Schema::dropIfExists('event_user');
    }
}

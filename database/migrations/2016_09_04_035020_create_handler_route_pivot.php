<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandlerRoutePivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handler_route', function (Blueprint $table) {
            $table->unsignedInteger('route_id')->nullable();
            $table->unsignedInteger('handler_id')->nullable();

            $table->foreign('route_id')->references('id')->on('routes')->onDelete('set null');
            $table->foreign('handler_id')->references('id')->on('handlers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('handler_route');
    }
}

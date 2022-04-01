<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign('owner_fk_4427045');
            $table->foreign('owner_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        });
    }
}

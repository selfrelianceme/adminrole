<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdminSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        if (!Schema::hasTable('admin__sections')) {
            Schema::create('admin__sections', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->json('privilegion');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        
        Schema::dropIfExists('admin__sections');
    }
}

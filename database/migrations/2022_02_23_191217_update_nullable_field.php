<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNullableField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         //更新description字段可以为空
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
        Schema::table('links', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
        Schema::table('options', function (Blueprint $table) {
            $table->text('value')->nullable()->change();
            $table->text('extend')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

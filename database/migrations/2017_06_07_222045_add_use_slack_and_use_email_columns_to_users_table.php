<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUseSlackAndUseEmailColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('via_email')->after('notifications_enabled')->default(true);
            $table->boolean('via_slack')->after('via_email')->default(true);
            $table->dropColumn('notifications_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notifications_enabled')->after('via_slack')->default(true);
            $table->dropColumn('via_email');
            $table->dropColumn('via_slack');
        });
    }
}

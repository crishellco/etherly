<?php

use App\Services\EtherPriceService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeThresholdToDoubleOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('threshold');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->double('threshold')->after('slack_webhook')->default(EtherPriceService::DEFAULT_PERCENT_CHANGE_THRESHOLD);
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
            $table->dropColumn('threshold');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->float('threshold')->after('slack_webhook')->default(EtherPriceService::DEFAULT_PERCENT_CHANGE_THRESHOLD);
        });
    }
}

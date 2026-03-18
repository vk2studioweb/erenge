<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVprLoginUsersProfilePicture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vpr_login_users', function (Blueprint $table) {
            $table->string('theme', 50)->after('email')->default('dark');
            $table->string('profile_picture')->nullable()->after('theme');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vpr_login_users', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
            $table->dropColumn('theme');
        });
    }
}

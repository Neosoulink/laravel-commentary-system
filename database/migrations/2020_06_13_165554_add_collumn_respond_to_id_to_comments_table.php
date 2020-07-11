<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnRespondToIdToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::enableForeignKeyConstraints();
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId("respond_to_id")->nullable()->reference('id')->constrained('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn("respond_to_id");
        });
    }
}

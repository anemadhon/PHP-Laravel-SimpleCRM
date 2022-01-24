<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugAndFilenameToProjectAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_attachments', function (Blueprint $table) {
            $table->string('filename')->after('path');
            $table->string('slug')->after('filename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_attachments', function (Blueprint $table) {
            $table->dropColumn(['filename', 'slug']);
        });
    }
}

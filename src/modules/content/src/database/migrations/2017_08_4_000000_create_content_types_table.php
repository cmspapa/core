<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTypesTable extends Migration
{
    /**
     * Run the migrations.
     * Content types is a bunch for content bundle.
     * @todo dynamic create bunches.
     * @return void
     */
    public function up()
    {
        Schema::create('content_types', function (Blueprint $table) {
            $table->string('ctid')->primary()->unique()->comment('Content type unique id');
            $table->string('name')->unique()->comment('Content type name');
            $table->text('description')->comment('Content type description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_types');
    }
}

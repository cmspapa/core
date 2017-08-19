<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @todo move this file to a hight level module.
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->string('bundle')->comment('Bundle is the highest level type such as a content or anything will require specific and different properties.');
            $table->string('bunch')->comment('Bunch is the second level type in a bundle such as content type bunch in content bundle.');
            // Field id and it's label are unique every second level "bunch".
            $table->string('field_id')->comment('Field unique id.');
            $table->string('field_label')->comment('Field label.');
            $table->string('field_type')->comment('Field type such as string, text ...etc.');
        });

        // Create default fields
        Schema::create('field_title', function (Blueprint $table) {
            $table->string('bundle')->comment('Bundle is the highest level type such as a content or anything will require specific and different properties.');
            $table->string('bunch')->comment('Bunch is the second level type in a bundle such as content type bunch in content bundle.');
            $table->integer('item_id')->comment('Item unique id such as content id');
            $table->string('field_value')->comment('The value of field');
        });

        Schema::create('field_body', function (Blueprint $table) {
            $table->string('bundle')->comment('Bundle is the highest level type such as a content or anything will require specific and different properties.');
            $table->string('bunch')->comment('Bunch is the second level type in a bundle such as content type bunch in content bundle.');
            $table->integer('item_id')->comment('Item unique id such as content id');
            $table->text('field_value')->comment('The value of field');
        });

        Schema::create('field_url_alias', function (Blueprint $table) {
            $table->string('bundle')->comment('Bundle is the highest level type such as a content or anything will require specific and different properties.');
            $table->string('bunch')->comment('Bunch is the second level type in a bundle such as content type bunch in content bundle.');
            $table->integer('item_id')->comment('Item unique id such as content id');
            $table->string('field_value')->comment('The value of field');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}

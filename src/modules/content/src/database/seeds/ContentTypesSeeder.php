<?php

namespace Cmspapa\content\Database\Seeds;

use Illuminate\Database\Seeder;

class ContentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\DB::table('content_types')->insert([
            'ctid' => 'page',
            'name' => 'Page',
            'description' => 'Basic page'
        ]);

        \DB::table('fields')->insert([
            'bundle' => 'content',
            'bunch' => 'page',
            'field_id' => 'field_title',
            'field_label' => 'Title',
            'field_type' => 'string'
        ]);

        \DB::table('fields')->insert([
            'bundle' => 'content',
            'bunch' => 'page',
            'field_id' => 'field_body',
            'field_label' => 'Body',
            'field_type' => 'text'
        ]);

        \DB::table('fields')->insert([
            'bundle' => 'content',
            'bunch' => 'page',
            'field_id' => 'field_url_alias',
            'field_label' => 'Url alias',
            'field_type' => 'string'
        ]);
    }
}

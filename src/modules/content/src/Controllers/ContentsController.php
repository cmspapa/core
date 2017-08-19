<?php

namespace Cmspapa\content\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;

use Cmspapa\content\Models\Field;
use Cmspapa\content\Models\Content;
use Illuminate\Support\Facades\DB;
use Cmspapa\content\Models\ContentType;

class ContentsController extends Controller
{
    /**
     * .
     *
     * @return view
     */
    public function listAllcontentsIndexLinks()
    {
        $contentTypes = ContentType::get();
        return view('content::contents.general', compact('contentTypes'));
    }

    /**
     * .
     *
     * @return view
     */
    public function listAllcontentsCreateLinks()
    {
        $contentTypes = ContentType::get();
        return view('content::contents.general', compact('contentTypes'));
    }

	/**
     * .
     *
     * @return view
     */
    public function index($contentTypeId)
    {
        $fields = Field::where('bundle', 'content')->where('bunch', $contentTypeId)->get();


    	$contents = DB::table('contents');
        $contents = $contents->select('contents.*');
        foreach ($fields as $field) {
            $contents = $contents->join($field->field_id, function ($join) use ($field) {
                $join->on('contents.id', '=', $field->field_id.'.item_id')
                     ->where($field->field_id.'.bundle', 'content');
            });
            $contents = $contents->addSelect($field->field_id.'.field_value AS '.$field->field_id);
        }
        // @todo create filters
        // $contents = $contents->where('field_title.field_value', 'Mahmoud');
        // $contents = $contents->orWhere('field_description.field_value', 'Eids');

        $contents = $contents->get();


        dd($contents);
        return view('content::contents.index', compact('contents'));
    }

    /**
     * .
     *
     * @return view
     */
    public function create($contentTypeId)
    {
        $fields = Field::where('bundle', 'content')->where('bunch', $contentTypeId)->get();
        return view('content::contents.create', compact('contentTypeId', 'fields'));
    }


    /**
     * .
     *
     * @return redirect
     */
    public function save(Request $request, $contentTypeId)
    {
        // Validate request
        $this->validate($request, [
	    	// 'ctid' => 'required|unique:content_types|max:255',
	    	// 'name' => 'required|unique:content_types|max:255'
	    ]);

        // Save content
        $content = new Content;
        $content->content_type = $contentTypeId;
        $content->save();

        // Save fields
        foreach ($request->all() as $fieldName => $fieldValue) {
            if(substr($fieldName, 0, 6) === 'field_'){
                DB::table($fieldName)->insert(
                    ['bundle' => 'content', 'bunch' => $contentTypeId, 'item_id' => $content->id, 'field_value' => $fieldValue]
                );
            }
        }

        // @todo return message
        return redirect(action('\Cmspapa\content\Controllers\ContentsController@index', $contentTypeId));
    }
}
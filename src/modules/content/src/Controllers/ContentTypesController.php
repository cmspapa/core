<?php

namespace Cmspapa\content\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Cmspapa\content\Models\ContentType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Cmspapa\content\Models\Field;

class ContenttypesController extends Controller
{

	/**
     * .
     *
     * @return view
     */
    public function index()
    {
    	$contentTypes = ContentType::get();
        return view('content::content_types.index', compact('contentTypes'));
    }

    /**
     * .
     *
     * @return view
     */
    public function create()
    {
        return view('content::content_types.create');
    }


    /**
     * .
     *
     * @return redirect
     */
    public function save(Request $request)
    {
        // Validate request
        $x = $this->validate($request, [
	    	'ctid' => 'required|unique:content_types|max:255',
	    	'name' => 'required|unique:content_types|max:255'
	    ]);

        // Save content type
        $contentType = new ContentType;
        $contentType->ctid = $request->ctid;
        $contentType->name = $request->name;
        $contentType->description = $request->description;
        $contentType->save();

        // @todo return message
        return redirect(action('\Cmspapa\content\Controllers\ContentTypesController@index'));
    }

    /**
     * .
     *
     * @return view
     */
    public function manageFields($contentTypeId)
    {
    	$fields = Field::where('bunch', $contentTypeId)->get();
    	$contentTypeName = ContentType::where('ctid', $contentTypeId)->first()->name;

        return view('content::content_types.fields.index', compact('contentTypeId', 'contentTypeName', 'fields'));
    }

    /**
     * .
     *
     * @return array
     */
    public function getFieldsTypes()
    {
        $fieldsTypes = [];
        $fieldsTypes['bigInteger'] = 'Big integer';
        $fieldsTypes['boolean'] = 'Boolean';
        $fieldsTypes['date'] = 'Date';
        $fieldsTypes['dateTime'] = 'Date and time';
        $fieldsTypes['dateTimeTz'] = 'Date and time with time zone';
        $fieldsTypes['decimal'] = 'Decimal';
        $fieldsTypes['double'] = 'Double';
        $fieldsTypes['float'] = 'Float';
        $fieldsTypes['integer'] = 'Integer';
        $fieldsTypes['ipAddress'] = 'Ip address';
        $fieldsTypes['longText'] = 'Long text';
        $fieldsTypes['mediumInteger'] = 'Medium integer';
        $fieldsTypes['mediumText'] = 'Medium text';
        $fieldsTypes['smallInteger'] = 'Small integer';
        $fieldsTypes['string'] = 'String';
        $fieldsTypes['text'] = 'Text';
        $fieldsTypes['time'] = 'Time';
        $fieldsTypes['timeTz'] = 'Time with time zone';
        $fieldsTypes['tinyInteger'] = 'Tiny integer';
        $fieldsTypes['unsignedBigInteger'] = 'Unsigned big integer';
        $fieldsTypes['unsignedInteger'] = 'Unsigned integer';
        $fieldsTypes['unsignedMediumInteger'] = 'Unsigned medium integer';
        $fieldsTypes['unsignedSmallInteger'] = 'Unsigned small integer';
        return $fieldsTypes;
    }

    /**
     * .
     *
     * @return view
     */
    public function createField($contentTypeId)
    {
    	$contentTypeName = ContentType::where('ctid', $contentTypeId)->first()->name;
        $fieldsTypes = $this->getFieldsTypes();
        return view('content::content_types.fields.create', compact('contentTypeId', 'contentTypeName', 'fieldsTypes'));
    }

    /**
     * .
     *
     * @return redirect
     */
    public function saveField(Request $request, $contentTypeId)
    {
        // Validate request
        $this->validate($request, [
	    	'field_label' => 'required|max:255',
	    	'field_id' => 'required|max:255',
            'field_type' => 'required'
	    ]);

        $fieldType = $request->field_type;

        // Create table for field
        Schema::create($request->field_id, function (Blueprint $table) use ($fieldType) {
            $table->string('bundle')->comment('Bundle is the highest level type such as a content or anything will require specific and different properties.');
		    $table->string('bunch')->comment('Bunch is the second level type in a bundle such as content type bunch in content bundle.');
		    $table->integer('item_id')->comment('Item unique id such as content id');

		    // Check for types
		    $table->$fieldType('field_value')->comment('The value of field');
		});

        // Save field information attach field to bunch
        $field = new Field;
        $field->bundle = 'content';
        $field->bunch = $contentTypeId;
        $field->field_id = $request->field_id;
        $field->field_label = $request->field_label;
        $field->field_type = $request->field_type;
        // Any other options
        $field->save();

        // @todo return message
        return redirect(action('\Cmspapa\content\Controllers\ContentTypesController@manageFields', $contentTypeId));
    }
}
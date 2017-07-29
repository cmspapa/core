<?php

namespace Cmspapa\structure\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Symfony\Component\Yaml\Yaml;

class StructureController extends Controller
{
	/**
     * .
     *
     * @return view
     */
    public function index()
    {
        return view('structure::index');
    }

    /**
     * Ajax get structure.
     *
     * @return json
     */
    public function getStructure()
    {
        // Get structure
        $structure = Yaml::parse(file_get_contents(base_path('themes/start/structure.yml')));
        return $structure;
    }

    /**
     * Ajax save structure.
     *
     * @return json
     */
    public function save(Request $request)
    {
        // Save to yml file
        $structure = Yaml::dump($request->structure);
        file_put_contents(base_path('themes/start/structure.yml'), $structure);
        return 'saved';
    }
}

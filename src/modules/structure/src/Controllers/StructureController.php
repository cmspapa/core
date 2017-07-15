<?php

namespace Cmspapa\structure\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;

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

}

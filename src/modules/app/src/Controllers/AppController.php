<?php

namespace Cmspapa\app\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Cmspapa\blocks\Traits\RegionsBlocksTrait;

class AppController extends Controller
{
    use RegionsBlocksTrait;

	/**
     * .
     *
     * @return view
     */
    public function index()
    {
        $regions = $this->getRegions();
        return view('app::home', compact('regions'));
    }

}
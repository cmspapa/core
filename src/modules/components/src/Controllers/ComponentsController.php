<?php

namespace Cmspapa\components\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Cmspapa\components\Models\RegionComponent;
use Cmspapa\components\Traits\RegionsComponentsTrait;

class componentsController extends Controller
{
    use RegionsComponentsTrait;

	/**
     * .
     *
     * @return view
     */
    public function index()
    {
        $regions = $this->getRegions();
        $noneRegioncomponents = $this->getNoneRegioncomponents();
        return view('components::index', compact('regions', 'noneRegioncomponents'));
    }

    /**
     * .
     *
     * @return response
     */
    public function save(Request $request)
    {
        foreach ($request->region as $componentId => $regionId) {
            $regionComponent = RegionComponent::where('component_id', $componentId)->first();
            if(!$regionComponent){
                $regionComponent = new RegionComponent;
            }
            if($regionId){
                $regionComponent->region_id = $regionId;
            }else{
                $regionComponent->region_id = 0;
            }
            $regionComponent->component_id = $componentId;
            if(isset($request->order[$componentId])){
               $regionComponent->order = $request->order[$componentId]; 
            }
            $regionComponent->save();
        }
        //@todo return message 
        return back();
    }
}

<?php

namespace Cmspapa\blocks\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Cmspapa\blocks\Models\RegionBlock;
use Cmspapa\blocks\Traits\RegionsBlocksTrait;

class blocksController extends Controller
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
        $noneRegionblocks = $this->getNoneRegionblocks();
        return view('blocks::index', compact('regions', 'noneRegionblocks'));
    }

    /**
     * .
     *
     * @return response
     */
    public function save(Request $request)
    {
        foreach ($request->region as $blockId => $regionId) {
            $regionBlock = RegionBlock::where('block_id', $blockId)->first();
            if(!$regionBlock){
                $regionBlock = new RegionBlock;
            }
            if($regionId){
                $regionBlock->region_id = $regionId;
            }else{
                $regionBlock->region_id = 0;
            }
            $regionBlock->block_id = $blockId;
            if(isset($request->order[$blockId])){
               $regionBlock->order = $request->order[$blockId]; 
            }
            $regionBlock->save();
        }
        //@todo return message 
        return back();
    }
}

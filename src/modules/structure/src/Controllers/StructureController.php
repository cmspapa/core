<?php

namespace Cmspapa\structure\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Symfony\Component\Yaml\Yaml;
use Cmspapa\components\Models\RegionComponent;
use Cmspapa\components\Traits\RegionsComponentsTrait;

class StructureController extends Controller
{
    use RegionsComponentsTrait;
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

    /**
     * Temp Ajax get structure with components.
     *
     * @return json
     */
    public function getStructureWithComponents()
    {
        // Get structure
        $structure = Yaml::parse(file_get_contents(base_path('themes/start/structure.yml')));
        foreach ($structure as $key => $structureComponent) {
            $structure[$key]['components'] = [];
            if(isset($structureComponent['is_region']) && $structureComponent['is_region'] == 'true'){
                // Check for level one components
                $structure[$key]['components'] = $this->getRegionComponents($key);
            }

            if(($structureComponent['type'] == 'container' || $structureComponent['type'] == 'container-fluid') && isset($structureComponent['level_two'])){
                foreach ($structureComponent['level_two'] as $keyLevelTwo => $structureComponentLevelTwo) {
                    // Check if row
                    if($structureComponentLevelTwo['type'] == 'row'){
                        foreach ($structureComponentLevelTwo['columns'] as $columnKey => $column) {
                            $structure[$key]['level_two'][$keyLevelTwo]['columns'][$columnKey]['components'] = [];
                            if(isset($column['is_region'])){
                                $structure[$key]['level_two'][$keyLevelTwo]['columns'][$columnKey]['components'] = $this->getRegionComponents($columnKey);
                            }
                        }
                    }
                }
            }
        }

        return $structure;
    }

    /**
     * get region components.
     *
     * @return array
     */
    public function getRegionComponents($regionId)
    {
        $components = [];
        $regioncomponents = RegionComponent::where('region_id', $regionId)->select('component_id')->orderBy('order', 'ASC')->get();
        if($regioncomponents->count()){
            foreach ($regioncomponents as $regionComponent) {
                $components[] = $this->getComponentInfoById($regionComponent->component_id)['name'];
            }
        }
        return $components;
    }
}

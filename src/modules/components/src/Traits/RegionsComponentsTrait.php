<?php

namespace Cmspapa\components\Traits;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Symfony\Component\Yaml\Yaml;
use Cmspapa\components\Models\RegionComponent;

trait RegionsComponentsTrait
{
    /**
     * @todo move this function.
     *
     * @return array
     */
    public function getModules()
    {
        // @todo refactor
        $coreModules = array_filter(glob(__DIR__.'/modules/*'));
        $appModules = array_filter(glob(base_path('modules').'/*'));
        return array_merge($coreModules, $appModules);
    }

    /**
     * .
     *
     * @return array
     */
    public function getRegionsCollection()
    {
        $regions = [];
        $themePath = base_path('themes/'.config('app.app_theme'));
        $themeStructure = Yaml::parse(file_get_contents($themePath.'/structure.yml'));
        $regionsCount = 0;
        foreach ($themeStructure as $componentKey => $component) {
            // Get level one regions if any
            if(isset($component['is_region']) && $component['is_region'] == true){
                $regions[$regionsCount]['id'] = $componentKey;
                if(isset($component['region_name'])){
                    $regions[$regionsCount]['name'] = $component['region_name'];
                }
                $regionsCount++;
            }
            // Get level two regions if any
            if(isset($component['level_two'])){
                foreach ($component['level_two'] as $levelTwoComponentKey => $levelTwoComponent) {
                    if(isset($levelTwoComponent['is_region']) && $levelTwoComponent['is_region'] == true){
                        $regions[$regionsCount]['id'] = $levelTwoComponentKey;
                        if(isset($levelTwoComponent['region_name'])){
                            $regions[$regionsCount]['name'] = $levelTwoComponent['region_name'];
                        }
                        $regionsCount++;
                    }
                    // Custom case for row columns
                    if(isset($levelTwoComponent['type']) && $levelTwoComponent['type'] == 'row'){
                        if(isset($levelTwoComponent['columns'])){
                            // Loop through columns to get regions
                            foreach ($levelTwoComponent['columns'] as $columnComponentKey => $columnComponent) {
                                if(isset($columnComponent['is_region']) && $columnComponent['is_region'] == true){
                                    $regions[$regionsCount]['id'] = $columnComponentKey;
                                    if(isset($columnComponent['region_name'])){
                                        $regions[$regionsCount]['name'] = $columnComponent['region_name'];
                                    }
                                    $regionsCount++;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $regions;
    }

    /**
     * .
     *
     * @return array
     */
    public function getRegions()
    {
        $regions = [];
        foreach ($this->getRegionsCollection() as $key => $region) {
            $regions[$key]['id'] = $region['id'];
            if(isset($region['name']) && !empty($region['name'])){
                $regions[$key]['name'] = $region['name'];
            }
            $regions[$key]['components'] = $this->getRegionComponents($region['id']);
        }
        return $regions;
    }

    /**
     * .
     *
     * @return array
     */
    public function getComponents()
    {
        foreach ($this->getModules() as $module) {
            $moduleName = basename($module);
            $componentsPaths = glob($module.'/src/vue/*.vue');
            $components = [];

            if($componentsPaths){
                foreach ($componentsPaths as $key => $component) {
                    $componentId = $moduleName.'_'.str_replace('.vue', '', basename($component));
                    $components[$key]['id'] = $componentId;
                    $components[$key]['name'] = str_replace('.vue', '', basename($component));
                    $components[$key]['module_name'] = $moduleName;
                }
            }
            // Add default component Content
            $components[$key+1]['id'] = 'core_content';
            $components[$key+1]['name'] = 'Content';
            $components[$key+1]['module_name'] = 'core';
            return $components;
        }
    }

    /**
     *
     *
     * @param $regionId integer
     * @return array
     */
    public function getComponentInfoById($componentId)
    {
        // Check for default components "Content"
        if($componentId == 'core_content'){
          $info['name'] = 'Content';
          $info['module_name'] = 'Core';
          return $info;
        }
        foreach ($this->getModules() as $module) {
            $moduleName = basename($module);
            $componentsPaths = glob($module.'/src/vue/*.vue');
            if($componentsPaths){
                foreach ($componentsPaths as $key => $component) {
                    if($componentId == $moduleName.'_'.str_replace('.vue', '', basename($component))){
                        $info['name'] = str_replace('.vue', '', basename($component));
                        $info['module_name'] = $moduleName;
                        return $info;
                    }
                }
            }
        }
    }

    /**
     *
     *
     * @param $regionId integer
     * @return array
     */
    public function getRegionComponents($regionId)
    {
        $components = [];
        $regioncomponents = RegionComponent::where('region_id', $regionId)->select('component_id', 'order')->orderBy('order', 'ASC')->get();
        foreach ($regioncomponents as $key => $regionComponent) {
            $components[$key] = $this->getComponentInfoById($regionComponent->component_id);
            $components[$key]['id'] = $regionComponent->component_id;
            $components[$key]['order'] = $regionComponent->order;
        }
        return $components;
    }

    /**
     *
     *
     * @return array
     */
    public function getNoneRegionComponents()
    {
        $noneRegioncomponents = $this->getComponents();
        foreach ($this->getRegions() as $region) {
            foreach ($region['components'] as $component) {
                foreach ($noneRegioncomponents as $key => $targetComponent) {
                    if($targetComponent['id'] == $component['id']){
                        unset($noneRegioncomponents[$key]);
                    }
                }
            }
        }
        return $noneRegioncomponents;
    }
}

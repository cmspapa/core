<?php

namespace Cmspapa\blocks\Traits;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Symfony\Component\Yaml\Yaml;
use Cmspapa\blocks\Models\RegionBlock;

trait RegionsBlocksTrait
{
    /**
     * .
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
            $regions[$key]['blocks'] = $this->getRegionBlocks($region['id']);
        }
        return $regions;
    }

    /**
     * .
     *
     * @return array
     */
    public function getBlocks()
    {
        foreach ($this->getModules() as $module) {
            $moduleName = basename($module);
            $blocksPaths = glob($module.'/src/block_*');
            $blocks = [];
            if($blocksPaths){
                foreach ($blocksPaths as $key => $block) {
                   $blockId = $moduleName.'_'.basename($block);
                    if(file_exists($block.'/blockController.php')){
                        // @todo refactor
                        $blockContent = new \Cmspapa\mymodule\block_test\blockController;
                        $blockContent = $blockContent->blockContent();
                        $blocks[$key]['id'] = $blockId;
                        $blocks[$key]['module_name'] = $moduleName;
                    }
                    if(file_exists($block.'/info.yml')){
                        $blockInfo = Yaml::parse(file_get_contents($block.'/info.yml'));
                        if(isset($blockInfo['name'])){
                           $blocks[$key]['name'] = $blockInfo['name']; 
                        }
                        if(isset($blockInfo['description'])){
                           $blocks[$key]['description'] = $blockInfo['description']; 
                        }
                    }
                }
            }
            return $blocks;
        }
    }

    /**
     * 
     * 
     * @param $regionId integer
     * @return array
     */
    public function getBlockInfoById($blockId)
    {
        foreach ($this->getModules() as $module) {
            $moduleName = basename($module);
            $blocksPaths = glob($module.'/src/block_*');
            if($blocksPaths){
                foreach ($blocksPaths as $key => $block) {
                    if($blockId == $moduleName.'_'.basename($block) && file_exists($block.'/info.yml')){
                        $info = Yaml::parse(file_get_contents($block.'/info.yml'));
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
    public function getRegionBlocks($regionId)
    {
        $blocks = [];
        $regionBlocks = RegionBlock::where('region_id', $regionId)->select('block_id', 'order')->orderBy('order', 'ASC')->get();
        foreach ($regionBlocks as $key => $regionBlock) {
            $blocks[$key] = $this->getBlockInfoById($regionBlock->block_id);
            $blocks[$key]['id'] = $regionBlock->block_id;
            $blocks[$key]['order'] = $regionBlock->order;
        }
        return $blocks;
    }

    /**
     * 
     * 
     * @return array
     */
    public function getNoneRegionblocks()
    {
        $noneRegionblocks = $this->getBlocks();
        foreach ($this->getRegions() as $region) {
            foreach ($region['blocks'] as $block) {
                foreach ($noneRegionblocks as $key => $targetBlock) {
                    if($targetBlock['id'] == $block['id']){
                        unset($noneRegionblocks[$key]);
                    }
                }
            }
        }
        return $noneRegionblocks;
    }
}

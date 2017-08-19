<?php

namespace Cmspapa\Core\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach ($this->getModules() as $modulePath) {
    		$seeders = glob($modulePath.'/src/database/seeds/*.php');
    		if(count($seeders)){
    			foreach ($seeders as $seeder) {
    				$seederClass = 'Cmspapa\\'.basename($modulePath).'\\Database\\Seeds\\'.basename($seeder, '.php');
    				$this->call($seederClass);
    			}
    		}
    	}
    }

    /**
     * @todo move this function.
     *
     * @return array
     */
    public function getModules()
    {
        // @todo refactor
        $coreModules = array_filter(glob(__DIR__.'/../../modules/*'));
        $appModules = array_filter(glob(base_path('modules').'/*'));
        return array_merge($coreModules, $appModules);
    }
}
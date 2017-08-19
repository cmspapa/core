<?php

namespace Cmspapa\Core\Database\Seeds;

use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Console\Seeds\SeedCommand as IlluminateSeedCommand;

class SeedCommand extends IlluminateSeedCommand
{
    /**
     * Get the console command options.
     * Overide use Illuminate\Database\Console\Seeds\SeedCommand
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the root seeder', '\Cmspapa\Core\Database\Seeds\DatabaseSeeder'],

            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed'],

            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
        ];
    }
}

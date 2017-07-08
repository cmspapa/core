<?php

namespace Cmspapa\install\Controllers;

use Illuminate\Http\Request;
use Cmspapa\Core\Controllers\Controller;
use Artisan;
class InstallController extends Controller
{
	/**
     * Init Install.
     *
     * @return redirect
     */
    public function install()
    {
    	// Create .env file
    	if(!file_exists(base_path('.env'))){
            //return redirect('/install');
            copy(base_path('.env.example'), base_path('.env'));
        }
    	return redirect('/install-verify-requirments');
    }

    /**
     * Verify CMS requirments.
     *
     * @return redirect
     */
    public function verifyRequirments()
    {
    	return redirect('/install-setup-database');
    }

	/**
     * Provide form to fill database information.
     *
     * @return view
     */
    public function getSetupDatabase()
    {
    	return view('install::install_setup_database');
    }

    /**
     * Post information and create .env file.
     *
     * @return redirect
     */
    public function postSetupDatabase(Request $request)
    {
	    $path = base_path('.env');

	    // @todo check foreach database and add its settings

	    if (file_exists($path)) {
	    	// DB connection
		    file_put_contents($path, str_replace(
		        'DB_CONNECTION='.config('database.default'), 'DB_CONNECTION='.$request->db_connection, file_get_contents($path)
		    ));

		    // DB host
		    file_put_contents($path, str_replace(
		        'DB_HOST='.config('database.connections.'.config('database.default').'.host'), 'DB_HOST='.$request->db_host, file_get_contents($path)
		    ));

		    // DB port
		    file_put_contents($path, str_replace(
		        'DB_PORT='.config('database.connections.'.config('database.default').'.port'), 'DB_PORT='.$request->db_port, file_get_contents($path)
		    ));

		    // DB name
		    file_put_contents($path, str_replace(
		        'DB_DATABASE='.config('database.connections.'.config('database.default').'.database'), 'DB_DATABASE='.$request->db_name, file_get_contents($path)
		    ));

		    // DB username
		    file_put_contents($path, str_replace(
		        'DB_USERNAME='.config('database.connections.'.config('database.default').'.username'), 'DB_USERNAME='.$request->db_username, file_get_contents($path)
		    ));

		    // DB password
		    file_put_contents($path, str_replace(
		        'DB_PASSWORD='.config('database.connections.'.config('database.default').'.password'), 'DB_PASSWORD='.$request->db_password, file_get_contents($path)
		    ));
		}

		return redirect('/install-papa-dependencies');
    }

    /**
     * Provide install progress bar for papa dependencies.
     *
     * @return view
     */
    public function getPapaDependencies()
    {
    	// Install modules
    	Artisan::call('cache:clear');
    	//Artisan::call('migrate', array('--path' => 'modules/install/src/database/migrations', '--force' => true));
    	//temp
    	return redirect('/install-configure-site');//
    	return view('install::install_papa_dependencies');
    }

    /**
     * Post install papa dependencies.
     *
     * @return redirect
     */
    public function postPapaDependencies(Request $request)
    {
    	

		return redirect('/install-configure-site');
    }

    /**
     * Provide form to fill site information.
     *
     * @return view
     */
    public function getConfigureSite()
    {
    	//temp
    	return redirect('/install-finished');//
    	return view('install::install_configure_site');
    }

    /**
     * Post information and create .env file.
     *
     * @return redirect
     */
    public function postConfigureSite(Request $request)
    {

		return redirect('/install-finished');
    }

    /**
     * View that contains some information about cms and quick links.
     *
     * @return view
     */
    public function getFinished()
    {
    	return view('install::install_finished');
    }
}

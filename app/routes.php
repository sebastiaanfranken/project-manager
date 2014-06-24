<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
 * Route to the frontpage
 */
Route::get('/', function() {
	if(!Auth::check())
	{
		return Redirect::guest('login');
	}
	else
	{
		/*
		 * Stores view data
		 */
		$data = array();

		/*
		 * Stores messages
		 */
		$messages = array();

		/*
		 * Gets the tasks and adds it to the $data array
		 */
		$data['tasks'] = Task::where('user_id', '=', Auth::user()->id)->paginate(15);

		/*
		 * Get the projects and add them to the $data array
		 */
		$data['projects'] = User::find(Auth::user()->id)->projects()->paginate(15);

		/*
		 * A timestamp to check the project and tasks date against
		 */
		$timestamp = new DateTime('now', new DateTimeZone('Europe/Amsterdam'));

		/*
		 * Loop over all tasks and check the date
		 */
		foreach($data['tasks'] as $task)
		{
			if(!is_null($task->end_date))
			{
				$end = new DateTime($task->end_date, new DateTimeZone('Europe/Amsterdam'));

				if($task->completion < 100 && $end->format('Y') == $timestamp->format('Y') && $end->format('m') == $timestamp->format('m') && $end->format('d') - $timestamp->format('d') <= 5)
				{
					$messages[] = 'De taak <em>' . $task->name . '</em> moet binnenkort af zijn.';
				}
			}
		}

		/*
		 * Loop over all projects and check the date
		 */
		foreach($data['projects'] as $project)
		{
			$end = new DateTime($project->end_date, new DateTimeZone('Europe/Amsterdam'));

			if($end->format('Y') == $timestamp->format('Y') && $end->format('m') && $timestamp->format('m') && $end->format('d') - $timestamp->format('d') <= 30)
			{
				$messages[] = 'Het project <em>' . $project->name . '</em> moet binnen 30 dagen af zijn.';
			}
		}

		/*
		 * Check if we have messages and if so display them to the user.
		 */
		if(count($messages) > 0)
		{
			$inner = '<ul>';

			foreach($messages as $message)
			{
				$inner .= '<li>' . $message . '</li>';
			}

			$inner .= '</ul>';

			flash($inner, 'warning');
		}

		return View::make('layouts/main')->nest('content', 'frontpage', $data);
	}
});

/*
 * This handles the HTTP GET login
 */
Route::get('login', function() {
	return View::make('layouts/login');
});

/*
 * This handles the HTTP POST login
 */
Route::post('login', function() {
	$username = Input::get('username');
	$password = Input::get('password');

	if(Auth::attempt(array('username' => $username, 'password' => $password)))
	{
		return Redirect::intended('/');
	}
	else
	{
		return Redirect::to('login');
	}
});

/*
 * This handles the HTTP POST logout
 */
Route::get('logout', function() {
	if(Auth::check())
	{
		Auth::logout();
	}

	return Redirect::to('/');
});

/**
 * This route group handles all task related things
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */
Route::group(array('prefix' => 'task', 'before' => 'auth'), function() {

	/*
	 * The frontpage
	 */
	Route::get('/', 'TaskController@getIndex');

	/*
	 * Handles the HTTP GET for creating a task
	 */
	Route::get('create/{userid?}/{projectid?}', 'TaskController@getCreate');

	/*
	 * Handles the HTTP POST for creating a task
	 */
	Route::post('create/{userid?}/{projectid?}', 'TaskController@postCreate');

	/*
	 * Handles teh HTTP GET for updating a task
	 */
	Route::get('update/{taskid?}', 'TaskController@getUpdate');

	/*
	 * Handles the HTTP POST for updating a task
	 */
	Route::post('update/{taskid?}', 'TaskController@postUpdate');

	/*
	 * Handles the HTTP GET for deleting a task
	 */
	Route::get('delete/{taskid?}', 'TaskController@getDelete');

	/*
	 * Handles the HTTP POST for deleting a task
	 */
	Route::post('delete/{taskid?}', 'TaskController@postDelete');

	/*
	 * Handles the HTTP GET for details of a task
	 */
	Route::get('details/{taskid?}', 'TaskController@getDetails');

	/*
	 * Handles the HTTP GET for listing all completed tasks
	 */
	Route::get('completed', 'TaskController@getCompleted');
});

/**
 * This route group handles all project related routes
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */
Route::group(array('prefix' => 'project', 'before' => 'auth'), function() {

	/*
	 * The frontpage
	 */
	Route::get('/', 'ProjectController@getIndex');

	/*
	 * Handles the HTTP GET for creating a project
	 */
	Route::get('create', 'ProjectController@getCreate');

	/*
	 * Handles the HTTP POST for creating a project
	 */
	Route::post('create', 'ProjectController@postCreate');

	/*
	 * Handles the HTTP GET for updating a project
	 */
	Route::get('update/{projectid?}', 'ProjectController@getUpdate');

	/*
	 * Handles the HTTP POST for updating a project
	 */
	Route::post('update/{projectid?}', 'ProjectController@postUpdate');

	/*
	 * Handles the HTTP GET for deleting a project
	 */
	Route::get('delete/{projectid?}', 'ProjectController@getDelete');

	/*
	 * Handles the HTTP POST for deleting a project
	 */
	Route::post('delete/{projectid?}', 'ProjectController@postDelete');

	/*
	 * Handles the HTTP POST for details of a project
	 */
	Route::get('details/{projectid?}', 'ProjectController@getDetails');
});

/**
 * This route group handles all user related things
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */
Route::group(array('prefix' => 'user', 'before' => 'auth'), function() {

	/*
	 * The front page
	 */
	Route::get('/', 'UserController@getIndex');

	/*
	 * Handles the HTTP GET for changing your password
	 */
	Route::get('password', 'UserController@getPassword');

	/*
	 * Handles the HTTP POST for changing your password
	 */
	Route::post('password', 'UserController@postPassword');

	/*
	 * Handles the HTTP GET for listing all users
	 */
	Route::get('users', array('before' => 'roleAdmin', 'uses' => 'UserController@getUsers'));

	/*
	 * Handles the HTTP GET for creating a user
	 */
	#Route::get('create', 'UserController@getCreate');
	Route::get('create', array('before' => 'roleAdmin', 'uses' => 'UserController@getCreate'));

	/*
	 * Handles the HTTP POST for creating a user
	 */
	#Route::post('create', 'UserController@postCreate');
	Route::post('create', array('before' => 'roleAdmin', 'uses' => 'UserController@postCreate'));

	/*
	 * Handles the HTTP GET for updating a user
	 */
	#Route::get('update/{userid?}', 'UserController@getUpdate');
	Route::get('update/{userid?}', array('before' => 'roleAdmin', 'uses' => 'UserController@getUpdate'));

	/*
	 * Handles the HTTP POST for updating a user
	 */
	#Route::post('update/{userid?}', 'UserController@postUpdate');
	Route::post('update/{userid?}', array('before' => 'roleAdmin', 'uses' => 'UserController@postUpdate'));

	/*
	 * Handles the HTTP GET for deleting a user
	 */
	#Route::get('delete/{userid?}', 'UserController@getDelete');
	Route::get('delete/{userid?}', array('before' => 'roleAdmin', 'uses' => 'UserController@getDelete'));

	/*
	 * Handles the HTTP POST for deleting a user
	 */
	#Route::post('delete/{userid?}', 'UserController@postDelete');
	Route::post('delete/{userid?}', array('before' => 'roleAdmin', 'uses' => 'UserController@postDelete'));

	/*
	 * Handles the HTTP GET for importing objects
	 */
	#Route::get('import', 'UserController@getImport');
	Route::get('import', array('before' => 'roleAdmin', 'uses' => 'UserController@getImport'));

	/*
	 * Handles the HTTP POST for importing objects
	 */
	#Route::get('import', 'UserController@postImport');
	Route::post('import', array('before' => 'roleAdmin', 'uses' => 'UserController@postImport'));

	/*
	 * Handles the HTTP GET for exporting objects
	 */
	#Route::get('export', 'UserController@getExport');
	Route::get('export', array('before' => 'roleAdmin', 'uses' => 'UserController@getExport'));

	/*
	 * Handles the HTTP POST for exporting objects
	 */
	#Route::post('export', 'UserController@postExport');
	Route::post('export', array('before' => 'roleAdmin', 'uses' => 'UserController@postExport'));
});

/*
 * This routegroup handles all things dashboard
 */
Route::group(array('prefix' => 'dashboard', 'before' => array('auth', 'roleAdmin')), function() {

	/*
	 * Handles the HTTP GET for the main dashboard index
	 */
	Route::get('/', 'DashboardController@getIndex');

	/*
	 * Handles the HTTP GET to list all users
	 */
	Route::get('users', 'DashboardController@getUsers');

	/*
	 * Handles the HTTP GET to create a user
	 */
	Route::get('users/create', 'DashboardController@getCreateUser');

	/*
	 * Handles the HTTP POST to create a user
	 */
	Route::post('users/create', 'DashboardController@postCreateUser');

	/*
	 * Handles the HTTP GET to update a user
	 */
	Route::get('users/update/{userid?}', 'DashboardController@getUpdateUser');

	/*
	 * Handles the HTTP POST to update a user
	 */
	Route::post('users/update/{userid?}', 'DashboardController@postUpdateUser');

	/*
	 * Handles the HTTP GET to delete a user
	 */
	Route::get('users/delete/{userid?}', 'DashboardController@getDeleteUser');

	/*
	 * Handles the HTTP POST to delete a user
	 */
	Route::post('users/delete/{userid?}', 'DashboardController@postDeleteUser');

	/*
	 * Handles the HTTP GET to import data into the system
	 */
	Route::get('import', 'DashboardController@getImport');

	/*
	 * Handles the HTTP POST to import data into the system
	 */
	Route::post('import', 'DashboardController@postImport');

	/*
	 * Handles the HTTP GET to export data out of the system
	 */
	Route::get('export', 'DashboardController@getExport');

	/*
	 * Handles the HTTP POST to export data out of the system
	 */
	Route::post('export', 'DashboardController@postExport');
});

/*
 * The clean route cleans all tables of all data
 * USE WITH CAUTION
 */
Route::get('clean', array('before' => array('auth', 'roleAdmin'), function() {
	return View::make('layouts/main')->nest('content', 'clean');
}));

Route::post('clean', array('before' => array('auth', 'roleAdmin'), function() {

	/*
	 * Inform the remaining user what just happened ... 
	 */
	flash('Deze functionaliteit is nog niet ge&iuml;mplementeerd', 'warning');

	/*
	 * ... and redirect him/her home
	 */
	return Redirect::to('/');

}));

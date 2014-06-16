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
		$data = array(
			'tasks' => Task::where('user_id', '=', Auth::user()->id)->paginate(15),
			'projects' => User::find(Auth::user()->id)->projects()->paginate(15)
		);

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
	Route::get('users', 'UserController@getUsers');

	/*
	 * Handles the HTTP GET for creating a user
	 */
	Route::get('create', 'UserController@getCreate');

	/*
	 * Handles the HTTP POST for creating a user
	 */
	Route::post('create', 'UserController@postCreate');

	/*
	 * Handles the HTTP GET for updating a user
	 */
	Route::get('update/{userid?}', 'UserController@getUpdate');

	/*
	 * Handles the HTTP POST for updating a user
	 */
	Route::post('update/{userid?}', 'UserController@postUpdate');

	/*
	 * Handles the HTTP GET for deleting a user
	 */
	Route::get('delete/{userid?}', 'UserController@getDelete');

	/*
	 * Handles the HTTP POST for deleting a user
	 */
	Route::post('delete/{userid?}', 'UserController@postDelete');

	/*
	 * Handles the HTTP GET for importing objects
	 */
	Route::get('import', 'UserController@getImport');

	/*
	 * Handles the HTTP POST for importing objects
	 */
	Route::get('import', 'UserController@postImport');

	/*
	 * Handles the HTTP GET for exporting objects
	 */
	Route::get('export', 'UserController@getExport');

	/*
	 * Handles the HTTP POST for exporting objects
	 */
	Route::post('export', 'UserController@postExport');
});

/*
 * The clean route cleans all tables of all data
 * USE WITH CAUTION
 */
Route::get('clean', array('before' => array('auth', 'isAdmin'), function() {
	return View::make('layouts/main')->nest('content', 'clean');
}));

Route::post('clean', array('before' => array('auth', 'isAdmin'), function() {

	/*
	 * Inform the remaining user what just happened ... 
	 */
	flash('Deze functionaliteit is nog niet ge&iuml;mplementeerd', 'warning');

	/*
	 * ... and redirect him/her home
	 */
	return Redirect::to('/');

}));
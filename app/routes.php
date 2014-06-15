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
	Route::get('create/{projectid?}/{userid?}', 'TaskController@getCreate');

	/*
	 * Handles the HTTP POST for creating a task
	 */
	Route::post('create/{projectid?}/{userid?}', 'TaskController@postCreate');

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

/**
 * The setup route.
 * @todo Remove this after first-run
 */
Route::get('setup', function() {

	/*
	 * Make a new user
	 */
	$user = new User;
	$user->username = 'admin';
	$user->password = Hash::make('@welkom1');
	$user->save();

	$user = new User;
	$user->username = 'member';
	$user->password = Hash::make('@member1');
	$user->save();

	/*
	 * Make two dummy projects
	 */
	$project = new Project;
	$project->name = 'Test project 1';
	$project->description = 'Het 1e test project';
	$project->start_date = (new DateTime('now', new DateTimeZone('Europe/Amsterdam')))->format('Y-m-d');
	$project->end_date = (new DateTime('01-01-2020', new DateTimeZone('Europe/Amsterdam')))->format('Y-m-d');
	$project->save();

	$project = new Project;
	$project->name = 'Test project 2';
	$project->description = 'Het 2e test project';
	$project->start_date = (new DateTime('now', new DateTimeZone('Europe/Amsterdam')))->format('Y-m-d');
	$project->end_date = null;
	$project->save();

	echo 'Done';
});

/**
 * The debug route
 * @todo Remove this
 */
Route::get('debug', function() {
	$projects = Project::all();
	$users = User::all();
	$tasks = Task::all();

	echo '<h1>Projecten</h1>';
	foreach($projects as $project)
	{
		$fields = array();
		$fields['id'] = $project->id;
		$fields['name'] = $project->name;

		if($project->users->count())
		{
			$fields['users'] = array();

			foreach($project->users as $user)
			{
				$fields['users'][] = $user->username;
			}
		}

		print '<pre>' . print_r($fields, true) . '</pre>';
	}

	echo '<h1>Gebruikers</h1>';
	foreach($users as $user)
	{
		$fields = array();
		$fields['id'] = $user->id;
		$fields['username'] = $user->username;

		if($user->projects->count())
		{
			$fields['projects'] = array();

			foreach($user->projects as $project)
			{
				$fields['projects'][] = $project->name;
			}
		}

		if($user->tasks->count())
		{
			$fields['tasks'] = array();

			foreach($user->tasks as $task)
			{
				$fields['tasks'][] = $task->name;
			}
		}

		print '<pre>' . print_r($fields, true) . '</pre>';
	}

	echo '<h1>Taken</h1>';
	foreach($tasks as $task)
	{
		$fields = array();
		$fields['id'] = $task->id;
		$fields['name'] = $task->name;

		if($task->project->count())
		{
			$fields['project'] = array('id' => $task->project->id, 'name' => $task->project->name);
		}

		if($task->user->count())
		{
			$fields['user'] = array('id' => $task->user->id, 'username' => $task->user->username);
		}

		print '<pre>' . print_r($fields, true) . '</pre>';
	}
});
<?php

/**
 * The TaskController handles all tasks related to, well, tasks
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */

class TaskController extends BaseController
{

	/*
	 * The tasks starting page
	 */
	public function getIndex()
	{
		$data = array(
			'tasks' => Task::where('user_id', '=', Auth::user()->id)->paginate(15)
		);

		return View::make('layouts/main')->nest('content', 'task/index', $data);
	}

	/*
	 * Shows the view to create a task
	 */
	public function getCreate($userid = null, $projectid = null)
	{
		/*
		 * Stores all the users
		 */
		$users = array();

		/*
		 * Stores all the projects
		 */
		$projects = array();

		/*
		 * Loops over all users and stores their ID and username
		 */
		foreach(User::all() as $user)
		{
			$users[$user->id] = $user->username;
		}

		/*
		 * Loops over all projects and store their ID's and names
		 */
		foreach(Project::all() as $project)
		{
			$projects[$project->id] = $project->name;
		}

		/*
		 * View data
		 */
		$data = array(
			'users' => $users,
			'projects' => $projects,
			'project_id' => (is_null($projectid) ? null : $projectid),
			'user_id' => (is_null($userid) ? null : $userid),
		);

		return View::make('layouts/main')->nest('content', 'task/create', $data);
	}

	/*
	 * Handles the creation of a task
	 */
	public function postCreate($userid = null, $projectid = null)
	{
		$rules = array(
			'project_id' => array('required'),
			'user_id' => array('required'),
			'name' => array('required', 'min:3', 'max:100'),
			'description' => array('required', 'min:5', 'max:200'),
			'start_date' => array('required', 'date', 'date_format:d-m-Y'),
			'end_date' => array('date', 'date_format:d-m-Y', 'different:start_date')
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::action('TaskController@getCreate')->withErrors($validator)->withInput(Input::all());
		}
		else
		{
			$task = new Task;
			$task->project_id = Input::get('project_id');
			$task->user_id = Input::get('user_id');
			$task->completion = 0;
			$task->name = Input::get('name');
			$task->description = Input::get('description');
			$task->start_date = timestamp(Input::get('start_date'), null, 'Y-m-d');

			if(Input::has('end_date'))
			{
				$task->end_date = timestamp(Input::get('end_date'), null, 'Y-m-d');
			}
			else
			{
				$task->end_date = null;
			}

			$task->save();

			//Session::flash('message', 'De taak is opgeslagen.');
			flash('De taak ' . Input::geT('name') . ' is opgeslagen.', 'success');

			return Redirect::action('TaskController@getIndex');
		}
	}

	/**
	 * Shows the view to update a task
	 * @todo Make use of the one-to-many relationship instead of querying it like this. See if that makes sense
	 */
	public function getUpdate($taskid = null)
	{
		if(!is_null($taskid) && Task::where('id', '=', $taskid)->where('user_id', '=', Auth::user()->id)->first()->user_id == Auth::user()->id)
		{
			/*
			 * Stores all users
			 */
			$users = array();

			/*
			 * Stores all projects
			 */
			$projects = array();

			/*
			 * Loop over all users
			 */
			foreach(User::all() as $user)
			{
				$users[$user->id] = $user->username;
			}

			/*
			 * Loop over all projects
			 */
			foreach(Project::all() as $project)
			{
				$projects[$project->id] = $project->name;
			}

			/*
			 * View variables
			 */
			$data = array(
				'users' => $users,
				'projects' => $projects,
				'task' => Task::find($taskid)
			);

			return View::make('layouts/main')->nest('content', 'task/update', $data);
		}

		return Redirect::action('TaskController@getDetails', array($taskid));
	}

	/*
	 * Handles the updating of a task
	 */
	public function postUpdate($taskid = null)
	{
		if(!is_null($taskid) && Task::where('id', '=', $taskid)->where('user_id', '=', Auth::user()->id)->first()->user_id == Auth::user()->id)
		{
			$rules = array(
				'project_id' => array('required'),
				'user_id' => array('required'),
				'completion' => array('required', 'min:0', 'max:100'),
				'name' => array('required', 'min:3', 'max:100'),
				'description' => array('required', 'min:5', 'max:200'),
				'start_date' => array('required', 'date', 'date_format:d-m-Y'),
				'end_date' => array('date', 'date_format:d-m-Y', 'different:start_date')
			);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails())
			{
				return Redirect::action('TaskController@getUpdate', array($taskid))->withErrors($validator)->withInput(Input::all());
			}
			else
			{
				$task = Task::find($taskid);
				$task->project_id = Input::get('project_id');
				$task->user_id = Input::get('user_id');
				$task->completion = Input::get('completion');
				$task->name = Input::get('name');
				$task->description = Input::get('description');
				$task->start_date = timestamp(Input::get('start_date'), null, 'Y-m-d');

				if(Input::has('end_date'))
				{
					$task->end_date = timestamp(Input::get('end_date'), null, 'Y-m-d');
				}
				else
				{
					$task->end_date = null;
				}

				$task->save();

				//Session::flash('message', 'De taak is opgeslagen.');
				flash('De taak ' . Input::get('name') . ' is opgeslagen.', 'success');

				return Redirect::action('TaskController@getIndex');
			}
		}

		return Redirect::action('TaskController@getIndex');
	}

	/*
	 * Shows the view to delete a task
	 */
	public function getDelete($taskid = null)
	{
		if(!is_null($taskid) && Task::where('id', '=', $taskid)->where('user_id', '=', Auth::user()->id)->first()->user_id == Auth::user()->id)
		{
			$data = array(
				'task' => Task::find($taskid)
			);

			return View::make('layouts/main')->nest('content', 'task/delete', $data);
		}

		return Redirect::action('TaskController@getDetails', array($taskid));
	}

	/*
	 * Handles the deleting of a task
	 */
	public function postDelete($taskid = null)
	{
		if(!is_null($taskid) && Task::where('id', '=', $taskid)->where('user_id', '=', Auth::user()->id)->first()->user_id == Auth::user()->id)
		{
			$task = Task::find($taskid);
			$name = $task->name;
			$task->delete();

			//Session::flash('message', 'De taak is verwijderd.');
			flash('De taak ' . $name . ' is verwijderd.', 'success');
		}

		return Redirect::action('TaskController@getIndex');
	}

	/*
	 * Handles the details of a project
	 */
	public function getDetails($taskid = null)
	{
		if(!is_null($taskid) && Task::where('id', '=', $taskid)->where('user_id', '=', Auth::user()->id)->first()->user_id == Auth::user()->id)
		{
			/*
			 * Get the task data
			 */
			$task = Task::find($taskid);

			$data = array(
				'task' => $task,
				'user' => User::find($task->user_id)->username,
				'project' => Project::find($task->project_id)->name
			);

			return View::make('layouts/main')->nest('content', 'task/details', $data);
		}

		return Redirect::action('TaskController@getIndex');
	}
}
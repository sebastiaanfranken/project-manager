<?php

/**
 * The projectcontroller handles all tasks related to projects
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */
class ProjectController extends BaseController
{
	/*
	 * The project starting page
	 */
	public function getIndex()
	{
		$data = array(
			'projects' => User::find(Auth::user()->id)->projects()->orderBy('id')->paginate(15)
		);

		return View::make('layouts/main')->nest('content', 'project/index', $data);
	}

	/*
	 * Shows the view to create a project
	 */
	public function getCreate()
	{
		/*
		 * Stores all the users
		 */
		$users = array();

		/*
		 * Loops over all users and stores their ID and username
		 */
		foreach(User::all() as $user)
		{
			$users[] = array(
				'id' => $user->id,
				'username' => $user->username
			);
		}

		/*
		 * View data
		 */
		$data = array(
			'users' => $users
		);

		return View::make('layouts/main')->nest('content', 'project/create', $data);
	}

	/*
	 * Handles the creation of a project
	 */
	public function postCreate()
	{
		$rules = array(
			'name' => array('required'),
			'description' => array('required', 'min:10', 'max:100'),
			'members' => array('required'),
			'start_date' => array('required', 'date', 'date_format:d-m-Y'),
			'end_date' => array('date', 'date_format:d-m-Y', 'different:start_date')
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::action('ProjectController@getCreate')->withErrors($validator)->withInput(Input::all());
		}
		else
		{
			$project = new Project;
			$project->name = Input::get('name');
			$project->description = Input::get('description');
			$project->start_date = timestamp(Input::get('start_date'), null, 'Y-m-d');

			if(Input::has('end_date'))
			{
				$project->end_date = timestamp(Input::get('end_date'), null, 'Y-m-d');
			}
			else
			{
				$project->end_date = null;
			}

			$project->save();

			foreach(Input::get('members') as $counter => $user)
			{
				$pivot = Project::find($project->id);
				$pivot->users()->attach($user);
			}

			Session::flash('message', 'Het project is opgeslagen.');

			return Redirect::action('ProjectController@getIndex');
		}
	}

	/*
	 * Shows the view to update a project
	 */
	public function getUpdate($projectid = null)
	{
		if(!is_null($projectid) && User::find(Auth::user()->id)->projects()->where('project_id', '=', $projectid)->count())
		{
			/*
			 * Stores all users
			 */
			$users = array();

			/*
			 * Loops over all users and stores their id and username
			 */
			foreach(User::all() as $user)
			{
				$users[] = array(
					'id' => $user->id,
					'username' => $user->username,
					'member' => User::find($user->id)->projects()->wherePivot('project_id', '=', $projectid)->count()
				);
			}

			/*
			 * View data
			 */
			$data = array(
				'project' => Project::find($projectid),
				'users' => $users,
				'tasks' => Task::where('project_id', '=', $projectid)->where('completion', '<', 100)->get()
			);

			return View::make('layouts/main')->nest('content', 'project/update', $data);
		}

		return Redirect::action('ProjectController@getIndex');
	}

	/*
	 * Handles the updating of a project
	 */
	public function postUpdate($projectid = null)
	{
		if(!is_null($projectid) && User::find(Auth::user()->id)->projects()->where('project_id', '=', $projectid)->count())
		{
			$rules = array(
				'name' => array('required'),
				'description' => array('required', 'min:10', 'max:100'),
				'members' => array('required'),
				'start_date' => array('required', 'date', 'date_format:d-m-Y'),
				'end_date' => array('date', 'date_format:d-m-Y')
			);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails())
			{
				return Redirect::action('ProjectController@getUpdate', array($projectid))->withErrors($validator)->withInput(Input::all());
			}
			else
			{
				$project = Project::find($projectid);
				$project->name = Input::get('name');
				$project->description = Input::get('description');
				$project->start_date = timestamp(Input::get('start_date'), null, 'Y-m-d');

				if(Input::has('end_date'))
				{
					$project->end_date = timestamp(Input::get('end_date'), null, 'Y-m-d');
				}
				else
				{
					$project->end_date = null;
				}

				$project->save();

				foreach(Input::get('members') as $member)
				{

					/*
					 * This isn't very nice but right now it's the only way
					 * to make it work reliably
					 */
					$pivot = Project::find($projectid);
					$pivot->users()->detach();
					$pivot->users()->attach($member);

				}

				Session::flash('message', 'Het project is opgeslagen.');

				return Redirect::action('ProjectController@getIndex');
			}
		}

		return Redirect::action('ProjectController@getIndex');
	}

	/*
	 * Shows the delete view
	 */
	public function getDelete($projectid = null)
	{
		if(!is_null($projectid) && User::find(Auth::user()->id)->projects()->where('project_id', '=', $projectid)->count())
		{
			$data = array(
				'projectid' => $projectid,
				'tasks' => Task::where('project_id', '=', $projectid)
			);

			return View::make('layouts/main')->nest('content', 'project/delete', $data);
		}

		return Redirect::action('ProjectController@getDetails', array($projectid));
	}

	/*
	 * Handles the deleting of a project
	 */
	public function postDelete($projectid = null)
	{
		if(!is_null($projectid) && User::find(Auth::user()->id)->projects()->where('project_id', '=', $projectid)->count())
		{
			/*
			 * Delete all project_user references first
			 */
			$pivot = Project::find($projectid)->users();
			$pivot->detach();

			/*
			 * Delete all tasks
			 */
			$tasks = Task::where('project_id', '=', $projectid);
			$tasks->delete();

			/*
			 * Delete the project now
			 */
			$project = Project::find($projectid);
			$project->delete();

			Session::flash('message', 'Het project (en taken) is verwijderd.');
		}

		return Redirect::action('ProjectController@getDetails', array($projectid));
	}

	/*
	 * Shows the details of a project
	 */
	public function getDetails($projectid = null)
	{
		if(!is_null($projectid) && User::find(Auth::user()->id)->projects()->where('project_id', '=', $projectid)->count())
		{
			$data = array(
				'project' => Project::find($projectid),
				'tasks' => Task::where('project_id', '=', $projectid)->get()
			);

			return View::make('layouts/main')->nest('content', 'project/details', $data);
		}

		return Redirect::action('ProjectController@getIndex');
	}
}
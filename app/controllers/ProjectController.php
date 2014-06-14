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
			$users[$user->id] = $user->username;
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
		if(!is_null($projectid) && User::isProjectMember(Auth::user()->id, $projectid))
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
				if($user->id != Auth::user()->id)
				{
					$users[$user->id] = $user->username;
				}
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

	public function postUpdate($projectid = null)
	{
		if(!is_null($projectid) && User::isProjectMember(Auth::user()->id, $projectid))
		{
			$rules = array(
				'name' => array('required'),
				'description' => array('required', 'min:10', 'max:100'),
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

				if(Input::has('members'))
				{
					foreach(Input::get('members') as $counter => $user)
					{
						$pivot = Project::find($projectid);

						if($pivot->users()->where('project_id', '=', $projectid)->where('user_id', '=', $user)->first())
						{
							$pivot->users()->detach($user);
						}
						else
						{
							$pivot->users()->attach($user);
						}
					}
				}

				Session::flash('message', 'Het project is opgeslagen.');

				return Redirect::action('ProjectController@getIndex');
			}
		}

		return Redirect::action('ProjectController@getIndex');
	}

	public function getDelete($projectid = null)
	{
	}

	public function postDelete($projectid = null)
	{
	}

	public function getDetails($projectid = null)
	{
		if(!is_null($projectid) && User::isProjectMember(Auth::user()->id, $projectid))
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
<?php

/**
 * The dasboard controller takes care of user management and all other system-management related tasks.
 * This used to be in UserController.php
 *
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */

class DashboardController extends BaseController
{
	
	/*
	 * Shows the main dashboard
	 */
	public function getIndex()
	{
		/**
		 * @todo Show the user things they want to see
		 */

		$data = array(
			'users' => User::all(),
			'projects' => Project::all(),
			'tasks' => Task::all()
		);

		return View::make('layouts/dashboard')->nest('content', 'dashboard/index', $data);
	}

	/*
	 * Shows the view to create a new user
	 */
	public function getCreateUser()
	{
		return View::make('layouts/dashboard')->nest('content', 'dashboard/create-user');
	}
	
	/*
	 * Handles the HTTP POST to create a new user
	 */
	public function postCreateUser()
	{
		$rules = array(
			'username' => array('required', 'min:5', 'max:255'),
			'password' => array('required', 'min:5', 'max:255'),
			'password_check' => array('required', 'min:5', 'max:255', 'same:password'),
			'role' => array('required')
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::action('DashboardController@getCreateUser')->withErrors($validator)->withInput(Input::all());
		}
		else
		{
			$user = new User;
			$user->username = Input::get('username');
			$user->password = Hash::make(Input::get('password'));
			$user->role = Input::get('role');
			$user->save();

			flash('De gebruiker ' . Input::get('username') . ' is toegevoegd', 'success');
			
			return Redirect::action('DashboardController@getIndex');
		}
	}

	/**
	 * Show the view to edit the user
	 * @param int $userid The user's ID
	 * @return mixed
	 */
	public function getUpdateUser($userid = null)
	{
		if(!is_null($userid))
		{
			$data = array(
				'user' => User::find($userid)
			);

			return View::make('layouts/dashboard')->nest('content', 'dashboard/update-user', $data);
		}

		return Redirect::action('DashboardController@getIndex');
	}

	/**
	 * Handles the HTTP POST to update the user
	 * @param int $userid The user's ID
	 * @return mixed
	 */
	public function postUpdateUser($userid = null)
	{
		if(!is_null($userid))
		{
			$rules = array(
				'username' => array('required', 'min:5', 'max:255'),
				'password' => array('required', 'min:5', 'max:255'),
				'password_check' => array('required', 'min:5', 'max:255', 'same:password'),
				'role' => array('required')
			);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails())
			{
				return Redirect::action('DashboardController@getUpdateUser', array($userid))->withErrors($validator)->withInput(Input::all());
			}
			else
			{
				$user = User::find($userid);
				$user->username = Input::get('username');
				$user->password = Hash::make(Input::get('password'));
				$user->role = Input::get('role');
				$user->save();

				flash('De gebruiker ' . Input::get('username') . ' is gewijzigd', 'success');
			}
		}

		return Redirect::action('DashboardController@getIndex');
	}

	/**
	 * Shows the view to delete a user
	 * @param int $userid The user's ID
	 * @access public
	 * @return mixed
	 */
	public function getDeleteUser($userid = null)
	{
		if(!is_null($userid))
		{
			$data = array(
				'user' => User::find($userid)
			);

			return View::make('layouts/dashboard')->nest('content', 'dashboard/delete-user', $data);
		}

		return Redirect::action('DashboardController@getIndex');
	}

	/**
	 * Handles the HTTP POST to delete a user
	 * @param int $userid The users' ID
	 * @access public
	 * @return mixed
	 */
	public function postDeleteUser($userid = null)
	{
		if(!is_null($userid))
		{
			$user = User::find($userid);
			$username = $user->username;
			$user->delete();

			flash('De gebruiker ' . $username . ' is verwijderd.', 'success');
		}

		return Redirect::action('DashboardController@getIndex');
	}
	
	public function getImport()
	{
		return View::make('layouts/dashboard')->nest('content', 'dashboard/import');
	}

	public function postImport()
	{
		/**
		 * @todo Implement this
		 */
	}

	/*
	 * Shows the view to export data
	 */
	public function getExport()
	{
		return View::make('layouts/dashboard')->nest('content', 'dashboard/export');
	}

	/*
	 * Handles the HTTP POST to export data
	 */
	public function postExport()
	{
		switch(Input::get('type'))
		{
			case 'users':
				return Response::json(User::all());
			break;

			case 'tasks':
				return Response::json(Task::all());
			break;

			case 'projects':
				return Response::json(Project::all());
			break;

			default:
				$return = array(
					'users' => User::all(),
					'tasks' => Task::all(),
					'projects' => Project::all()
				);

				return Response::json($return);
			break;
		}
	}
}

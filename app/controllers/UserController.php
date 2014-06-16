<?php

/**
 * The usercontroller handles everything related to users
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */

class UserController extends BaseController
{

	/*
	 * The user starting page
	 */
	public function getIndex()
	{
		$data = array(
			'user' => User::find(Auth::user()->id),
			'tasks' => Task::where('user_id', '=', Auth::user()->id)->get(),
			'projects' => User::find(Auth::user()->id)->projects()->get()
		);

		return View::make('layouts/main')->nest('content', 'user/index', $data);
	}

	/*
	 * Shows the view to change the users' password
	 */
	public function getPassword()
	{
		return View::make('layouts/main')->nest('content', 'user/password');
	}

	/*
	 * Handles the changing of a password
	 */
	public function postPassword()
	{
		$rules = array(
			'password' => array('required'),
			'new_password' => array('required', 'min:5', 'different:password'),
			'new_password_check' => array('required', 'min:5', 'different:password', 'same:new_password')
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::action('UserController@getPassword')->withErrors($validator)->withInput(Input::all());
		}
		else
		{
			if(Hash::check('password', Input::get('password')))
			{
				$user = User::find(Auth::user()->id);
				$user->password = Hash::make('new_passwowrd');
				$user->save();

				return Redirect::to('logout');
			}
			else
			{
				Session::flash('message', 'Er is een fout opgetreden.');
				return Redirect::action('UserController@getDetails', array(Auth::user()->id));
			}
		}
	}

	/*
	 * Shows all users to the admin
	 */
	public function getUsers()
	{
		$data = array(
			'users' => User::all()
		);

		return View::make('layouts/main')->nest('content', 'user/list', $data);
	}

	/*
	 * Shows the view to create a user
	 */
	public function getCreate()
	{
		return View::make('layouts/main')->nest('content', 'user/create');
	}

	/*
	 * Handles the creation of a user
	 */
	public function postCreate()
	{
		$rules = array(
			'username' => array('required', 'min:2', 'max:100'),
			'password' => array('required', 'min:5'),
			'password_check' => array('required', 'min:5', 'same:password')
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::action('UserController@getCreate')->withErrors($validator)->withInput(Input::all());
		}
		else
		{
			$user = new User;
			$user->username = Input::get('username');
			$user->role = Input::get('role');
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			flash('De gebruiker is toegevoegd.', 'success');
		}
	}

	/*
	 * Shows the view to update a user
	 */
	public function getUpdate($userid = null)
	{
		if(!is_null($userid))
		{
			$data = array(
				'user' => User::find($userid)
			);

			return View::make('layouts/main')->nest('content', 'user/update', $data);
		}

		return Redirect::action('UserController@getUsers');
	}

	/*
	 * Handles the updating of a user
	 */
	public function postUpdate($userid = null)
	{
		if(!is_null($userid))
		{
			$rules = array(
				'username' => array('required', 'min:2', 'max:100'),
				'password' => array('required', 'min:5'),
				'password_check' => array('required', 'min:5', 'same:password')
			);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails())
			{
				return Redirect::action('UserController@getUpdate', array($userid))->withErrors($validator)->withInput(Input::all());
			}
			else
			{
				$user = User::find($userid);
				$user->username = Input::get('username');
				$user->role = Input::get('role');
				$user->password = Hash::make(Input::get('password'));
				$user->save();

				Session::flash('message', 'De gebruiker is gewijzigd');
			}
		}

		return Redirect::action('UserController@getUsers');
	}

	/*
	 * Shows the view to delete a user
	 */
	public function getDelete($userid = null)
	{
		if(!is_null($userid))
		{
			$data = array(
				'user' => User::find($userid)
			);

			return View::make('layouts/main')->nest('content', 'user/delete', $data);
		}

		return Redirect::action('UserController@getUsers');
	}

	/*
	 * Handles the deleting of a user
	 */
	public function postDelete($userid = null)
	{
		if(!is_null($userid))
		{
			$user = User::find($userid);
			$user->delete();

			Session::flash('message', 'Deze gebruiker is verwijderd.');
		}

		return Redirect::action('UserController@getUsers');
	}

	/*
	 * Shows the export view
	 */
	public function getExport()
	{
		return View::make('layouts/main')->nest('content', 'user/export');
	}

	/*
	 * Handles the export
	 */
	public function postExport()
	{
		return Redirect::action('UserController@getUsers');
	}

	/*
	 * Shows the import view
	 */
	public function getImport()
	{
		return Redirect::action('UserController@getUsers');
	}

	/*
	 * Handles the import
	 */
	public function postImport()
	{
		return Redirect::action('UserController@getUsers');
	}
}
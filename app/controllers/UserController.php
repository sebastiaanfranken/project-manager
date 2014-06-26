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
				//Session::flash('message', 'Er is een fout opgetreden.');
				flash('Er is een fout opgetreden.', 'error');
				return Redirect::action('UserController@getDetails', array(Auth::user()->id));
			}
		}
	}
}
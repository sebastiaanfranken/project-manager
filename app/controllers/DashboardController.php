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

	public function getCreateUser(){}
	public function postCreateUser(){}
}

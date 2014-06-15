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
}
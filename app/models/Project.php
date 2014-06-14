<?php

/**
 * This is the model for projects.
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */
class Project extends Eloquent
{

	/**
	 * The table to use.
	 * @var string
	 */
	protected $table = 'projects';

	/*
	 * These fields are hidden if the model is exported as JSON
	 * @var array
	 */
	protected $hidden = array('created_at', 'updated_at');

	/**
	 * A scope to get the completion percentage of a project
	 *
	 * @param mixed $query The base query
	 * @param int $id The project ID
	 */
	public function scopeCompletion($query, $id)
	{
		$counter = Task::where('project_id', '=', $id)->count();

		if($counter > 0)
		{
			$completion = 0;
			$tasks = Task::where('project_id', '=', $id)->get();

			foreach($tasks as $task)
			{
				$completion += $task->completion;
			}

			return round($completion / count($tasks), 2) . '%';
		}

		return '0%';
	}

	/*
	 * This handles the relationship to the Users table.
	 * It can be used to select all users that are members of this project like so:
	 * $users = Project::find($project_id)->users()
	 */
	public function users()
	{
		return $this->belongsToMany('User');
	}
}
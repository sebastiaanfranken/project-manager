<?php

/*
 * This is the model for tasks
 */
class Task extends Eloquent
{

	/**
	 * The table to use
	 * @var string
	 */
	protected $table = 'tasks';

	/*
	 * These fields are hidden when you export the table to a JSON format
	 * @var array
	 */
	protected $hidden = array('created_at', 'updated_at');

	/*
	 * This handles the relationship to the User table
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/*
	 * This handles the relationship to the Project table
	 */
	public function project()
	{
		return $this->belongsTo('Project');
	}
}
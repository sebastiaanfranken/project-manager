<?php

/**
 * The comment model handles CRUD for the comments table
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */

class Comment extends Eloquent
{

	/**
	 * The table to use
	 * @access protected
	 * @var string
	 */
	protected $table = 'comments';

	/*
	 * The one-to-many implementation for comments to tasks
	 */
	public function task()
	{
		return $this->belongsTo('Task');
	}

	/*
	 * The one-to-many implementation for users to tasks
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}
}
<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/*
	 * This handles the relationships to the Project table
	 */
	public function projects()
	{
		return $this->belongsToMany('Project');
	}

	/*
	 * This handles the relationships to the Task table
	 */
	public function tasks()
	{
		return $this->hasMany('Task');
	}

	/**
	 * This checks if the user ($uid) is member of a project ($pid)
	 * @param int $uid The user ID
	 * @param int $pid The project ID
	 * @return int
	 */
	public function scopeIsProjectMember($query, $uid, $pid)
	{
		$check = User::find($uid)->projects()->wherePivot('project_id', '=', $pid)->wherePivot('user_id', '=', $uid)->get();

		return $check;
	}

}

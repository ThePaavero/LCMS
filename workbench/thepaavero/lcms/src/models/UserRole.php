<?php

class UserRole extends Eloquent {

	protected $table = 'user_roles';
	public $timestamps = true;
	protected $softDelete = true;
	protected $fillable = array('title');
	protected $visible = array('id', 'title');

}
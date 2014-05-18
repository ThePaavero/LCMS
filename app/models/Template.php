<?php

class Template extends Eloquent {

	protected $table = 'templates';
	public $timestamps = true;
	protected $softDelete = true;
	protected $fillable = array('name');

	public function hasPages()
	{
		return $this->hasMany('Page', 'id');
	}

}
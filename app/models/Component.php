<?php

class Component extends Eloquent {

	protected $table = 'components';
	public $timestamps = true;

	protected $dates = ['deleted_at'];

	public function belongsToPage()
	{
		return $this->belongsToMany('Page', 'page');
	}

	public function isOfType()
	{
		return $this->belongsTo('ComponentType', 'type');
	}

	public function blocks()
	{
		return $this->hasMany('Block', 'component');
	}

}
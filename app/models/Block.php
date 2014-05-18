<?php

class Block extends Eloquent {

	protected $table = 'blocks';
	public $timestamps = true;
	protected $softDelete = true;
	protected $fillable = array('name', 'type', 'page');

	public function getContents()
	{
		return $this->hasMany('Content', 'block');
	}

	public function belongsToType()
	{
		return $this->belongsTo('BlockTypes', 'id');
	}

	public function belongsToPage()
	{
		return $this->belongsTo('Page', 'id');
	}

}
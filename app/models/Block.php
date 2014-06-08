<?php

class Block extends Eloquent {

	protected $table = 'blocks';
	public $timestamps = true;
	protected $softDelete = true;
	protected $fillable = array('type', 'page', 'contents', 'component');

	public function belongsToType()
	{
		return $this->belongsTo('BlockType');
	}

	public function belongsToPage()
	{
		return $this->belongsTo('Page');
	}

	public function belongsToComponent()
	{
		return $this->belongsTo('Component');
	}

	public function hasHistory()
	{
		return $this->hasMany('BlockHistory', 'block');
	}

}
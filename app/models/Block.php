<?php

class Block extends Eloquent {

	protected $table = 'blocks';
	public $timestamps = true;
	protected $softDelete = true;
	protected $fillable = array('type', 'page', 'contents');

	public function belongsToType()
	{
		return $this->belongsTo('BlockType', 'id');
	}

	public function belongsToPage()
	{
		return $this->belongsTo('Page', 'id');
	}

	public function hasHistory()
	{
		return $this->hasMany('BlockHistory', 'block');
	}

}
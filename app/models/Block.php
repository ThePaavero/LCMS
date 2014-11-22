<?php

class Block extends Eloquent {

	protected $table = 'blocks';
	public $timestamps = true;
	protected $softDelete = true;
<<<<<<< HEAD
	protected $fillable = array('type', 'page', 'contents', 'component');

	public function belongsToType()
	{
		return $this->belongsTo('BlockType');
=======
	protected $fillable = array('type', 'page', 'contents');

	public function belongsToType()
	{
		return $this->belongsTo('BlockType', 'id');
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
	}

	public function belongsToPage()
	{
<<<<<<< HEAD
		return $this->belongsTo('Page');
	}

	public function belongsToComponent()
	{
		return $this->belongsTo('Component');
=======
		return $this->belongsTo('Page', 'id');
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
	}

	public function hasHistory()
	{
		return $this->hasMany('BlockHistory', 'block');
	}

}
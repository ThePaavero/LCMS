<?php

class Page extends Eloquent {

	protected $table = 'pages';
	public $timestamps = true;
	protected $softDelete = true;
	protected $fillable = array('url', 'title', 'description', 'template', 'published');

	public function blocks()
	{
		return $this->hasMany('Block', 'page');
	}

	public function components()
	{
		return $this->hasMany('Component', 'page');
	}

	public function template()
	{
		return $this->belongsTo('Template', 'template');
	}

}
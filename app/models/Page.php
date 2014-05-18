<?php

class Page extends Eloquent {

	protected $table = 'pages';
	public $timestamps = true;
	protected $softDelete = true;
	protected $fillable = array('url', 'title', 'description', 'template', 'published');

	public function hasBlocks()
	{
		return $this->hasMany('Block', 'id');
	}

	public function hasTemplate()
	{
		return $this->hasOne('Template', 'id');
	}

}
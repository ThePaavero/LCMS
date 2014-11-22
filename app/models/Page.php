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

<<<<<<< HEAD
	public function components()
	{
		return $this->hasMany('Component', 'page');
	}

=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
	public function template()
	{
		return $this->belongsTo('Template', 'template');
	}

}
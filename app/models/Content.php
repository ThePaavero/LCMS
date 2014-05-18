<?php

class Content extends Eloquent {

	protected $table = 'contents';
	public $timestamps = true;
	protected $softDelete = true;
	protected $fillable = array('content', 'block');

}
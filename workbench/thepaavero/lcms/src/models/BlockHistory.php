<?php

class BlockHistory extends Eloquent {

	protected $table = 'block_history';
	public $timestamps = true;
	protected $softDelete = false;
	protected $fillable = array('block', 'contents');

	public function belongsToBlock()
	{
		return $this->belongsTo('Block', 'block');
	}

}
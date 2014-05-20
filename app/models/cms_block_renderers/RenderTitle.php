<?php

class RenderTitle {

	public function __construct($block)
	{
		$this->block = $block;
	}

	public function returnBlock()
	{
		return $this->block;
	}

}

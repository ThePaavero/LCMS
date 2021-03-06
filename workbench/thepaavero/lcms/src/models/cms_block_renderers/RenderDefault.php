<?php

class RenderDefault {

	public function __construct($block, $editable = false)
	{
		$this->block    = $block;
		$this->editable = $editable;
	}

	public function returnBlock()
	{
		if($this->editable)
		{
			$this->block['contents'] = '<span class="cms_editable" data-id="' . $this->block['id'] . '" data-type="Default">' . $this->block['contents'] . '</span>';
		}

		return $this->block;
	}

}

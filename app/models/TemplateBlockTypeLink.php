<?php

class TemplateBlockTypeLink extends Eloquent {

    protected $table = 'template_block_type_links';
    public $timestamps = true;
    protected $fillable = array('type', 'page', 'contents');

}

<?php

class ComponentType extends Eloquent
{

    protected $table = 'component_types';
    public $timestamps = true;

    protected $dates = ['deleted_at'];
    protected $fillable = array ('name');
    protected $visible = array ('name');

    public function components()
    {
        return $this->hasMany('Component');
    }

}
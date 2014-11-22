<?php


class Language extends Eloquent
{

    protected $table = "languages";
    protected $fillable = ['name', 'slug', 'sort_order'];

    public function pages()
    {
        return $this->hasMany('Page', 'language');
    }

}

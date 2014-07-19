<?php

use \LaravelBook\Ardent\Ardent;

class Article extends Ardent
{
    public static $rules = array(
        'title'     => 'required|min:5',
        'url'       => 'required|active_url',
        'slug'      => 'required|unique:articles',
        'indexable' => 'required',
        'body'      => 'required|min:5',
    );

    protected $guarded = array();

     /**
     * Get the post's author.
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return Category|null
     */
    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }
}

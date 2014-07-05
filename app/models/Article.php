<?php

class Article extends \Eloquent {
	protected $fillable = [];

	 /**
     * Get the post's author.
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }
}
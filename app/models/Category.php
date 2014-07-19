<?php

use \LaravelBook\Ardent\Ardent;

class Category extends Ardent
{
    public static $rules = array(
        'name'     => 'required|min:3',
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('created_at', 'updated_at');


    protected $guarded = array();

    /**
     * Get the post's author.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id ');
    }
}
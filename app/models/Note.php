<?php

class Note extends BaseModel implements HyperMediaInterface
{
    public static $rules = array(
        'body'     => 'required|min:3',
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('created_at', 'updated_at');

    protected $guarded = array();

    public function author()
    {
        return $this->user();
    }

    /**
     * Get the post's author.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    /**
     * Get the article
     *
     * @return Article
     */
    public function article()
    {
        return $this->belongsTo('Article', 'article_id');
    }
}

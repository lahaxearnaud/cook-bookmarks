<?php

/**
 * Note
 *
 * @property integer $id
 * @property string $body
 * @property integer $user_id
 * @property integer $article_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \User $user
 * @property-read \Article $article
 * @property-read mixed $links
 * @method static \Illuminate\Database\Query\Builder|\Note whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Note whereBody($value) 
 * @method static \Illuminate\Database\Query\Builder|\Note whereUserId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Note whereArticleId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Note whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Note whereUpdatedAt($value) 
 */
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

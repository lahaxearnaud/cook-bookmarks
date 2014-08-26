<?php

/**
 * Category
 *
 * @property-read \User $user
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Category whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Category whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Article[] $articles
 * @property-read mixed $links
 */
class Category extends BaseModel implements HyperMediaInterface
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
        return $this->belongsTo('User', 'user_id');
    }

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return array
     */
    public function articles()
    {
        return $this->hasMany('Article', 'category_id');
    }
}

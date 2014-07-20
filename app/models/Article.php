<?php

use \LaravelBook\Ardent\Ardent;

/**
 * Article
 *
 * @property-read \User $author
 * @property-read \Category $category
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property integer $author_id
 * @property string $slug
 * @property string $indexable
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $category_id
 * @method static \Illuminate\Database\Query\Builder|\Article whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereTitle($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereUrl($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereAuthorId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereSlug($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereIndexable($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereBody($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Article whereCategoryId($value) 
 */
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

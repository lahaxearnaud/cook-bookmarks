<?php

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
 * @property string $image
 * @property string $imageMiniature
 * @property string $sourceSite
 * @property string $sourceFavicon
 * @property-read \Illuminate\Database\Eloquent\Collection|\Note[] $notes
 * @property-read mixed $links
 * @method static \Illuminate\Database\Query\Builder|\Article whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Article whereImageMiniature($value)
 * @method static \Illuminate\Database\Query\Builder|\Article whereSourceSite($value)
 * @method static \Illuminate\Database\Query\Builder|\Article whereSourceFavicon($value)
 */
class Article extends BaseModel implements HyperMediaInterface {
	public static $rules = array(
		'title'     => 'required|min:5',
		'url'       => 'url',
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
	public function author() {
		return $this->belongsTo('User', 'author_id');
	}

	/**
	 * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
	 * @return Category|null
	 */
	public function category() {
		return $this->belongsTo('Category', 'category_id');
	}

	/**
	 * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
	 * @return array
	 */
	public function notes() {
		return $this->hasMany('Note', 'article_id');
	}
}

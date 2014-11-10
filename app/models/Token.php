<?php

use \Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


/**
 * Token
 *
 * @property integer $id
 * @property string $token
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $expire_at
 * @property-read \User $author
 */
class Token extends Model {


	protected $guarded = array();

	/**
	 * Get the post's author.
	 *
	 * @return User
	 */
	public function author()
    {
		return $this->belongsTo('User', 'user_id');
	}

    /**
     * check if the token is valid
     * @return bool
     */
    public function isValid()
    {
        return $this->expire_at->diffInMinutes(Carbon::now()) < 0;
    }
}

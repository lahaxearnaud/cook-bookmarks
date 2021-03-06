<?php

use Illuminate\Database\Eloquent\Model;


/**
 * Token
 *
 * @property integer        $id
 * @property string         $token
 * @property integer        $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $expire_at
 * @property-read \User     $author
 */
class Token extends Model
{


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


    public function getDates()
    {

        return array_merge(parent::getDates(), ['expire_at']);
    }
}

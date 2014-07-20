<?php

/**
 * ApiLog
 *
 * @property-read \User $user
 * @property integer $id
 * @property integer $user_id
 * @property string $url
 * @property string $route
 * @property string $params
 * @property string $method
 * @property integer $httpCode
 * @property string $ip
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereRoute($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereParams($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereHttpCode($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ApiLog whereUpdatedAt($value)
 */
class ApiLog extends \Eloquent
{
    protected $guarded = array();

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * Get the post's author.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}

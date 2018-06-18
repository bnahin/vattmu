<?php

namespace App;

use App\Utils;
use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *                $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User createdRange($from, $to, $format = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User createdToday()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User latestFirst()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User like($field, $value, $isOr = false)
 * @mixin \Eloquent
 * @property int
 *               $id
 * @property string
 *               $name
 * @property string
 *               $email
 * @property string
 *               $password
 * @property string|null
 *               $remember_token
 * @property \Carbon\Carbon|null
 *               $created_at
 * @property \Carbon\Carbon|null
 *               $updated_at
 * @property int
 *               $is_admin
 * @property int
 *               $logo_number
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLogoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @property int         $cid
 * @property string      $first_name
 * @property string      $last_name
 * @property int         $isAdmin
 * @property-read string $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 */
class User extends Authenticatable
{
    use Notifiable, FillableFields, OrderableTrait, SearchLikeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'logo_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return (int)$this->isAdmin === 1;
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords($value);
    }
}

<?php

namespace App;

use App\Exceptions\EntityNotCreatedException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'activation_token', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    protected $appends = ['avatar_url'];

    public function stories()
    {
        return $this->hasMany('App\Story', 'user_id');
    }

    public function getAvatarUrlAttribute()
    {
        return Storage::url('avatars/'.$this->id.'/'.$this->avatar);
    }

    public static function newUser ($postData)
    {
        $user = new User();
        $userData = $user->create($postData);
        if(!$userData){
            throw new EntityNotCreatedException("User Entity was not Created", 500);
        }
        return $userData;
    }

    public static function authenticateUser($credentials)
    {
        if(!Auth::attempt($credentials)){
            return response()->json(['message'=> 'Unauthorized'], 401);
        }
    }
}

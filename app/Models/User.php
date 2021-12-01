<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'balance',
        'roles_name',
        'mobile',
        'status',
        'cover',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles_name' => 'array',
    ];


    public static function getBalance()
    {
        $User = User::find(auth()->user()->id);
        $User = $User->balance;
        return $User;
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            UserInformation::create([
                'user_id' => $model->id,
            ]);
        });

    }

    public function avatar()
    {
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) ) . "?d=mm&s=80";
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.Models.User.' . $this->id;
    }   
    
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)->withPivot('read_at');
    }

    public function inConversation($id)
    {
        return $this->conversations->contains('id', $id);
    }

    public function hasRead(Conversation $conversation)
    {
        if (auth()->user()->hasRole(['Owner'])) {
            return false;

        } else return $this->conversations->find($conversation->id)->pivot->read_at;
    }
}

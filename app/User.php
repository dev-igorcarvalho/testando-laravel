<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use function foo\func;

class User extends Authenticatable
{
    use Notifiable;


    //Laravel Eloquent Event Hoot
    protected static function boot()
    {
        parent::boot();
        //apos o usuario ter sido criado
        //criar um profile basico para ele
        static::created(
            function ($user){
                $user->profile()->create(
                    [
                        'title' => $user->name,
                    ]
                );
//                envia o email para novos usario, esta comentado pois requer credenciais do servidor de email
//                e como nao disponibilizei um iria quebrar o codido
//
//                Mail::to($user->email)->send(new NewUserWelcomeMail());
            }
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password'
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

    public function profile()
    {
        //faz o relacionamento ORM oneToOne de profile para user
        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        //faz o relacionamento oneToMnay e ordena o modo q eh recuperado os dados
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    //faz o relacionamento ORM ManyToMany de profile para user
    //precisa ser colocado nos dois models que se relacionam
    public function following(){
        return $this->belongsToMany(Profile::class);
    }
}

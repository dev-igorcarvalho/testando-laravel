<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        //faz o relacionamento ORM oneToOne de profile para user
        return $this->belongsTo(User::class);
    }

    //faz o relacionamento ORM ManyToMany de profile para user
    //precisa ser colocado nos dois models que se relacionam
    public  function followers(){
        return $this->belongsToMany(User::class);
    }

    //utilitaria para evitar nullPointer
    public function profileImage(){
        return $this->imgPath != null? $this->imgPath : 'profile/img/logomark.min.svg';
    }
}

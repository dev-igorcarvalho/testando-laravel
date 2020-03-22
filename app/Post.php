<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //remove a proteçao do laravel ao receber o request do form
    //, porem os campos passados pro create tem q ser exatamente os mesmo da tabela
    protected  $guarded = [];

    public function user()
    {
        //faz o relacionamento ORM oneToOne de profile para user
        return $this->belongsTo(User::class);
    }
}

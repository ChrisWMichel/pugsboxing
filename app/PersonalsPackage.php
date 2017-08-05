<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalsPackage extends Model
{
    protected $fillable = ['package'];

    public function members(){
        return $this->belongsTo(MemberPersonal::class);
    }
}

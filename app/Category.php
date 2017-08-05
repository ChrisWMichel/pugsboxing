<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];



    public function memberships(){
        return $this->hasMany(Membership::class);
    }
}

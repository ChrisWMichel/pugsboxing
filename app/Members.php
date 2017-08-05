<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $guarded = [];


    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}

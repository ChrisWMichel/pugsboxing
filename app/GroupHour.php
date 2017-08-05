<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupHour extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function classSchedules(){
        return $this->hasMany(ClassSchedule::class);
    }
}

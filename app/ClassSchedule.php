<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = ['group_hour_id', 'description', 'time'];
    protected $with = ['groupHour'];

    public function groupHour(){
        return $this->belongsTo(GroupHour::class);
    }
}

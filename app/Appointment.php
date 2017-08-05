<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['member_id', 'title', 'color', 'start', 'notes'];
    protected $with = ['member'];

    public function member(){
        return $this->belongsTo(Members::class);
    }
}

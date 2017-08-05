<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembersClub extends Model
{
    protected $fillable = ['member_id', 'months', 'start_date', 'end_date'];
    //protected $dates = ['start_date', 'end_date'];

    public function members(){
        return $this->belongsTo(Members::class);
    }
}

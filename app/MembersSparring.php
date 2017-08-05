<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembersSparring extends Model
{
    protected $fillable = ['member_id', 'membership_id', 'rounds', 'rounds_left'];

    public function members(){
        return $this->belongsTo(Members::class);
    }
}

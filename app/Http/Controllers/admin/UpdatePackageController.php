<?php

namespace App\Http\Controllers\admin;

use App\MemberPersonal;
use App\Members;
use App\MembersClub;
use App\MembersSparring;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdatePackageController extends Controller
{
    //

    public function addPersonals(Request $request){

        $personal_id = $request->input('personal_id');
        $addLessons = $request->input('addLessons');

        $personals = MemberPersonal::find($personal_id);
        $lessons_left = $personals->lessons_left + $addLessons;

        $personals->update([
                    'lessons_left' => $lessons_left
                     ]);

        $personals = MemberPersonal::find($personal_id);
        return response($personals);
    }

    public function subtractPersonals(Request $request){
        $personal_id = $request->input('personal_id');
        $subtractLessons = $request->input('subtractLessons');

        $personals = MemberPersonal::find($personal_id);
        $lessons_left = $personals->lessons_left - $subtractLessons;

        if($lessons_left == 0){
            $member = Members::find($personals->member_id);
            $member->update(['personals' => 0]);
            $personals->delete();

            return response(['firstname' => $member->firstname, 'completed' => TRUE]);
        }

        $personals->update([
          'lessons_left' => $lessons_left
        ]);

        $personals = MemberPersonal::find($personal_id);

        return response(['total_lessons' => $personals->total_lessons, 'lessons_left' => $personals->lessons_left, 'completed' => FALSE]);
    }

    public function addSparring(Request $request){
        $sparring_id = $request->input('sparring_id');
        $addSparring = $request->input('addRounds');

        $sparring = MembersSparring::find($sparring_id);
        $rounds_left = $sparring->rounds_left + $addSparring;

        $sparring->update([
          'rounds_left' => $rounds_left
        ]);

        $sparring = MembersSparring::find($sparring_id);
        return response($sparring);
    }

    public function subtractSparring(Request $request){
        $sparring_id = $request->input('sparring_id');
        $subtractSparring = $request->input('subtractRounds');

        $sparring = MembersSparring::find($sparring_id);
        $rounds_left = $sparring->rounds_left - $subtractSparring;

        if($rounds_left == 0){
            $member = Members::find($sparring->member_id);
            $member->update(['sparring' => 0]);
            $sparring->delete();
            return response(['firstname' => $member->firstname, 'completed' => TRUE]);
        }
        $sparring->update([
          'rounds_left' => $rounds_left
        ]);

        $sparring = MembersSparring::find($sparring_id);
        return response($sparring);
    }
}

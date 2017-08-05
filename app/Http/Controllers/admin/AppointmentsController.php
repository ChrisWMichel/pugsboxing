<?php

namespace App\Http\Controllers\admin;

use App\Appointment;
use App\MemberPersonal;
use App\Members;
use App\MembersSparring;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentsController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
          'member' => 'required',
          'dateSchedule' => 'required',
          'timepicker1' => 'required',
        ]);

        /* Subtract a lesson from personals */
        if($request->title == 'Personal Training'){
            $personals = MemberPersonal::where('member_id', '=', $request->member_id)->first();
            if(!empty($personals)){
                $lessons_left = $personals->lessons_left - 1;
                $personals->update(['lessons_left' => $lessons_left]);

                if($lessons_left == 0){
                    $member = Members::find($personals->member_id);
                    $member->update(['personals' => 0]);
                    $personals->delete();
                }
            }else{
                $tasks = Appointment::all();
                flash('The member is out of lessons. He needs a new training package.')->error();
                return redirect()->back()->with('tasks', $tasks);
            }
        }
        /* Subtract a rounds from sparring */
        if($request->title == 'Sparring'){
            $sparring = MembersSparring::where('member_id', '=', $request->member_id)->first();
            if(!empty($sparring)){
                $rounds_left = $sparring->rounds_left - 1;
                $sparring->update(['rounds_left' => $rounds_left]);


                if($rounds_left == 0){
                    $member = Members::find($sparring->member_id);
                    $member->update(['sparring' => 0]);
                    $sparring->delete();
                }

                }else{
                $tasks = Appointment::all();
                flash('The member is out of rounds. Needs a new sparring package.')->error();
                return redirect()->back()->with('tasks', $tasks);
            }
        }
        $dateTime = Carbon::parse($request->dateSchedule . ' ' . $request->timepicker1);
        $sqlDate = $dateTime->format("Y-m-d H:m:s");

        Appointment::create([
          'member_id' => $request->member_id,
            'title' => $request->title,
            'color' => $request->color,
            'start' => $sqlDate,
            'notes' => $request->notes
        ]);



        $tasks = Appointment::all();

        return redirect()->back()->with('tasks', $tasks);
    }

    public function autoComplete(Request $request){

        $term=$request->get('term', '');

        $members = Members::where('firstname','LIKE','%'.$term.'%')
          ->orWhere('lastname','LIKE','%'.$term.'%')
          ->get();

        $data = [];
        foreach ($members as $member){
            $data[]=['value' => [$member->firstname,  ' ',  $member->lastname], 'id' =>$member->id ];
        }

        if(count($data)){
            return $data;
            //return response()->json($result);
        }else{
            return ['value' => 'No resutls were found.'];
        }
    }



    public function updateAppointment(Request $request)
    {
        $appoint = Appointment::find($request->get('appoint_id'));

        $appoint->notes = $request->get('note');
        $appoint->update();

    }


    public function deleteAppointment($id)
    {
        Appointment::find($id)->delete();
    }
}

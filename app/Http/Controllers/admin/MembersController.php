<?php

namespace App\Http\Controllers\admin;

use App\Appointment;
use App\Category;
use App\Mail\EmailMember;
use App\MemberPersonal;
use App\Members;
use App\MembersClub;
use App\Membership;
use App\MembersSparring;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\NewMemberRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MembersController extends Controller
{

    public function index()
    {
        $archived = $members = Members::where('archive', '=', 1)->count();
        $getArchive =Members::where('archive', '=', 1)
          ->orderBy('endMember', 'desc')
          ->get();

        $members = Members::where('archive', '=', 0)
          ->orderBy('personals', true)
          ->orderBy('firstname', 'asc')
          ->get();

        $activeMembers = count($members);

        $personalsCount = Members::where('personals', '=', 1)->where('archive', '=', 0)->count();
        $boxingClubCount = Members::where('boxing_club', '=', 1)->where('archive', '=', 0)->count();
        $sparringCount = Members::where('sparring', '=', 1)->where('archive', '=', 0)->count();

        $now = \Carbon\Carbon::now();
        $membershipExpired = 0;
        $membershipDue = 0;
        $boxingClubExpired = 0;

        foreach($members as $member){
            $start =  \Carbon\Carbon::parse($member->startMember);
            $end = \Carbon\Carbon::parse($member->endMember);
            $diffDays = $start->diffInDays($end);

            if($now > $end){
                $membershipExpired++;
            }
            elseif(($diffDays <= 30) && ($start < $end)){
                $membershipDue++;
            }
        }
        $boxing_club_table = MembersClub::all();
        foreach ($boxing_club_table as $boxing_club){
            $start =  \Carbon\Carbon::parse($boxing_club->start_date);
            $end = \Carbon\Carbon::parse($boxing_club->end_date);
            if($start > $end){
                $boxingClubExpired++;
            }
        }


        return view('admin.members.main_page', compact('members', 'activeMembers', 'personalsCount', 'boxingClubCount', 'sparringCount', 'membershipExpired', 'membershipDue', 'archived', 'getArchive', 'boxingClubExpired'));
    }


    public function store(NewMemberRequest $request)
    {

       $member = Members::create($request->all());


        return redirect()->route('new_mem_pack', ['id' => $member->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Members::find($id);

        if($member->personals == 1){
            $personals = MemberPersonal::where('member_id', '=', $member->id)->get()->first();
        }
        if($member->boxing_club == 1){
            $boxing_club = MembersClub::where('member_id', '=', $member->id)->get()->first();
        }
        if($member->sparring == 1){
            $sparring = MembersSparring::where('member_id', '=', $member->id)->get()->first();
        }
        $packages = Membership::all();
        $sparringPackage =  Membership::where('category_id', 5)->get();

        $appointments = Appointment::where('member_id', '=', $member->id)->get();

        return view('admin.members.profile_page', compact('member', 'personals', 'boxing_club', 'sparring', 'packages', 'sparringPackage', 'appointments'));
    }


    public function MemberEditProfile(Request $request)
    {
        $editMember = Members::find($request->input('id'));

        return response($editMember);
    }

    public function updateMember(Request $request, $id)
    {
        $member = Members::find($id);

        $member->update($request->all());
        $member = Members::find($id);

        return response($member);
    }

    public function emailMember(Request $request){
        $mem_id = $request->input('mem_id');

        $member = Members::find($mem_id);

        $contact = [
          'email' => $member->email,
          'subject' => $request->input('subject'),
          'message' => $request->input('message')
        ];

        Mail::send(new EmailMember($contact));
    }
  /********************** Archiving area *******************/
    public function archiveMember(Request $request){
        $member = Members::find($request->input('id'));

        $member->update(['archive' => 1]);
    }

    public function reactivateMember(Request $request){
        $member = Members::find($request->input('id'));

        $member->update(['archive' => 0]);
    }

    public function deleteMember(Request $request){
        $member = Members::find($request->input('id'));

        if($member->personals == 1){
            MemberPersonal::where('member_id', '=', $member->id)->delete();
        }
        if($member->boxing_clud == 1){
            MembersClub::where('member_id', '=', $member->id)->delete();
        }
        if($member->sparring == 1){
            MembersSparring::where('member_id', '=', $member->id)->delete();
        }
        Appointment::where('member_id', '=', $member->id)->delete();

        $member->delete();
    }


    /*************** New Member Section *******************************/

    public function newMember(){

        return view('admin.members.new_member');
    }

    public function newmemberpackage($mem_id){
        $member = Members::find($mem_id);
        $packages = Membership::all();
        $sparring=  Membership::where('category_id', 5)->get();

        return view('admin.members.new_member_package', compact('packages', 'member', 'sparring'));
    }

    public function addNewMemberPackage(Request $request){
        $membership_id = $request->input('membership_id');
        $mem_id = $request->input('mem_id');

        $member = Members::find($mem_id);

        if($member->personals == 1){
            $membership = Membership::find($membership_id);
            $memberPersonal = MemberPersonal::where('member_id', '=',  $member->id)->first();
            $memberPersonal->membership_id = $membership->id;
            $memberPersonal->total_lessons = $membership->pack_num;
            $memberPersonal->lessons_left = $membership->pack_num;
            $memberPersonal->update();

            return response()->json(['package' => $membership->package, 'firstname' => $member->firstname, 'update' => TRUE]);
        }
        $member->personals = 1;
        $member->update();

        $membership = Membership::findOrFail($membership_id);

        MemberPersonal::create([
          'member_id' => $mem_id,
          'membership_id' => $membership->id,
            'total_lessons' => $membership->pack_num,
            'lessons_left' => $membership->pack_num
        ]);

       return response()->json(['package' => $membership->package, 'firstname' => $member->firstname, 'update' => FALSE]);  //
    }

    public function addBoxingPackage(Request $request){
        $mem_id = $request->input('mem_id');
        $start_date = $request->input('start_date');
        $boxing_months = $request->input('boxing_months');
        $end_date = Carbon::createFromFormat('m/d/Y', $start_date)->addMonths($boxing_months)->format('m/d/Y');


        $member = Members::find($mem_id);

        if($member->boxing_club == 1){
            $members_club = MembersClub::where('member_id', '=',  $member->id)->first();

            $members_club->months = $boxing_months;
            $members_club->start_date = $start_date;
            $members_club->end_date = $end_date;
            $members_club->update();

            $start =  \Carbon\Carbon::parse($start_date);
            $end = \Carbon\Carbon::parse($end_date);
            $weekDiff = $start->diffInWeeks($end);

            return response()->json(['firstname' => $member->firstname, 'weeksLeft' => $weekDiff, 'update' => TRUE]);
        }

        $member->boxing_club = 1;
        $member->update();

        MembersClub::create([
          'member_id' => $member->id,
            'months' => $boxing_months,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);

        return response()->json(['firstname' => $member->firstname, 'update' => FALSE]); // $member->firstname
    }

    public function removeBoxingPackage(Request $request){
        $mem_id = $request->input('id');

        $member = Members::find($mem_id);
        $member->update(['boxing_club' => 0]);
        $boxingClub = MembersClub::where('member_id', '=', $member->id);
        $boxingClub->delete();

        return response()->json(['firstname' => $member->firstname]);
    }

    public function addSparringPackage(Request $request){

        $membership_id = $request->input('membership_id');
        $mem_id = $request->input('mem_id');

        $member = Members::find($mem_id);

        if($member->sparring == 1){
            $membership = Membership::find($membership_id);
            $memberBoxing = MembersSparring::where('member_id', '=',  $member->id)->first();
            $memberBoxing->membership_id = $membership->id;
            $memberBoxing->rounds = $membership->pack_num;
            $memberBoxing->rounds_left = $membership->pack_num;
            $memberBoxing->update();

            return response()->json(['package' => $membership->package, 'firstname' => $member->firstname, 'update' => TRUE]);
        }
        $member->sparring = 1;
        $member->update();

        $membership = Membership::findOrFail($membership_id);

        MembersSparring::create([
          'member_id' => $mem_id,
          'membership_id' => $membership->id,
          'rounds' => $membership->pack_num,
          'rounds_left' => $membership->pack_num
        ]);

        return response()->json(['package' => $membership->package, 'firstname' => $member->firstname, 'update' => FALSE]);  //  $membership->package
    }

   }
/*
echo '<pre>';
        print_r($personals);
        echo '</pre>';
        exit;
*/
<?php

namespace App\Http\Controllers\admin;

use App\Appointment;
use App\Mail\EmailAllMembers;
use App\Mail\newAdmin;
use App\Members;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;

class MainAdminController extends Controller
{
    public function index(){
        $tasks = Appointment::all();

        return view('admin.index', compact('tasks'));
    }

    public function newAdmin(){
        $admins = User::where('isAdmin', '=', 0)->get();
        return view('admin.newAdmin', compact('admins'));
    }

    public function storeAdmin(Request $request){

        $input = $request->all();
        $input['verification_code'] = User::generateVerificationCode();

        $this->validate(request(), [
          'firstname' => 'required|min:2',
            'lastname'=> 'required|min:2',
            'email' => 'required|string|email|max:255|unique:users'
        ]);

        $admin = User::create($input);

        //Todo all the code is completed, but not tested.
        Mail::to($admin)->send(new newAdmin($admin));

        flash('An email has been sent to the user. Once they complete the registration, your new admin will be able to login.')->success();


        return redirect()->back();

    }

    public function openMessageFrm(){
        return view('admin.message_form');
    }

    public function sendMessage(Request $request){
        $group = $request->groups;

        if($group == 'members'){
            $members = $members = Members::where('archive', '=', 0)->get();

            foreach ($members as $member){
                $contact = [
                  'firstname' =>  $member->firstname,
                  'email' => $member->email,
                  'subject' => $request->subject,
                  'message' => $request->message
                ];

                Mail::send(new EmailAllMembers($contact));
            }
        }else{
            $members = $members = Members::where('archive', '=', 0)
              ->where('boxing_club', '=', 1)
              ->get();

            foreach ($members as $member){
                $contact = [
                  'firstname' =>  $member->firstname,
                  'email' => $member->email,
                  'subject' => $request->subject,
                  'message' => $request->message
                ];

                Mail::send(new EmailAllMembers($contact));
            }
        }
        flash('Emails have been sent successfully.')->success();
        return redirect()->back();
    }

    public function destroy($id){
         User::find($id)->delete();

         return redirect()->back();
    }
    /*echo '<pre>';
        print_r($tasks);
        echo '</pre>';
        exit;*/
}

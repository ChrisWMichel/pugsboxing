<?php

namespace App\Http\Controllers\generalPublic;

use App\ClassSchedule;
use App\Description;
use App\Home;
use App\Mail\ContactPage;
use App\MainLayout;
use App\Membership;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class MainLayoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        switch ($request->id){
            case 'membership':
                $check_sales = MainLayout::select('temp_sales_page')->first();
                if($check_sales->temp_sales_page == 1){
                    $memberships = Membership::all();
                    $descriptions = Description::all()->where('title', '!=','About')
                      ->where('title', '!=', 'Sale');

                    $sale = Description::where('title', '=', 'Sale')->first();

                    return view('public.pages.membership', compact('memberships', 'descriptions', 'sale'));
                }else{
                    $memberships = Membership::all();
                    $descriptions = Description::all()->where('title', '!=','About')
                      ->where('title', '!=', 'Sale');

                    return view('public.pages.membership', compact('memberships', 'descriptions'));
                }

                break;

            case 'home':
                $home = Home::all()->first();

                $left_list = explode(',', $home->left_list);

                return view('public.pages.index', compact('home', 'left_list'));
                break;

            case 'class_schedule':
                $hours = ClassSchedule::all();
                return view('public.pages.class_schedule',  compact('hours'));

            case 'about':
                $about = Description::where('title', 'About')->first();
                return view('public.pages.about', compact('about'));

            case 'contact':
                $info = MainLayout::all()->first();

                return view('public.pages.contact', compact('info'));

        }

    }
/* echo '<pre>';
        print_r($memberships);
        echo '</pre>';
        exit;*/


   public function contact(Request $request){

       $rules = [
         'firstname' => 'required|min:2',
           'email' => 'required|email',
           'subject' => 'required',
           'message' => 'required|min:8'
       ];

       $validator = $this->validate($request, $rules);

       if(!empty($validator)){
           return response()->json(['errors' => $validator->errors()->all()]);

       }else{
           $contact = [
             'firstname' => $request->input('firstname'),
             'email' => $request->input('email'),
             'subject' => $request->input('subject'),
             'message' => $request->input('message'),
             'date' => Carbon::now()->toFormattedDateString()
           ];

           Mail::send(new ContactPage($contact));

           return response()->json(['firstname' => $request->firstname]);

       }



   }
}

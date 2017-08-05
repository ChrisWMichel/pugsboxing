<?php

namespace App\Http\Controllers\admin;

use App\Home;
use App\MainLayout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home = Home::all()->first();
        //$phone = MainLayout::pluck('phone')->first();

        return view('admin.cms.home', compact('home'));
    }


    public function update(Request $request, $id)
    {
        switch ($request->data){
            case 'left-list':
                //Home::where($id)->update(['left_list' => $request->left_list]);
                $home = Home::find($id);
                $home->update(['left_list' => $request->left_list]);

                return redirect()->back();

            case 'home_title':
                $home = Home::find($id);
                $home->update(['home_title' => $request->home_title]);

                return redirect()->back();

            case 'right_content':
                $home = Home::find($id);
                $home->update(['right_content' => $request->right_content]);

                return redirect()->back();
        }
    }


}
/* echo '<pre>';
        print_r($left_list);
        echo '</pre>';*/
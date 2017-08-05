<?php

namespace App\Http\Controllers\admin;

use App\Description;
use App\MainLayout;
use App\Membership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackagesController extends Controller
{
    public function update(Request $request)
    {
        $id = $request->input('id');
        $package = $request->input('package');
        $price = $request->input('price');
        $pack_num = $request->input('pack_num');

        $input = Membership::find($id);
        $input->package = $package;
        $input->price = $price;
        $input->pack_num = $pack_num;
        $input->save();

        flash('Update was successfull')->success();
    }

    public function delete(Request $request){
        $id = $request->input('id');

        $package = Membership::find($id);

        $package->delete();
        //return response()->json($request);

        flash('Package was deleted successfully')->success();
    }

    public function getdesc(){
        $descriptions = Description::all()->where('title', '!=','About');

        return view('admin.cms.packagedesc', compact('descriptions'));
    }


}

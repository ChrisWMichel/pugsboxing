<?php

namespace App\Http\Controllers\admin;

use App\Description;
use App\MainLayout;
use App\Members;
use App\Membership;
use App\PersonalsPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberships = Membership::all();
        $sale = Description::where('title', '=', 'Sale')->first();

        $check_sales = MainLayout::select('temp_sales_page')->first();

        return view('admin.cms.packages', compact('memberships', 'sale', 'check_sales'));
    }

    public function store(Request $request)
    {
        $package = $request->input('package');
        $price = $request->input('price');
        $category_id = $request->input('catID');

        Membership::create([
          'category_id' => $category_id,
            'package' => $package,
            'price' => $price
        ]);

        flash('Package was created successfully.')->success();

    }

    public function update(Request $request, $id){

        $description = Description::find($id);

        $description->title = $request->title;
        $description->body = $request->body;
        $description->save();

        return redirect()->back();
    }


}

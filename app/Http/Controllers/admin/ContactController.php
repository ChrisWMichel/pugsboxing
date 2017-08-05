<?php

namespace App\Http\Controllers\admin;

use App\MainLayout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = MainLayout::all()->first();



        return view('admin.cms.contact', compact('info'));
    }


    public function update(Request $request, $id)
    {
        $info = MainLayout::find($id);

        $info->update($request->all());

        flash('Update was successfull')->success();

        return redirect()->back();
    }


}

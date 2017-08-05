<?php

namespace App\Http\Controllers\admin;

use App\Description;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = Description::where('title', 'About')->first();

        return view('admin.cms.about', compact('about'));
    }


    public function update(Request $request, $id)
    {
        $about = Description::find($id);

        $about->body = $request->body;
        $about->save();

        flash('About page has been updated.')->success();

        return redirect()->back();
    }


}

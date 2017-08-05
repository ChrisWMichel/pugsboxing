<?php

namespace App\Http\Controllers\admin;

use App\HeaderPhoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeaderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = HeaderPhoto::all();

        return view('admin.cms.header', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($file = $request->path){

            $name = $file->getClientOriginalName();

            $file->move('images', $name); // public/image folder

            HeaderPhoto::create(['path' => $name]); // put the image path in the photo DB
        }

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        print_r( 'edit request method');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = HeaderPhoto::find($id);
        $visible = $input->visible == 1 ? 0 : 1;

        $input->update(['visible' => $visible]);

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = HeaderPhoto::find($id);

        if (file_exists($filename = public_path() . '/images/' .$input->path)) {
            unlink($filename);
        }
        $input->delete();

        return redirect()->back();
    }
}

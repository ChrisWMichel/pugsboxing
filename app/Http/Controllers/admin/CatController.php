<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\Members;
use App\Membership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatController extends Controller
{
    public function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $description = $request->input('description');

        $input = Category::find($id);
        $input->name = $name;
        $input->description = $description;
        $input->save();

        flash('Update was successfull')->success();
    }

    public function delete(Request $request){
        $id = $request->input('id');

        $cat = Category::find($id);

        $packages = Membership::where('category_id', $id);

        if(!empty($packages)) {
            foreach ($packages as $package) {
                $package->delete();
            }
        }

        $cat->delete();
        //return response()->json($request);

        flash('Category was deleted successfully')->success();
    }


}

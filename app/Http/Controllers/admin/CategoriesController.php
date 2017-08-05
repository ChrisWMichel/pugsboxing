<?php

namespace App\Http\Controllers\admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.cms.categories', compact('categories'));
    }


    public function store(Request $request)
    {
        //$name = $request->input('name');
        //$description = $request->input('description');

        Category::create($request->all());

        flash('Category was created successfully.')->success();

        /*return response()->json([
          'name' => $name,
            'description' => $description
        ]);*/

    }


}

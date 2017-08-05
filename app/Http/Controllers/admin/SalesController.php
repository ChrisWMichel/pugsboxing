<?php

namespace App\Http\Controllers\admin;

use App\Description;
use App\MainLayout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function update(Request $request, $id){

        $sale = Description::find($id);

        $sale->update(['body' => $request->body]);

        return redirect()->back();
    }

    public function show($id){
        $main_layout = MainLayout::find($id)->first();

        if($main_layout->temp_sales_page == 0){
            $main_layout->update(['temp_sales_page' => 1]);
        }elseif($main_layout->temp_sales_page == 1){
            $main_layout->update(['temp_sales_page' => 0]);
        }
    }
}

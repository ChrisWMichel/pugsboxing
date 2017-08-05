<?php

namespace App\Http\Controllers\generalPublic;

use App\HeaderPhoto;
use App\Home;
use App\MainLayout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use function PHPSTORM_META\map;

class HomesController extends Controller
{
    public function index(Request $request){

        $phone = MainLayout::select('phone')->first();
        $photos = HeaderPhoto::where('visible', 1)->get();

        return view('layouts.public_layout', compact('photos', 'phone'));
    }
}
/*echo '<pre>';
        print_r($photos);
        echo '</pre>';
exit;
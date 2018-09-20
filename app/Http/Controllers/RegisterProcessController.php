<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

use App\Http\Requests;

class RegisterProcessController extends Controller
{
    public function indexAction(Request $request){
        $countries = Country::select("*")->orderBy("country")->get();
        $email = $request->input("email");
        $pageType = "checkout";
        return view("/public/registerProcess/index", compact("pageType", "email", "countries"));

    }
}

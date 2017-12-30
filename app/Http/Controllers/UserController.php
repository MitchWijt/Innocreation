<?php

namespace App\Http\Controllers;

use App\expertises_linktable;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccount()
    {
        if(Session::has("user_name")) {
            $id = Session::get("user_id");
            $user = User::select("*")->where("id", $id)->first();
            return view("/public/user/userAccount", compact("user"));
        } else {
            return view("/public/home/home");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccountCredentials()
    {
        if(Session::has("user_name")) {
            $id = Session::get("user_id");
            $user = User::select("*")->where("id", $id)->first();
            return view("/public/user/userAccountCredentials", compact("user"));
        } else {
            return view("/public/home/home");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveUserAccount(Request $request)
    {
        $user_id = $request->input("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $user->skype = $request->input("skype");
        $user->motivation = $request->input("motivation_user");
        $user->introduction = $request->input("introduction_user");
        $user->save();
        return redirect($_SERVER["HTTP_REFERER"])->with('success', 'Account successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userAccountExpertises()
    {
        $user_id = Session::get("user_id");
        $expertises_linktable = expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
        return view("/public/user/userAccountExpertises", compact("expertises_linktable"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\country;
use Auth;
use Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $test = Session::get("user_name");
        $countries = Country::select("*")->orderBy("country")->get();
        return view("public/register/login", compact("countries", "test"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required',
            'email' => 'required',
            'expertises' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'state' => 'required',
            'country' => 'required',
            'phonenumber' => 'required',

        ]);
        $user = New User;
        $user->role = 2;
        $user->firstname = $request->input("firstname");
        if($request->input("middlename") != null){
            $user->middlename = $request->input("middlename");
        }
        $user->lastname = $request->input("lastname");
        $user->password = bcrypt(($request->input("password")));
        $user->email = $request->input("email");
        $user->city = $request->input("city");
        $user->postalcode = $request->input("postcode");
        $user->state = $request->input("state");
        $user->country = $request->input("country");
        $user->phonenumber = $request->input("phonenumber");
        $user->save();

        return redirect($_SERVER["HTTP_REFERER"])->with('success','Account created');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $request->get('email');
        $password = $request->get('password');
//        dd($email);
//        dd($password);
        if(Auth::attempt(['email'=>$email,'password'=>$password])) {
            $user = User::select("*")->where("email", $email)->first();
            Session::set('user_name', $user->firstname);
            Session::set('user_role', $user->role);
            return redirect($_SERVER["HTTP_REFERER"])->with('success','Welcome ' . $user->firstname . '!');
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors('it seems you logged in with the wrong credentials');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

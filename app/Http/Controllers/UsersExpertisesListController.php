<?php

namespace App\Http\Controllers;

use App\Expertises;
use Illuminate\Http\Request;

use App\Http\Requests;

class UsersExpertisesListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expertisesListAction()
    {
        $title = "Find the expertise you need for your idea!";
        $og_description = "All active users and expertises on Innocreation. Find motivated people, create your team and build your idea";
        $expertises = Expertises::select("*")->orderBy("title")->paginate(10);
        return view("/public/users-expertisesList/expertisesList", compact("expertises", "title", "og_description"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function usersListAction($title) {
        $expertise = Expertises::select("*")->where("title", $title)->first();
        $title = "Find your $expertise->title and work together";
        $og_description = "Find the best $expertise->title for your team. Work together and build your idea!";
        return view("/public/users-expertisesList/usersList", compact("expertise", "title", "og_description"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

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
    public function expertisesListAction(){
        $allTags2 = [];
        $title = "Find the expertise you need for your idea!";
        $og_description = "All active users and expertises on Innocreation. Find motivated people, create your team and build your idea";
        $expertises = Expertises::select("*")->orderBy("title")->paginate(9);
        foreach($expertises as $expertise){
            $explodeSingleExpertise = explode(",", $expertise->getTags());
            foreach($explodeSingleExpertise as $tag){
                if($tag != "") {
                    array_push($allTags2, trim($tag));
                }
            }
        }
        $allTags = array_unique($allTags2);
        return view("/public/users-expertisesList/expertisesList", compact("expertises", "title", "og_description", "allTags"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function usersListAction($title) {
        $expertise = Expertises::select("*")->where("slug", $title)->first();
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
    public function searchExpertiseAction(Request $request){
        $allTags2 = [];
        $title = "Find the expertise you need for your idea!";
        $og_description = "All active users and expertises on Innocreation. Find motivated people, create your team and build your idea";
        $expertises = Expertises::select("*")->orderBy("title")->get();
        foreach($expertises as $expertise){
            $explodeSingleExpertise = explode(",", $expertise->getTags());
            foreach($explodeSingleExpertise as $tag){
                if($tag != "") {
                    array_push($allTags2, trim($tag));
                }
            }
        }

        $allTags = array_unique($allTags2);

        $searchInput = $request->input("searchedExpertise");
        $searchedExpertises = [];
        $expertises = Expertises::select("*")->get();
        foreach($expertises as $expertise){
            if($searchInput != "") {
                if (strpos($expertise->tags, $searchInput) !== false) {
                    array_push($searchedExpertises, $expertise);
                }
            } else {
                array_push($searchedExpertises, $expertise);
            }
        }

        return view("/public/users-expertisesList/expertisesList", compact("searchedExpertises", "allTags", "title", "og_description", "expertises"));
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

<?php

namespace App\Http\Controllers;

use App\UserChat;
use Illuminate\Http\Request;

use App\Http\Requests;

class DebugController extends Controller
{
    public function test(){
        if($this->authorized(true)){
            die("test");
        }
    }
}

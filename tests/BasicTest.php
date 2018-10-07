<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class BasicTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserGetName()
    {
        $user = User::select("*")->where("id", 10)->first();
        $user->firstname = "MitchelTest";
        $user->middlename = "Van";
        $user->lastname = "Wijt";
        $user->save();
        $this->assertEquals('MitchelTest Van Wijt', $user->getName());


//
//        $user = new User();
//        $user->firstname = "Mitchel";
//        $user->lastname = "Wijt";
//        $this->assertEquals('Mitchel Wijt', $user->getName());

    }
}

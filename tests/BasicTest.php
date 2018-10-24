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
        $user->firstname = "Mitchel";
        $user->lastname = "Wijt";
        $user->save();
        $this->assertEquals('Mitchel Wijt', $user->getName());

    }

    public function testCheckHomepage(){
        $this->visit('/')
            ->click('collaborateNow');

    }
}

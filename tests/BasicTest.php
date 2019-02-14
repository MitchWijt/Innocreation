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
    public function testCheckHomepage(){
        $this->visit('/')
            ->see('idea?');
    }
}

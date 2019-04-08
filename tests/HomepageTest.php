<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;


class HomepageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCtaText(){
        $this->visit('/');
        $this->see('Innocreation');
        $this->see("Collaborate with creatives");
        $this->see("Active in various creative expertises");
        $this->seeLink("I want to connect!", "/what-is-innocreation");
    }

    public function testCarousel(){
        $this->visit('/');
        $this->seeElement(".carousel-default");
    }
}

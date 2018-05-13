<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembershipPackage extends Model
{
    public $table = "membership_package";


    function getPrice($precision = 2, $separator = '.')
    {
        $numberParts = explode($separator, $this->price);
        $response = $numberParts[0];
        if(count($numberParts) > 1 ) {
            $response .= $separator;
            $response .= substr($numberParts[1], 0, $precision);
        }
        return $response;
    }
}

<?php

namespace App\Classes;

use Nette\Utils\DateTime;

class Calculation
{
    /*Calculate End Date*/
    function calculateEndTime($time){
        $temp = explode(":",$time);
        $temp[1] = $temp[1] + 30;
        if ($temp[1] >= 60){
            $temp[1] = $temp[1] - 60;
            $temp[0] = $temp[0] + 1;
        }
        $temp[0] = $temp[0] + 8;
        if ($temp[0] >= 24){
            $temp[0] = $temp[0] - 24;
        }
        return $temp[0] . ":" . $temp[1] . ":" . $temp[2];
    }

//    Calculate employee join date for profile.blade
    function calculateDate($joinDate,$value){
        $temp = explode("-",$joinDate);
        $temp[1] = $temp[1] + $value;
        if ($temp[1] > 12){
            $temp[1] = $temp[1] - 12;
            $temp[0] = $temp[0] + 1;
        }
        if(strlen($temp[1]) == 1){
            $temp[1] = sprintf("%02d", $temp[1]);
        }
        return $temp;
    }
//    Calculate today difference using join date for profile.blade
    function getDifference($joinDate,$value){
        $completeDate = new DateTime(implode("-", $this->calculateDate($joinDate, $value)));
        $today = new DateTime(date('Y-m-d'));

        if($completeDate < $today){
            return true;
        }
        else{
            return false;
        }
    }
}


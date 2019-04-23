<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shift_model extends CI_Model{
	
	
    public function getSiftDate($satrt_time){

        $shiftCode = "";
        $shiftDate = NULL;
        $timeHr = date("H",strtotime($satrt_time));
        // change 1 to 0 hour in condition 29.03.2019 by shankha
        if($timeHr>=0 AND $timeHr<6){
           // $shiftCode = "C";
           $shiftDate = date("Y-m-d",strtotime($satrt_time." -1 day"));
        }
        if($timeHr>=6 AND $timeHr<14){
           // $shiftCode = "A";
           $shiftDate = date("Y-m-d",strtotime($satrt_time));
        }
        elseif($timeHr>= 14 && $timeHr<22){
          //  $shiftCode = "B";
          $shiftDate = date("Y-m-d",strtotime($satrt_time));
        }
        elseif($timeHr>= 22){
          //  $shiftCode = "C";
          $shiftDate = date("Y-m-d",strtotime($satrt_time));
        }
        return $shiftDate;
    }
	
    
	
}
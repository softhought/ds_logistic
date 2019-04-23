<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trackingmodel extends CI_Model{

    public function getTrackingDetailsList($fromDt,$toDt)
    {
       /*
        echo "From Date ".$fromDt;
        echo "<br>";
        echo "toDt Date ".$toDt;
      */
        $data = [];
        $query=$this->db->select('*')
                        ->from('driver_tracking_history')
                        ->join('driver_master','driver_tracking_history.driver_empl_code=driver_master.driver_code','INNER')
                        ->join('vehicle_master','driver_tracking_history.mobile_id=vehicle_master.mobile_uniq_id','INNER')
						->join('project_master','vehicle_master.project_id=project_master.project_id','INNER')
                        ->join('dumping_yard_master','dumping_yard_master.dumping_yard_id=driver_tracking_history.dumping_yard_id','LEFT')
                        ->where('DATE_FORMAT(`driver_tracking_history`.`session_satrt_time`,"%Y-%m-%d") >= ', $fromDt)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`session_satrt_time`,"%Y-%m-%d") <= ', $toDt)
                        ->order_by("driver_tracking_history.session_satrt_time", "desc")
                        ->get();
                    //   echo $this->db->last_query();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = [
                    "trackingDetailRows" => $rows,
                    "excavatorData" => $this->getExcavatorDetail($rows->vehicle_equipment_id),
                    "siftData" => $this->getShiftDetail($rows->session_satrt_time),
                    "excavatorassigncheck" => $this->getAssigncheck($rows->shift_date,$rows->shift_code,$rows->project_id,$rows->vehicle_equipment_id),
                    "excavatorOperator" => $this->getExcavatorOperator($rows->shift_date,$rows->shift_code,$rows->project_id,$rows->vehicle_equipment_id)
                ];
            }
            return $data;
        }else{
            return $data;
         }
    }

    /*--------------------------------- added on 8 march by shankha -------------------------- */
    public function getTrackingDetailsListByProject($projectid,$fromDt,$toDt)
    {
       /*
        echo "From Date ".$fromDt;
        echo "<br>";
        echo "toDt Date ".$toDt;
        echo "<br>";
        echo "Project Id ".$projectid;
      */
        $data = [];
        $wherereproject = array('project_master.project_id' => $projectid);
        $query=$this->db->select('*')
                        ->from('driver_tracking_history')
                        ->join('driver_master','driver_tracking_history.driver_empl_code=driver_master.driver_code','INNER')
                        ->join('vehicle_master','driver_tracking_history.mobile_id=vehicle_master.mobile_uniq_id','INNER')
                        ->join('project_master','vehicle_master.project_id=project_master.project_id','INNER')
                        ->join('dumping_yard_master','dumping_yard_master.dumping_yard_id=driver_tracking_history.dumping_yard_id','LEFT')
                        ->where($wherereproject)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`session_satrt_time`,"%Y-%m-%d") >= ', $fromDt)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`session_satrt_time`,"%Y-%m-%d") <= ', $toDt)
                        ->order_by("driver_tracking_history.session_satrt_time", "desc")
                        ->get();
                    //   echo $this->db->last_query();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = [
                    "trackingDetailRows" => $rows,
                    "excavatorData" => $this->getExcavatorDetail($rows->vehicle_equipment_id),
                    "siftData" => $this->getShiftDetail($rows->session_satrt_time),
                    "excavatorassigncheck" => $this->getAssigncheck($rows->shift_date,$rows->shift_code,$rows->project_id,$rows->vehicle_equipment_id),
                    "excavatorOperator" => $this->getExcavatorOperator($rows->shift_date,$rows->shift_code,$rows->project_id,$rows->vehicle_equipment_id)
                ];
            }
            return $data;
        }else{
            return $data;
         }
    }


    public function getExcavatorDetail($vehicle_equipment_id) {
        $data = [];
        $query=$this->db->select('vehicle_master.equipment_id,vehicle_master.equipment_name AS excavatorname,vehicle_master.equipment_model')
                         ->from('vehicle_master')
                         ->where('vehicle_master.equipment_id',$vehicle_equipment_id)
                         ->get();
                        //echo $this->db->last_query();
        if($query->num_rows()> 0)
        {
            $rowData = $query->row();
            return $rowData;
        }
        else{
            return $data;
         }
    }

    

    public function getShiftDetail($sessionTime) {
        $data = [];

        $startTime = date("H",strtotime($sessionTime));
        $shiftCode = $this->getSiftCode($startTime);
        
        $query=$this->db->select('*')
                         ->from('shift_master')
                         ->where('shift_master.shift_code',$shiftCode)
                        
                         ->get();
        
        if($query->num_rows()> 0)
        {
            $rowData = $query->row();
            return $rowData;
        }
        else{
            return $data;
        }
    }



    public function getSiftCode($timeHr){
        $shiftCode = "";
         // change 1 to 0 hour in condition 29.03.2019 by shankha
        if($timeHr>=0 AND $timeHr<6){
            $shiftCode = "C";
        }
        if($timeHr>=6 AND $timeHr<14){
            $shiftCode = "A";
        }
        elseif($timeHr>= 14 && $timeHr<22){
            $shiftCode = "B";
        }
        elseif($timeHr>= 22){
            $shiftCode = "C";
        }
        return $shiftCode;
    }

// excavator assign check
    public function getAssigncheck($shift_date,$shift_code,$project_id,$vehicle_equipment_id) {
        $data = [];

        $where = array(
            'excavator_assign.shift_date' =>$shift_date,
            'excavator_assign.shift_code' =>$shift_code,
            'excavator_assign.project_id' =>$project_id,
            'excavator_assign.equipment_id' =>$vehicle_equipment_id,
            'excavator_assign.is_deleted' =>'N'
         );
        $query=$this->db->select('*')
                         ->from('excavator_assign')
                         ->where($where)
                         ->get();
                        //echo $this->db->last_query();
        if($query->num_rows()> 0)
        {
           
            return 1;
        }
        else{
            return 0;
         }
    }

    // excavator assign check
    public function getExcavatorOperator($shift_date,$shift_code,$project_id,$vehicle_equipment_id) {
        $data = [];

        $where = array(
            'excavator_assign.shift_date' =>$shift_date,
            'excavator_assign.shift_code' =>$shift_code,
            'excavator_assign.project_id' =>$project_id,
            'excavator_assign.equipment_id' =>$vehicle_equipment_id,
            'excavator_assign.is_deleted' =>'N'
         );
        $query=$this->db->select('*,driver_master.driver_name,supervisor_master.name AS supervisor_name')
                         ->from('excavator_assign')
                         ->join('driver_master','driver_master.driver_code=excavator_assign.driver_code','INNER')
                         ->join('supervisor_master','supervisor_master.supervisor_id=excavator_assign.supervisor_id','INNER')
                         ->where($where)
                         ->get();
                       // echo $this->db->last_query();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = $rows;
            }
            return $data ;
        }
        else{
            return $data ;
         }
    }

}/* end of class */
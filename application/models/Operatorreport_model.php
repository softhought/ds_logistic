<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Operatorreport_model extends CI_Model{

	public function getExcavaorOperatorList($projectid,$reoprtType,$fromDate,$toDate)
    {
      $data=[];

      if ($projectid!=0) {

           $where = array(
                      
                        'excavator_assign.project_id' => $projectid,
                        'excavator_assign.is_deleted' => 'N',
                        'vehicle_type.vehicle_type' => 'EXCAVATOR',
                     
                     );
          
      }else{
           
             $where = array(
                        'excavator_assign.is_deleted' => 'N',
                        'vehicle_type.vehicle_type' => 'EXCAVATOR',
                     
                     );

      }

     

      $query=$this->db->select('*')
                        ->from('excavator_assign')
                        ->join('driver_master','driver_master.driver_code=excavator_assign.driver_code','INNER')
                        ->join('vehicle_type','vehicle_type.vehicle_type_id=driver_master.vehicle_type_id','INNER')
                        ->where($where)
                         ->where('DATE_FORMAT(`excavator_assign`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                        ->where('DATE_FORMAT(`excavator_assign`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->order_by('driver_master.driver_name', 'asc')
                        ->group_by('driver_master.driver_name')
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
               // $data[] = $rows;

        	 $data[]=[
                  "operatorData"=>$rows,
                  "driver_code"=>$rows->driver_code,
                  "equipment_id"=>$rows->equipment_id,
                  "tripCountshiftType"=>$this->getShiftType($projectid,$reoprtType,$fromDate,$toDate,$rows->driver_code),
                 
                  
                ];
         
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }



    public function getShiftType($projectid,$reoprtType,$fromDate,$toDate,$driver_code)
    {
      $data=[];
      $tripCount=0;
      $where = array(
                      'shift_master.is_active' => 'Y',
                      
                     );

      $query=$this->db->select('*')
                        ->from('shift_master')
                        ->where($where)
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
             //   $data[] = $rows;

        	$tripCount+=$this->getExcavatorAssignData($projectid,$reoprtType,$fromDate,$toDate,$driver_code,$rows->shift_code);

                     $data[]=[
                       // "shiftData"=>$rows,
                        "tripCountTotal"=>$tripCount,

                        "tripCount"=>$this->getExcavatorAssignData($projectid,$reoprtType,$fromDate,$toDate,$driver_code,$rows->shift_code)
                     
                      ];

               
           
        }
        return $tripCount;
      }
      else
      {
        return $tripCount;
      }
    }



    // get excavator operator assign data 
public function getExcavatorAssignData($projectid,$reoprtType,$fromDate,$toDate,$driver_code,$shift_code){

       $trackingDataCount=0;
        $data=[];
       if ($projectid!=0) {

         $where = array(
                        'excavator_assign.project_id' => $projectid,
                        'excavator_assign.driver_code' => $driver_code,
                        'excavator_assign.shift_code' => $shift_code,
                        'excavator_assign.is_deleted' => 'N',
                       
                       );
        
       }else{
           $where = array(
                        'excavator_assign.driver_code' => $driver_code,
                        'excavator_assign.shift_code' => $shift_code,
                        'excavator_assign.is_deleted' => 'N',
                       
                       );

       }
     

      $query=$this->db->select('*')
                        ->from('excavator_assign')
                        ->where($where)
                        ->where('DATE_FORMAT(`excavator_assign`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                        ->where('DATE_FORMAT(`excavator_assign`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                         ->group_by('excavator_assign.equipment_id,excavator_assign.shift_date,excavator_assign.shift_code')
                        ->get();
                       # q();

      if($query->num_rows()>0){
       
         foreach ($query->result() as $rows)
        {
           
               // $data[] = $rows;

        	$trackingDataCount+=$this->getExcavatorTrackingCountData($projectid,$reoprtType,$fromDate,$toDate,$driver_code,$rows->shift_code,$rows->shift_date,$rows->equipment_id);

        	 $data[]=[
                      //  "excavatorAssignData"=>$rows,
                       // "trackingData"=>$trackingDataCount,
                      //  "trackingData"=>$this->getExcavatorTrackingCountData($projectid,$reoprtType,$fromDate,$toDate,$driver_code,$rows->shift_code,$rows->shift_date,$rows->equipment_id)
                     
                      ];

        	
        }
       return $trackingDataCount;
      }
      else
      {
        return $trackingDataCount;
      }

}




 // get excavator tracking data count
public function getExcavatorTrackingCountData($projectid,$reoprtType,$fromDate,$toDate,$driver_code,$shift_code,$shift_date,$equipment_id){

        $tripcount=0;
        $data=[];


         $where = array(
                        'driver_tracking_history.vehicle_equipment_id' => $equipment_id,                     
                        'driver_tracking_history.shift_code' => $shift_code,                     
                        'driver_tracking_history.shift_date' => $shift_date                     
                       );
      
      $query=$this->db->select('COUNT(*) AS tripcount')
                        ->from('driver_tracking_history')
                        ->where($where)
                        ->get();
                       # q();

      if($query->num_rows()>0){
       
       $row = $query->row();
           return $count = $row->tripcount;
     
      }
      else
      {
        return $data;
      }

}

}// end of class
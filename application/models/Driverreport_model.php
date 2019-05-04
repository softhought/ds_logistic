<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Driverreport_model extends CI_Model{



	    public function getTipperDriverList($projectid,$reoprtType,$fromDate,$toDate)
    {
      $data=[];

      if ($projectid!=0) {

           $where = array(
                       'vehicle_type.vehicle_type' => 'TIPPER',
                        'project_master.project_id' => $projectid,
                      
                     );
          
      }else{
           
            $where = array('vehicle_type.vehicle_type' => 'TIPPER');

      }

     

      $query=$this->db->select('*')
                        ->from('driver_master')
                        ->join('vehicle_type','vehicle_type.vehicle_type_id=driver_master.vehicle_type_id','INNER')
                        ->join('project_master','project_master.project_nickname=driver_master.working_project_id','INNER')
                        ->where($where)
                        ->order_by('driver_master.driver_name', 'asc')
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
               // $data[] = $rows;

        	 $data[]=[
                  "driverData"=>$rows,
                  "TripCount"=>$this->getDriverTripCount($projectid,$reoprtType,$fromDate,$toDate,$rows->driver_code),
                  "LeadSum"=>$this->getDriverTripList($projectid,$reoprtType,$fromDate,$toDate,$rows->driver_code)
                  
                ];
         
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }



    // get driver trip count 
public function getDriverTripCount($projectid,$reoprtType,$fromDate,$toDate,$driver_code){

       $count=0;
       if ($projectid!=0) {

         $where = array(
                        'driver_tracking_history.driver_empl_code' => $driver_code,
                        'project_material_details.project_id' => $projectid
                       );
        
       }else{
          $where = array(
                        'driver_tracking_history.driver_empl_code' => $driver_code,
                       );

       }
     

      $query=$this->db->select('
                          COUNT(*) AS tripcount
                          ')
                        ->from('driver_tracking_history')
                        ->join('project_material_details','project_material_details.project_material_id=driver_tracking_history.project_material_id','INNER')
                        ->where($where)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->get();
                       # q();

      if($query->num_rows()>0){
       
        $row = $query->row();
           return $count = $row->tripcount;
       
      }
      else
      {
        return $count;
      }

}


    // get driver trip count 
public function getDriverTripList($projectid,$reoprtType,$fromDate,$toDate,$driver_code){

       $count=0;
       if ($projectid!=0) {

         $where = array(
                        'driver_tracking_history.driver_empl_code' => $driver_code,
                        'project_material_details.project_id' => $projectid
                       );
        
       }else{
          $where = array(
                        'driver_tracking_history.driver_empl_code' => $driver_code,
                       );

       }
     

      $query=$this->db->select('driver_tracking_history.*')
                        ->from('driver_tracking_history')
                        ->join('project_material_details','project_material_details.project_material_id=driver_tracking_history.project_material_id','INNER')
                        ->where($where)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->get();
                       
                       # q();

      if($query->num_rows()>0){
       
        foreach ($query->result() as $rows)
        {
           
               $count+=$this->getLeadByTrackingDetails($projectid,$rows->vehicle_equipment_id,$rows->shift_date,$rows->shift_code,$rows->project_material_id,$driver_code);

      
        }
        return $count;
      }
      else
      {
        return $count;
      }

}



    // get driver trip count 
public function getLeadByTrackingDetails($projectid,$excavator_equipment_id,$shift_date,$shift_code,$project_material_id,$driver_code){

       $lead=0;
       

         $where = array(
                        'vehicle_master.equipment_id' => $excavator_equipment_id,
                        'lead_against_vehicle.shift_date' => $shift_date,
                        'lead_against_vehicle.project_material_id' => $project_material_id,
                        
                       );
       
     

      $query=$this->db->select('
                         lead_against_vehicle.lead
                          ')
                        ->from('lead_against_vehicle')
                        ->join('vehicle_master','vehicle_master.vehicle_id=lead_against_vehicle.vehicle_mst_id','INNER')
                        ->where($where)
                        ->group_by('lead_against_vehicle.shift_code')
                        ->get();
                        
                       #q();

      if($query->num_rows()>0){
       
           $row = $query->row();
           return $lead = $row->lead;
       
      }
      else
      {
        return $lead;
      }

}


}// end of class
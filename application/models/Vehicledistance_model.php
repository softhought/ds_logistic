<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vehicledistance_model extends CI_Model{
	
	public function getVehicleDistanceDetailsBymstId($vehicle_distance_mstid)
    {
        $data = array();
        $where = array('vehicle_distance_details.distance_master_id' => $vehicle_distance_mstid);
        $query=$this->db->select('
                                    vehicle_distance_details.distance_details_id,
                                    vehicle_master.equipment_id,
                                    vehicle_master.equipment_name,
                                    vehicle_distance_details.start_km,
                                    vehicle_distance_details.start_time,
                                    vehicle_distance_details.end_km,
                                    vehicle_distance_details.end_time,
                                    vehicle_distance_details.km_differ,
                                    vehicle_distance_details.time_differ
                                ')
                        ->from('vehicle_distance_details')
                        ->join('vehicle_master','vehicle_master.equipment_id=vehicle_distance_details.equipment_id','INNER')
                        ->where($where)
                        ->get();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = $rows;
            }
            return $data;
        }else{
            return $data;
         }
    }




    public function updateVehicleDistancrDetails($upd_data,$distance_details_id)
    {
        $upd_where = array('vehicle_distance_details.distance_details_id' => $distance_details_id );
         try {
            $this->db->trans_begin();
            $this->db->where($upd_where);
            $this->db->update('vehicle_distance_details',$upd_data);
       
   
            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
        catch (Exception $err) {
            echo $err->getTraceAsString();
        }
    }



  public function getLastRowVehicleDistanceMaster($project,$vehicle_type)
    {
        $data = array();
         $where = array(
                                'vehicle_distance_master.project_id' => $project, 
                                'vehicle_distance_master.vehicle_type_id' => $vehicle_type,
                               
                                                 
                                );
        $this->db->select("*")
                ->from('vehicle_distance_master')
                ->where($where)
                ->order_by('vehicle_distance_id',"desc")
                ->limit(1);
        $query = $this->db->get();
        
        //echo $this->db->last_query();
        
        if($query->num_rows()> 0)
        {
           $row = $query->row();
           return $data = $row;
             
        }
        else
        {
            return $data;
        }
    }



  public function getVehicleLastDistanceByMasterId($vehicle_distance_mstid,$project,$vehicle_type)
    {
        $data = array();
        $where_vehicle = array(
                                'vehicle_master.project_id' => $project, 
                                'vehicle_master.vehicle_type_id' => $vehicle_type,
                                'vehicle_master.is_active' => 'Y'
                                                 
                                ); 
        $query=$this->db->select('*
                                ')
                        ->from('vehicle_master')
                        
                        ->where($where_vehicle)
                        ->get();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
               // $data[] = $rows;

                 $data[]=[
                  "vihicleData"=>$rows,
                  "lastDistance"=>$this->lastDistanceVehicle($vehicle_distance_mstid,$rows->equipment_id),
                  "lastHour"=>$this->lastHourVehicle($vehicle_distance_mstid,$rows->equipment_id)
                 
                  
                ];
            }
            return $data;
        }else{
            return $data;
         }
    }

	
	function lastDistanceVehicle($vehicle_distance_mstid,$equipment_id){
         $lastdistance=0;
         $vehi_dist_arr = array(
                                'distance_master_id' => $vehicle_distance_mstid,
                                'equipment_id' => $equipment_id,
                                 );
       
         $vehicleDistanceData = $this->commondatamodel->getSingleRowByWhereCls('vehicle_distance_details',$vehi_dist_arr);

         if ($vehicleDistanceData) {
          
            $lastdistance=$vehicleDistanceData->end_km;
            return $lastdistance;
        
         }else{

                    $vehicleLastDistanceData=$this->getVehicleLastDistance($equipment_id);

                    if ($vehicleLastDistanceData) {
                        $lastdistance=$vehicleLastDistanceData->end_km;
                        return $lastdistance;
                    }else{
                        return $lastdistance;
                    }

               
         }

       
    }


    /* last hour */


      function lastHourVehicle($vehicle_distance_mstid,$equipment_id){
         $lasthour=0;
         $vehi_hour_arr = array(
                                'distance_master_id' => $vehicle_distance_mstid,
                                'equipment_id' => $equipment_id,
                                 );
       
         $vehicleHourData = $this->commondatamodel->getSingleRowByWhereCls('vehicle_distance_details',$vehi_hour_arr);

         if ($vehicleHourData) {
          
            $lasthour=$vehicleHourData->end_time;
            return $lasthour;
        
         }else{

                    $vehicleLastDistanceData=$this->getVehicleLastDistance($equipment_id);

                    if ($vehicleLastDistanceData) {
                        $lasthour=$vehicleLastDistanceData->end_time;
                        return $lasthour;
                    }else{
                        return $lasthour;
                    }

               
         }

       
    }
    

    /* get vehicle last distance */
    public function getVehicleLastDistance($equipment_id)
    {
        $data = array();
        $where = array('vehicle_distance_details.equipment_id' => $equipment_id );
        $this->db->select("*")
                ->from('vehicle_distance_details')
                ->where($where)
                ->order_by('distance_details_id',"desc")
                ->limit(1);
        $query = $this->db->get();
        
        //echo $this->db->last_query();
        
        if($query->num_rows()> 0)
        {
           $row = $query->row();
           return $data = $row;
             
        }
        else
        {
            return $data;
        }
    }



    public function rowcountvehicledistance($project,$vehicle_type)
    {
            $where = array(
                                'vehicle_distance_master.project_id' => $project, 
                                'vehicle_distance_master.vehicle_type_id' => $vehicle_type,
                               
                                                 
                                );
        $this->db->select('*')
                ->from('vehicle_distance_master')
                ->where($where);

        $query = $this->db->get();
        $rowcount = $query->num_rows();
    
        if($query->num_rows()>0){
            return $rowcount;
        }
        else
        {
            return 0;
        }
        
    }


    function checknextdata($project,$vehicle_type,$shiftdate,$shift_code){
       
       $next_shiftdate = date('Y-m-d', strtotime($shiftdate .' +1 day'));

             /* check data of next date */

               $check_array = array(
                              'project_id' =>  $project, 
                              'vehicle_type_id' =>  $vehicle_type, 
                              'shift_date >' =>  $next_shiftdate,  
                              );

               $checkdata=$this->commondatamodel->getSingleRowByWhereCls('vehicle_distance_master',$check_array);

               if ($checkdata) {
                  return 'Y';
               }else{

                     /* check data of same date */
                     $where_shift = array('shift_master.shift_code' =>$shift_code);

                     $shiftData=$this->commondatamodel->getSingleRowByWhereCls('shift_master',$where_shift);

                     $shift_slno = $shiftData->slno;

                       $check_array_same = array(
                                      'project_id' =>  $project, 
                                      'vehicle_type_id' =>  $vehicle_type, 
                                      'shift_date' =>  $shiftdate,  
                                      );

                      return $checkdatasame=$this->checkcountShift($project,$vehicle_type,$shiftdate,$shift_slno);



               }
    }



    public function checkcountShift($project,$vehicle_type,$shiftdate,$shift_slno)
    {
            $where = array(
                                'vehicle_distance_master.project_id' => $project, 
                                'vehicle_distance_master.vehicle_type_id' => $vehicle_type,
                                'shift_date' =>  $shiftdate, 
                               
                                                 
                                );
        $this->db->select('*')
                ->from('vehicle_distance_master')
                ->join('shift_master','shift_master.shift_code=vehicle_distance_master.shift_code','INNER')
                ->where($where)
                ->where('shift_master.slno >',$shift_slno); 

        $query = $this->db->get();
        #q();
        $rowcount = $query->num_rows();
    
        if($query->num_rows()>0){
             return 'Y';
        }
        else
        {
            return 'N';
        }
        
    }


    public function getVehicleDistanceReport($shiftdate,$projectid,$vehicletype)
    {
      $data=[];

      $where = array(
                        'vehicle_distance_master.project_id' => $projectid,
                        'vehicle_distance_master.shift_date' => $shiftdate,
                        'vehicle_distance_master.vehicle_type_id' => $vehicletype
                        
                      
       );

      $query=$this->db->select('
                                vehicle_distance_master.*,
                                vehicle_master.equipment_id,
                                vehicle_master.equipment_name,
                                ')
                        ->from('vehicle_distance_master')
                        ->join('vehicle_distance_details','vehicle_distance_details.distance_master_id=vehicle_distance_master.vehicle_distance_id','INNER')
                         ->join('vehicle_master','vehicle_master.equipment_id=vehicle_distance_details.equipment_id','INNER')
                        ->where($where)
                        ->order_by('vehicle_master.equipment_name', 'asc')
                        ->group_by("vehicle_master.vehicle_id")
                        
                        ->get();
                         #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
               // $data[] = $rows;

                $data[]=[
                  "distanceMasterData"=>$rows,
                  "shiftType"=>$this->getShiftType($shiftdate,$projectid,$vehicletype,$rows->equipment_id)
                ];
            
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }



   public function getShiftType($shiftdate,$projectid,$vehicletype,$equipment_id)
    {
      $data=[];

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

             

                       $data[]=[
                        "shiftData"=>$rows,
                        "distanceDetails"=>$this->getDistanceDetails($shiftdate,$projectid,$vehicletype,$rows->shift_code,$equipment_id)
                      ];

              
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }


    public function getDistanceDetails($shiftdate,$project,$vehicle_type,$shift_code,$equipment_id)
    {
      $data=[];

         $where = array(
                                    'vehicle_distance_master.project_id' =>  $project, 
                                    'vehicle_distance_master.vehicle_type_id' =>  $vehicle_type, 
                                    'vehicle_distance_master.shift_date' =>  $shiftdate, 
                                    'vehicle_distance_master.shift_code' =>  $shift_code, 
                                    'vehicle_distance_details.equipment_id' =>  $equipment_id, 
                                  );

      $query=$this->db->select('
                                vehicle_distance_details.distance_details_id,
                                vehicle_distance_details.start_km,
                                vehicle_distance_details.start_time,
                                vehicle_distance_details.end_km,
                                vehicle_distance_details.end_time,
                                vehicle_distance_details.km_differ,
                                vehicle_distance_details.time_differ
                                ')
                        ->from('vehicle_distance_master')
                        ->where($where)
                        ->join('vehicle_distance_details','vehicle_distance_details.distance_master_id=vehicle_distance_master.vehicle_distance_id','INNER')
                        ->limit(1)
                        ->get();

                        

                      
                       

        if($query->num_rows()> 0)
        {
               $row = $query->row();
               return $data = $row;
                 
            }
        else
        {
                return $data;
            }
    


    }


	
}// end of class
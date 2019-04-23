<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excavatorassignmodel extends CI_Model{

    public function getExcavatorAssign()
    {  
        $where = array('excavator_assign.is_deleted' =>'N' );
        $data = array();
        $query=$this->db->select('excavator_assign.*,
                                  driver_master.driver_name,
                                  driver_master.driver_name,
                                  project_master.project_nickname,
                                  vehicle_master.equipment_name,
                                  vehicle_master.equipment_model,
                                
                        ')
                        ->from('excavator_assign')
                        ->join('driver_master','driver_master.driver_code=excavator_assign.driver_code','INNER')
                        ->join('project_master','project_master.project_id=excavator_assign.project_id','INNER')
                        ->join('vehicle_master','vehicle_master.equipment_id=excavator_assign.equipment_id','INNER')
                        ->where($where)
                        ->order_by('excavator_assign.shift_date','desc')
                        ->order_by('excavator_assign.shift_code')
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



    public function getTripExcavatorList()
    {  
        $today= date('Y-m-d');
        $where = array(
                        'driver_tracking_history.shift_date' =>$today,
                        'excavator_assign.shift_date' =>$today,
                     );
        $data = array();
        $query=$this->db->select('driver_tracking_history.*,
                                  driver_master.driver_name,
                                  project_master.project_nickname,
                                  vehicle_master.equipment_name,
                                  vehicle_master.equipment_model,
                                  excavator_assign.equipment_id
                                
                        ')
                        ->from('driver_tracking_history')
                        ->join('driver_master','driver_tracking_history.driver_empl_code=driver_master.driver_code','INNER')  
                        ->join('excavator_assign','excavator_assign.equipment_id=driver_tracking_history.vehicle_equipment_id','LEFT')
                        ->join('vehicle_master','driver_tracking_history.mobile_id=vehicle_master.mobile_uniq_id','INNER')
                        ->join('project_master','vehicle_master.project_id=project_master.project_id','INNER')
                        ->join('vehicle_master as exca','exca.equipment_id=excavator_assign.equipment_id','LEFT')
                        ->where($where)
                        ->order_by('driver_tracking_history.shift_date')
                        ->order_by('driver_tracking_history.shift_code')
                        ->get();
                       
                       # echo $this->db->last_query();

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


} // end of class

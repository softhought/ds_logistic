<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dumpreportmodel extends CI_Model{
	
	public function getTripReport($fromDt,$toDt,$project,$sel_tipper,$shift)
    {

        $data = array();
        if ($sel_tipper!=0) {
           
            if($shift!='0'){
                $where = array(
                    'vehicle_master.vehicle_id' => $sel_tipper, 
                    'project_master.project_id' => $project,
                    'driver_tracking_history.shift_code' => $shift
                  );
            }
            else{
                $where = array(
                    'vehicle_master.vehicle_id' => $sel_tipper, 
                    'project_master.project_id' => $project
                  );
            }
            
        }else{
            
            if($shift=='0'){
                  $where = array('project_master.project_id' => $project);

               
              }   
           else{

            $where = array(
                                'project_master.project_id' => $project,
                                'driver_tracking_history.shift_code' => $shift
                             );
           }     
                       
        }
       //pre($where);

        $query=$this->db->select('driver_tracking_history.*,
                                    vehicle_master.equipment_name,
                                    exca.equipment_name as excavator,
                                    dumping_yard_master.dumping_yard_name,
                                    material_type.material AS material_type')
                        ->from('driver_tracking_history')
                        ->join('vehicle_master','driver_tracking_history.mobile_id=vehicle_master.mobile_uniq_id','INNER')
                         ->join('project_master','vehicle_master.project_id=project_master.project_id','INNER')
                        ->join('vehicle_master as exca','driver_tracking_history.vehicle_equipment_id = exca.equipment_id','INNER')
                        ->join('dumping_yard_master','dumping_yard_master.dumping_yard_id=driver_tracking_history.dumping_yard_id','LEFT')
                         ->join('project_material_details','project_material_details.project_material_id = driver_tracking_history.project_material_id','left')
                        ->join('material_type','material_type.material_type_id =project_material_details.material_type_id','left')
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") >= ', $fromDt)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") <= ', $toDt)
                        ->where($where)
                        ->order_by("driver_tracking_history.session_satrt_time", "desc")
                        ->limit(15000)
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
	
	
    
	
}
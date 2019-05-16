<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lead_model extends CI_Model{
	
	public function getLeadAgainstVehicleList($today,$project)
    {
        
        if ($project==0) {
          $where = array('lead_against_vehicle.shift_date' =>$today);
        }else{
            $where = array(
                            'lead_against_vehicle.shift_date' =>$today,
                            'lead_against_vehicle.project_id' =>$project
                        ); 
        }
       
        $data = array();
        $query=$this->db->select(
                                'lead_against_vehicle.*,
                                 vehicle_master.equipment_name,
                                 project_master.project_nickname,
                                 material_type.material,
                                 ')
                        ->from('lead_against_vehicle')
                        ->join('vehicle_master','vehicle_master.vehicle_id=lead_against_vehicle.vehicle_mst_id','INNER')
                        ->join('project_master','project_master.project_id=lead_against_vehicle.project_id','INNER')
                        ->join('project_material_details','project_material_details.project_material_id=lead_against_vehicle.project_material_id','INNER')
                        ->join('material_type','material_type.material_type_id=project_material_details.material_type_id','INNER')
                        ->where($where)
                        ->get();
                        #q();
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


    public function getExcavatorListByProjectDateShift($projectId,$shift_code,$shiftdate)
    {
        $data = array();
        $where = array(
                            'vehicle_type.vehicle_type' => "EXCAVATOR",
                            'vehicle_master.is_active' => "Y",
                            'vehicle_master.project_id' => $projectId
                           
                      );
       
        $query=$this->db->select('*')
                        ->from('vehicle_master')
                        ->join('vehicle_type','vehicle_type.vehicle_type_id=vehicle_master.vehicle_type_id','INNER')
                        ->join('lead_against_vehicle',"lead_against_vehicle.vehicle_mst_id =vehicle_master.vehicle_id and 
                                lead_against_vehicle.shift_code ='".$shift_code."' and 
                                lead_against_vehicle.shift_date ='".$shiftdate."' ",'LEFT')
                        ->where($where)
                        ->where('lead_against_vehicle.vehicle_mst_id IS NULL')
                        ->get();
                        #q();
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
	
	
   


    public function getMaterialByProject($projectid)
    {
        

        $where = array('project_material_details.project_id' =>$projectid);
        $data = array();
        $query=$this->db->select('
                                    project_material_details.*,
                                    material_type.material_type_id,
                                    material_type.material
                                    ')
                        ->from('project_material_details')
                        ->join('material_type','material_type.material_type_id=project_material_details.material_type_id','INNER')
                        ->where($where)
                        ->get();
                        #q();
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
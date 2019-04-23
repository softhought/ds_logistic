<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Import_model extends CI_Model{
	
	public function getHistoryByProject($projectid)
    {
        $data = array();
        $where = array('vehicle_master.project_id' =>$projectid);
        $query=$this->db->select('
                                driver_tracking_history.track_history_id,
                                driver_tracking_history.material_type,
                                driver_tracking_history.project_material_id,
                                vehicle_master.project_id
                                ')
                        ->from('driver_tracking_history')
                        ->join('vehicle_master','vehicle_master.equipment_id=driver_tracking_history.vehicle_equipment_id','INNER')
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


    public function getProjectMaterialId($projectid,$material)
    {
        $data = array();
        $where = array(
                        'project_material_details.project_id' =>$projectid,
                        'material_type.material' =>$material
                         );
        $this->db->select("*")
                ->from('project_material_details')
                ->join('material_type','material_type.material_type_id=project_material_details.material_type_id','INNER')
                ->where($where)
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
	
	
    
	
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Material_model extends CI_Model{
	
	public function getMaterialAgainstProjectList()
    {
        

        $data = array();
        $query=$this->db->select('project_material_details.*,
                                project_master.project_nickname,
                                material_type.material
                                ')
                        ->from('project_material_details')
                        ->join('project_master','project_master.project_id=project_material_details.project_id','INNER')
                        ->join('material_type','material_type.material_type_id=project_material_details.material_type_id','INNER')
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
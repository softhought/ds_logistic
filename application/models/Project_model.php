<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model{
	
	public function getProjectList()
    {
        $data = array();
        $query=$this->db->select('*')
                        ->from('project_master')
                        ->join('location_master','location_master.location_id=project_master.location_id','INNER')
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
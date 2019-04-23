<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dumpingyard_model extends CI_Model{
	
	public function getDumpingyardList()
    {
        $data = array();
        $query=$this->db->select('dumping_yard_master.*,project_master.project_nickname')
                        ->from('dumping_yard_master')
                        ->join('project_master','project_master.project_id=dumping_yard_master.project_id','INNER')
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
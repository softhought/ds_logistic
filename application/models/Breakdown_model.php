<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Breakdown_model extends CI_Model{
	
	public function getBreakdownList($today)
    {
        $data = array();
        $where = array(
                        
                        'breakdown.is_approved' => 'N' 
                    );
        $query=$this->db->select('
                                    breakdown.*,
                                    vehicle_master.equipment_name,
                                    driver_master.driver_name,
                                    mobile_master.mobile_no,
                                    mobile_master.mobile_uuid
                                    ')
                        ->from('breakdown')
                        ->join('vehicle_master','vehicle_master.equipment_id=breakdown.vehicle_eqp_id','INNER')
                        ->join('driver_master','driver_master.driver_code=breakdown.driver_code','INNER')
                        ->join('mobile_master','mobile_master.mobile_id=breakdown.mobile_id','INNER')
                        ->where('DATE_FORMAT(breakdown.breakdown_date,"%Y-%m-%d") = ', $today)
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
	
	public function getBreakdownDataById($breakdownid)
    {
        $data = array();
        $where = array('breakdown.breakdown_id' => $breakdownid);
        $this->db->select("
                            breakdown.*,
                             vehicle_master.equipment_name,")
                ->from('breakdown')
                ->join('vehicle_master','vehicle_master.equipment_id=breakdown.vehicle_eqp_id','INNER')
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



    public function getBreakdownListHistory($today)
    {
        $data = array();
        $where = array(
                        
                        'breakdown.is_approved' => 'Y' 
                    );
        $query=$this->db->select('
                                    breakdown.*,
                                    vehicle_master.equipment_name,
                                    driver_master.driver_name,
                                    mobile_master.mobile_no,
                                    mobile_master.mobile_uuid,
                                    breakdown_cause_master.cause
                                    ')
                        ->from('breakdown')
                        ->join('vehicle_master','vehicle_master.equipment_id=breakdown.vehicle_eqp_id','INNER')
                        ->join('driver_master','driver_master.driver_code=breakdown.driver_code','INNER')
                        ->join('mobile_master','mobile_master.mobile_id=breakdown.mobile_id','INNER')
                        ->join('breakdown_cause_master','breakdown_cause_master.id=breakdown.breakdown_cause_id','left')
                        ->where('DATE_FORMAT(breakdown.breakdown_date,"%Y-%m-%d") = ', $today)
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
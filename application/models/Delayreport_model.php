<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Delayreport_model extends CI_Model{

  public function getTipperDelay($shift_date,$project)
    {
        $data = array();
        $where = array(
                                'vehicle_master.project_id' => $project, 
                                'driver_tracking_history.shift_date' => $shift_date,
                               
                                                 
                                ); 
        $query=$this->db->select('
        							vehicle_master.equipment_name,
									vehicle_master.equipment_id,
									project_master.project_nickname
                                ')
                        ->from('driver_tracking_history')
                        ->where($where)
                        ->join('vehicle_master','vehicle_master.equipment_id=driver_tracking_history.tipper_equipment_id','INNER')
                        ->join('project_master','project_master.project_id=vehicle_master.project_id','INNER')
                        ->order_by('vehicle_master.vehicle_id', 'asc')
                        ->group_by('vehicle_master.equipment_name')
                        ->get();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
               // $data[] = $rows;

                 $data[]=[
                  "tipperData"=>$rows,
                  "startIdelTime"=>$this->getTipperFirstTripStart($shift_date,$project,$rows->equipment_id),
                  "endIdelTime"=>$this->getTipperLastTripEnd($shift_date,$project,$rows->equipment_id)
                 
                  
                ];
            }
            return $data;
        }else{
            return $data;
         }
    }



    public function getTipperFirstTripStart($shift_date,$project,$equipment_id)
	{
			$where = array(
                            'vehicle_master.project_id' => $project, 
                            'driver_tracking_history.shift_date' => $shift_date,
                            'driver_tracking_history.tipper_equipment_id' => $equipment_id
                               
                                                 
                                ); 
		$data = array();
		$this->db->select(" driver_tracking_history.shift_date,
							driver_tracking_history.session_satrt_time,
							driver_tracking_history.login_time,
							driver_tracking_history.shift_code,
							shift_master.start_time
							")
				->from('driver_tracking_history')
				->join('vehicle_master','vehicle_master.equipment_id=driver_tracking_history.tipper_equipment_id','INNER')
                ->join('project_master','project_master.project_id=vehicle_master.project_id','INNER')
                ->join('shift_master','shift_master.shift_code=driver_tracking_history.shift_code','INNER')
				->where($where)
				->order_by('driver_tracking_history.track_history_id', 'asc')
				->limit(1);
		$query = $this->db->get();
		
		#echo $this->db->last_query();
		
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

	public function getTipperLastTripEnd($shift_date,$project,$equipment_id)
	{
			$where = array(
                            'vehicle_master.project_id' => $project, 
                            'driver_tracking_history.shift_date' => $shift_date,
                            'driver_tracking_history.tipper_equipment_id' => $equipment_id
                               
                                                 
                                ); 
		$data = array();
		$this->db->select(" driver_tracking_history.shift_date,
							driver_tracking_history.session_end_time,
							driver_tracking_history.login_time,
							driver_tracking_history.shift_code,
							shift_master.end_time
							")
				->from('driver_tracking_history')
				->join('vehicle_master','vehicle_master.equipment_id=driver_tracking_history.tipper_equipment_id','INNER')
                ->join('project_master','project_master.project_id=vehicle_master.project_id','INNER')
                ->join('shift_master','shift_master.shift_code=driver_tracking_history.shift_code','INNER')
				->where($where)
				->order_by('driver_tracking_history.track_history_id', 'desc')
				->limit(1);
		$query = $this->db->get();
		
		#echo $this->db->last_query();
		
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




	public function getExcavatorDelay($shift_date,$project)
    {
        $data = array();
        $where = array(
                                'vehicle_master.project_id' => $project, 
                                'driver_tracking_history.shift_date' => $shift_date,
                               
                                                 
                                ); 
        $query=$this->db->select('
        							vehicle_master.equipment_name,
									vehicle_master.equipment_id,
									project_master.project_nickname
                                ')
                        ->from('driver_tracking_history')
                        ->where($where)
                        ->join('vehicle_master','vehicle_master.equipment_id=driver_tracking_history.vehicle_equipment_id','INNER')
                        ->join('project_master','project_master.project_id=vehicle_master.project_id','INNER')
                        ->order_by('vehicle_master.vehicle_id', 'asc')
                        ->group_by('vehicle_master.equipment_name')
                        ->get();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
               // $data[] = $rows;

                 $data[]=[
                  "excavatorData"=>$rows,
                  "startIdelTime"=>$this->getExcavatorFirstTripStart($shift_date,$project,$rows->equipment_id),
                  "endIdelTime"=>$this->getExcavatorLastTripEnd($shift_date,$project,$rows->equipment_id)
                 
                  
                ];
            }
            return $data;
        }else{
            return $data;
         }
    }


     public function getExcavatorFirstTripStart($shift_date,$project,$equipment_id)
	{
			$where = array(
                            'vehicle_master.project_id' => $project, 
                            'driver_tracking_history.shift_date' => $shift_date,
                            'driver_tracking_history.vehicle_equipment_id' => $equipment_id
                               
                                                 
                                ); 
		$data = array();
		$this->db->select(" driver_tracking_history.shift_date,
							driver_tracking_history.session_satrt_time,
							driver_tracking_history.login_time,
							driver_tracking_history.shift_code,
							shift_master.start_time
							")
				->from('driver_tracking_history')
				->join('vehicle_master','vehicle_master.equipment_id=driver_tracking_history.vehicle_equipment_id','INNER')
                ->join('project_master','project_master.project_id=vehicle_master.project_id','INNER')
                ->join('shift_master','shift_master.shift_code=driver_tracking_history.shift_code','INNER')
				->where($where)
				->order_by('driver_tracking_history.track_history_id', 'asc')
				->limit(1);
		$query = $this->db->get();
		
		#echo $this->db->last_query();
		
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



		public function getExcavatorLastTripEnd($shift_date,$project,$equipment_id)
	{
			$where = array(
                            'vehicle_master.project_id' => $project, 
                            'driver_tracking_history.shift_date' => $shift_date,
                            'driver_tracking_history.vehicle_equipment_id' => $equipment_id
                               
                                                 
                                ); 
		$data = array();
		$this->db->select(" driver_tracking_history.shift_date,
							driver_tracking_history.session_end_time,
							driver_tracking_history.login_time,
							driver_tracking_history.shift_code,
							shift_master.end_time
							")
				->from('driver_tracking_history')
				->join('vehicle_master','vehicle_master.equipment_id=driver_tracking_history.vehicle_equipment_id','INNER')
                ->join('project_master','project_master.project_id=vehicle_master.project_id','INNER')
                ->join('shift_master','shift_master.shift_code=driver_tracking_history.shift_code','INNER')
				->where($where)
				->order_by('driver_tracking_history.track_history_id', 'desc')
				->limit(1);
		$query = $this->db->get();
		
		#echo $this->db->last_query();
		
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
	
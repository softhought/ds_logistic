<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle_model extends CI_Model{
	
	
	
	
	public function getVehicleList()
    {
        $data = array();
        $query=$this->db->select('*,vehicle_master.is_active as vehicle_active_status')
                        ->from('vehicle_master')
                        ->join('vehicle_type','vehicle_master.vehicle_type_id=vehicle_type.vehicle_type_id','INNER')
                        ->join('mobile_master','vehicle_master.mobile_uniq_id=mobile_master.mobile_id','LEFT')
                        ->join('project_master','project_master.`project_id` = vehicle_master.`project_id`','LEFT')
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


	public function insertIntoVehicle($data,$session) {
		try {
            $this->db->trans_begin();
			
			$vehicle_data = [];
			$vehicle_data = [
				"equipment_id" => trim(htmlspecialchars($data['equipmentid'])),
				"equipment_name" => trim(htmlspecialchars($data['eqpname'])),
				"equipment_model" => trim(htmlspecialchars($data['eqpmodel'])),
				"vehicle_type_id" => trim(htmlspecialchars($data['vehicleType'])),
				"project_id" => trim(htmlspecialchars($data['project'])),
				"capacity" => trim(htmlspecialchars($data['capacity'])),
				"is_active" => 'Y',
				"is_new" => 'Y'
			];
			
			$this->db->insert('vehicle_master', $vehicle_data);
			if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
	}



	public function updateVehicle($data,$session){
		try {
            $this->db->trans_begin();
			
			$vehicle_data = [];
		
			$vehicleID = trim(htmlspecialchars($data['vehicleID']));
			$vehicle_data = [
				"equipment_id" => trim(htmlspecialchars($data['equipmentid'])),
				"equipment_name" => trim(htmlspecialchars($data['eqpname'])),
				"equipment_model" => trim(htmlspecialchars($data['eqpmodel'])),
				"vehicle_type_id" => trim(htmlspecialchars($data['vehicleType'])),
				"project_id" => trim(htmlspecialchars($data['project'])),
				"capacity" => trim(htmlspecialchars($data['capacity'])),
				"is_new" => 'Y'
			];
                        
                 
			$this->db->where('vehicle_master.vehicle_id', $vehicleID);
			$this->db->update('vehicle_master', $vehicle_data); 
			
			if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
	}

	
	public function updateLocalTransHistory($request) {
		date_default_timezone_set('Asia/Kolkata');
		
		$mobileID = $request->mobileid;
		$DriverCode = $request->drivercode;
		
		$localdatasize = count($request->data);
		$localDataArray = $request->data;
		
		$update_array = [];
		$insert_array = [];
		
		for($i=0;$i<$localdatasize;$i++) {
			
			
			$isPreviousData = $this->checkIsDataExist($mobileID,$DriverCode,$localDataArray[$i]->track_history_id);
			if($isPreviousData) {
				//Update Existing Data
				
				$upd_where = [
					"driver_tracking_history.local_autoinc_id" => $localDataArray[$i]->track_history_id,
					"driver_tracking_history.mobile_id" => $mobileID,
					"driver_tracking_history.driver_empl_code" => $DriverCode
				];
				
				$logout_time = NULL;
				if(isset($localDataArray[$i]->logout_time)) {
					$logout_time = date("Y-m-d H:i:s a",strtotime($localDataArray[$i]->logout_time));
				}
				
				$trip_end_time = NULL;
				if(isset($localDataArray[$i]->session_end_time)) {
					$trip_end_time = date("Y-m-d H:i:s a",strtotime($localDataArray[$i]->session_end_time));
				}
				
				
				$update_array = [
					"logout_time" => $logout_time,	
					"session_end_time" => $trip_end_time	
				];
				$this->db->where($upd_where);
				$this->db->update('driver_tracking_history', $update_array);
				
			}
			else{
				
				$logout_time = NULL;
				if(isset($localDataArray[$i]->logout_time)) {
					$logout_time = date("Y-m-d H:i:s a",strtotime($localDataArray[$i]->logout_time));
				}
				
				
				$trip_end_time = NULL;
				if(isset($localDataArray[$i]->session_end_time)) {
					$trip_end_time = date("Y-m-d H:i:s a",strtotime($localDataArray[$i]->session_end_time));
				}
				
				// Insert 
				$insert_array = [
					"driver_empl_code" => $localDataArray[$i]->driver_empl_code,
					"shift_code" => $localDataArray[$i]->shift_code,
					"session_satrt_time" => date("Y-m-d H:i:s a",strtotime($localDataArray[$i]->session_satrt_time)),
					"logout_time" => $logout_time,		
					"capture_on" => date("Y-m-d H:i:s"),
					"is_sync" => 'Y',
					"material_type" => $localDataArray[$i]->material_type, 
					"mobile_id" => $mobileID,
					"local_autoinc_id" => $localDataArray[$i]->track_history_id,
					"session_end_time" => $trip_end_time,
					"vehicle_equipment_id" => $localDataArray[$i]->vehicle_equipment_id
				];
				
				$this->db->insert('driver_tracking_history', $insert_array);
				$inserted_id = $this->db->insert_id();
			}
		}
		
		if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
			return false;
        }
		else {
			$this->db->trans_commit();
               return true;
           }

	}
	
	public function checkIsDataExist($mobileID,$drivercode,$localAutoID){
		$isAlredyExist = false;
		$where = [
			"driver_tracking_history.local_autoinc_id" => $localAutoID,
			"driver_tracking_history.mobile_id" => $mobileID,
			"driver_tracking_history.driver_empl_code" => $drivercode
		];

		$query = $this->db
						 ->select("*")
                         ->from("driver_tracking_history") 
						 ->where($where)
						 ->get();
						
		if($query->num_rows()>0)
		{
			$isAlredyExist = true;
        }
        return $isAlredyExist;
	}
    
    
	
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Driver_model extends CI_Model{
	
	
	
	
	/*
    public function updateLocalTransHistory($table,$data,$where){
		try {
            $this->db->trans_begin();
			$this->db->update($table, $data,$where);
			if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            }
			else {
                $this->db->trans_commit();
                return TRUE;
            }
        } catch (Exception $exc) {
             return FALSE;
        }
    }
	*/


	public function insertIntoDriver($data,$session){
		try {
            $this->db->trans_begin();
			
			$driver_data = [];
			$driver_data = [
				"driver_code" => trim(htmlspecialchars($data['drivercode'])),
				"driver_name" => trim(htmlspecialchars($data['drivername'])),
				"working_project_id" => trim(htmlspecialchars($data['workingproject'])),
				"driver_password" => trim(htmlspecialchars($data['driverpassword'])),
				"vehicle_type_id" => trim(htmlspecialchars($data['vehicleType'])),
				"is_active" => 'Y',
				"is_new" => 'Y'
			];
			
			$this->db->insert('driver_master', $driver_data);
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



	public function updateDriver($data,$session){
		try {
            $this->db->trans_begin();
			
			$driver_data = [];
		
			
			/*$user_data = [
				"mobile_no" => trim(htmlspecialchars($data['mobile'])),
				"password" => trim(htmlspecialchars($data['ltpass']))
			];
			
			$userid = trim(htmlspecialchars($data['uid']));
			
			
			$this->db->where('user_master.id', $userid);
			$this->db->update('user_master', $user_data);*/

			$driverID = trim(htmlspecialchars($data['driverID']));
			
			
			$driver_data = [
				"driver_code" => trim(htmlspecialchars($data['drivercode'])),
				"driver_name" => trim(htmlspecialchars($data['drivername'])),
				"working_project_id" => trim(htmlspecialchars($data['workingproject'])),
				"driver_password" => trim(htmlspecialchars($data['driverpassword'])),
				"vehicle_type_id" => trim(htmlspecialchars($data['vehicleType'])),
				"is_new" => 'Y'
			];
                        
                 
			$this->db->where('driver_master.driver_id', $driverID);
			$this->db->update('driver_master', $driver_data); 
			
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
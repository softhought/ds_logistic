<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logistic_model extends CI_Model{
	
	public function __construct() {
        parent::__construct();
        $this->load->model("Shift_model", "shiftmodel", TRUE);
    }
	
	
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
	
	public function updateLocalTransHistory($request) {
		date_default_timezone_set('Asia/Kolkata');
		
		$mobileID = $request->mobileid;

		
		$localdatasize = count($request->data);
		$localDataArray = $request->data;
	
		
		$update_array = [];
		$insert_array = [];

		// foreach ($request->data as $value) {
		// 	 $DriverCode=$value->driver_empl_code;
		// }

		
		
		for($i=0;$i<$localdatasize;$i++) {
			
			
			$isPreviousData = $this->checkIsDataExist($mobileID,$localDataArray[$i]->driver_empl_code,$localDataArray[$i]->track_history_id);
			if($isPreviousData) {
				//Update Existing Data
				
				$upd_where = [
					"driver_tracking_history.local_autoinc_id" => $localDataArray[$i]->track_history_id,
					"driver_tracking_history.mobile_id" => $mobileID,
					"driver_tracking_history.driver_empl_code" => $localDataArray[$i]->driver_empl_code
				];
				
				$logout_time = NULL;
				if(isset($localDataArray[$i]->logout_time)) {
					$logout_time = date("Y-m-d H:i:s",strtotime($localDataArray[$i]->logout_time));
				}
				
				$trip_end_time = NULL;
				if(isset($localDataArray[$i]->session_end_time)) {
					$trip_end_time = date("Y-m-d H:i:s",strtotime($localDataArray[$i]->session_end_time));
				}
				
				
				$update_array = [
					"logout_time" => $logout_time,	
					"session_end_time" => $trip_end_time,
					"dumping_yard_id" => $localDataArray[$i]->dumping_yard_id	
				];
				$this->db->where($upd_where);
				$this->db->update('driver_tracking_history', $update_array);
				
			}
			else{
				
				$logout_time = NULL;
				if(isset($localDataArray[$i]->logout_time)) {
					$logout_time = date("Y-m-d H:i:s",strtotime($localDataArray[$i]->logout_time));
				}
				
				
				$trip_end_time = NULL;
				if(isset($localDataArray[$i]->session_end_time)) {
					$trip_end_time = date("Y-m-d H:i:s",strtotime($localDataArray[$i]->session_end_time));
				}
				
				// Get shift date added on 11.03.2019

				$shift_date = $this->shiftmodel->getSiftDate($localDataArray[$i]->session_satrt_time);


				// Insert 
				$insert_array = [
					"driver_empl_code" => $localDataArray[$i]->driver_empl_code,
					"shift_code" => $localDataArray[$i]->shift_code,
					"session_satrt_time" => date("Y-m-d H:i:s",strtotime($localDataArray[$i]->session_satrt_time)),
					"logout_time" => $logout_time,		
					"capture_on" => date("Y-m-d H:i:s"),
					"is_sync" => 'Y',
					"material_type" => $localDataArray[$i]->material_type, 
					"mobile_id" => $mobileID,
					"local_autoinc_id" => $localDataArray[$i]->track_history_id,
					"session_end_time" => $trip_end_time,
					"vehicle_equipment_id" => $localDataArray[$i]->vehicle_equipment_id,
					"shift_date" => $shift_date, // added on 11.03.2019
					"dumping_yard_id" => $localDataArray[$i]->dumping_yard_id // added on 30.03.2019
				];
				
				$this->db->insert('driver_tracking_history', $insert_array);
				$inserted_id = $this->db->insert_id();

			}
			#echo $this->db->last_query();
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
	
	
	public function updateBreakDownData($request) {
		date_default_timezone_set('Asia/Kolkata');
		
		
		
		$insert_array = [];
		
		$updMobile = [];
		$whereMbl = [];
		
		$updVehicle = [];
		$whrVehicle = [];
		
		if(isset($request->data)) {
			$breakDownDataArray = $request->data;
			$breakDownCount = count($request->data);
		for($i=0;$i<$breakDownCount;$i++) {
				
				// Update Mobile
				$updMobile = [
					"mobile_master.is_active" => "N"
				];
				$whereMbl = [
					"mobile_master.mobile_id" => $breakDownDataArray[$i]->mobile_id
				];
				$this->db->where($whereMbl);
				$this->db->update('mobile_master', $updMobile);
				
				
				
				// Update Vehicle Master
				$updVehicle = [
					"vehicle_master.is_active" => "N"
				];
				
				$whrVehicle = [
					"vehicle_master.equipment_id" => $breakDownDataArray[$i]->vehicle_eqp_id,
					"vehicle_master.mobile_uniq_id" => $breakDownDataArray[$i]->mobile_id
				];
				$this->db->where($whrVehicle);
				$this->db->update('vehicle_master', $updVehicle);
				
				//echo $this->db->last_query();
				
				// Insert Into Break down Table for future use
				$insert_array = [
					"vehicle_eqp_id" => $breakDownDataArray[$i]->vehicle_eqp_id,
					"mobile_id" => $breakDownDataArray[$i]->mobile_id,
					"driver_code" => $breakDownDataArray[$i]->driver_code,		
					"breakdown_date" => date("Y-m-d H:i:s",strtotime($breakDownDataArray[$i]->breakdown_date)),
					"is_sync" => 'Y'
				];
				
				$this->db->insert('breakdown', $insert_array);
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
    
	
	

	// insert / update excavator assign master data

		public function updateLocalTransExcavatorAssign($request) {
		date_default_timezone_set('Asia/Kolkata');
		
	    $mobileID = $request->mobileid;
		

	
		
		$localdatasize = count($request->data);
		$localDataArray = $request->data;
		
		$update_array = [];
		$insert_array = [];
		//echo "Dt".$request->data[0]->shift_date;

		 
		// pre($request->data);exit;
		
		for($i=0;$i<$localdatasize;$i++) {
			
			
			$isPreviousData = $this->checkIsDataExistExcavatorAssign($mobileID,$localDataArray[$i]->supervisor_id,$localDataArray[$i]->excavator_assign_id);
			if($isPreviousData) {
				//Update Existing Data
				//echo "<br>Update<br>";
				$upd_where = [
					"excavator_assign.local_autoinc_id" => $localDataArray[$i]->excavator_assign_id,
					"excavator_assign.mobile_id" => $mobileID,
					"excavator_assign.supervisor_id" => $localDataArray[$i]->supervisor_id
				];
				
				
				
				$update_array = [
					"is_deleted" => $localDataArray[$i]->is_deleted,
				];
				$this->db->where($upd_where);
				$this->db->update('excavator_assign', $update_array);
				
			}
			else{
				
	
		//	echo "<br>Insert<br>";
				// $shift_date = NULL;
				// if(isset($localDataArray[$i]->shift_date)){
				// 	$shift_date = str_replace('/', '-', $localDataArray[$i]->shift_date);
				 //$shift_date = date("Y-m-d",strtotime(shift_date));
				//  }
				//  else{
				// 	$shift_date = NULL;
				//  }
				
				 $shift_date = date("Y-m-d",strtotime($localDataArray[$i]->shift_date));
			

				// Insert 
				$insert_array = [
					"shift_date" => $shift_date, 
					"shift_code" => $localDataArray[$i]->shift_code,
					"equipment_id" => $localDataArray[$i]->equipment_id,
					"driver_code" => $localDataArray[$i]->driver_code,
					"project_id" => $localDataArray[$i]->project_id,
					"supervisor_id" => $localDataArray[$i]->supervisor_id,
					"is_sync" => 'Y',
					"mobile_id" => $mobileID,
					"local_autoinc_id" => $localDataArray[$i]->excavator_assign_id,
					"is_deleted" => $localDataArray[$i]->is_deleted,
				
					
				];
				//print_r($insert_array);
				$this->db->insert('excavator_assign', $insert_array);
				$inserted_id = $this->db->insert_id();

			}
			#echo $this->db->last_query();
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


	public function checkIsDataExistExcavatorAssign($mobileID,$supervisorID,$localAutoID){
		$isAlredyExist = false;
		$where = [
			"excavator_assign.local_autoinc_id" => $localAutoID,
			"excavator_assign.mobile_id" => $mobileID,
			"excavator_assign.supervisor_id" => $supervisorID
		];

		$query = $this->db
						 ->select("*")
                         ->from("excavator_assign") 
						 ->where($where)
						 ->get();

			#echo $this->db->last_query();

		if($query->num_rows()>0)
		{
			$isAlredyExist = true;
        }
        return $isAlredyExist;
	}
	
}// end of class
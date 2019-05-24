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
					"dumping_yard_id" => $localDataArray[$i]->dumping_yard_id,
					"last_modified" => date("Y-m-d H:i:s")	
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
					"dumping_yard_id" => $localDataArray[$i]->dumping_yard_id, // added on 30.03.2019
					"project_material_id" => $localDataArray[$i]->project_material_id,
					"tipper_equipment_id" => $localDataArray[$i]->tipper_equipment_id,
					"login_time" => $localDataArray[$i]->login_time,
					"last_modified" => date("Y-m-d H:i:s")
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
						
						/* 
						Commented on 17.04.2019 
						
						
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
						
						*/
						
						
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
	
	
	
	
	/*
	 *  By Mithilesh
	 *  On 11.04.2019
	 *
	 */
	 
	public function updateVehicalDistanceLocalTransHistory($request) {
		
		date_default_timezone_set('Asia/Kolkata');
		$mobileID = $request->mobileid;

		
		$localdatasize = count($request->data);
		$localDataArray = $request->data;
		
		
		$update_array = [];
		$insert_array = [];
		
		
		
		
		for($i=0; $i<$localdatasize; $i++){
			
			$vehicledistance_travel_data = $localDataArray[$i]->datas;
			
	
			$isPreviousData = $this->checkIsVehicalDistanceDataExist(
										$mobileID,
										$vehicledistance_travel_data->vehicle_equipment_id,
										$vehicledistance_travel_data->super_admin_id,
										$vehicledistance_travel_data->vehicle_distance_history_id
										);
			
				if($isPreviousData) {
					
					 $where_upd =    
					[
						"vehicle_distance_history.local_autoinc_id" => $vehicledistance_travel_data->vehicle_distance_history_id,
						"vehicle_distance_history.mobile_id" => $mobileID,
						"vehicle_distance_history.vehicle_equipment_id" => $vehicledistance_travel_data->vehicle_equipment_id,
						"vehicle_distance_history.super_admin_id" => $vehicledistance_travel_data->super_admin_id
					];	
					
					$update_array = [
						"vehicle_distance_history.end_distance_value" => $vehicledistance_travel_data->end_distance_value,
						"vehicle_distance_history.is_deleted" => $vehicledistance_travel_data->is_deleted
						];
					
					$this->db->where($where_upd);
					$this->db->update('vehicle_distance_history', $update_array); 
					
				}
				else{
					
					$insert_array = 
					[
						"shift_date" => date("Y-m-d",strtotime($vehicledistance_travel_data->shift_date)),
						"entry_date" => date("Y-m-d",strtotime($vehicledistance_travel_data->entry_date)),
						"shift_code" => $vehicledistance_travel_data->shift_code,
						"vehicle_type_id" => $vehicledistance_travel_data->vehicle_type_id,
						"vehicle_equipment_id" => $vehicledistance_travel_data->vehicle_equipment_id,
						"start_distance_value" => $vehicledistance_travel_data->start_distance_value,
						"end_distance_value" => $vehicledistance_travel_data->end_distance_value,
						"project_id" => $vehicledistance_travel_data->project_id,
						"super_admin_id" => $vehicledistance_travel_data->super_admin_id,
						"is_sync" => $vehicledistance_travel_data->is_sync,
						"mobile_id" => $vehicledistance_travel_data->mobile_id,
						"local_autoinc_id" => $vehicledistance_travel_data->vehicle_distance_history_id,
						"is_deleted" => $vehicledistance_travel_data->is_deleted
					];
					
					$this->db->insert('vehicle_distance_history', $insert_array);
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
	
	
	
	// Check is vehicle distance history exist
	public function checkIsVehicalDistanceDataExist($mobileID,$vehicla_eqp_id,$super_admin_id,$localAutoID){
		$isAlredyExist = false;
		$where = [
			"vehicle_distance_history.local_autoinc_id" => $localAutoID,
			"vehicle_distance_history.mobile_id" => $mobileID,
			"vehicle_distance_history.vehicle_equipment_id" => $vehicla_eqp_id,
			"vehicle_distance_history.super_admin_id" => $super_admin_id
		];

		$query = $this->db
						 ->select("*")
                         ->from("vehicle_distance_history") 
						 ->where($where)
						 ->get();
						
		if($query->num_rows()>0)
		{
			$isAlredyExist = true;
        }
        return $isAlredyExist;
	}
	
	
	/*
	 * @desc update and insert loginlogout history data
	 * @date 16.05.2019
	 * @By Mithilesh
	 */
	public function updateLocalLoginLogoutTransHistory($request) {
		date_default_timezone_set('Asia/Kolkata');
		
	
		$mobileID = $request->mobileid;
		$localdatasize = count($request->data);
		$localDataArray = $request->data;
	
		
		$update_array = [];
		$insert_array = [];

		
		
		
		for($i=0;$i<$localdatasize;$i++) {
			
			
			$isPreviousData = $this->checkIsDataExist($localDataArray[$i]->mobile_id,$localDataArray[$i]->driver_code,$localDataArray[$i]->login_logout_history_id);
			
			if($isPreviousData){
				//Update Existing Data
				
				$upd_where = [
					"login_logout_history.local_auto_inc_id" => $localDataArray[$i]->login_logout_history_id,
					"login_logout_history.mobile_id" => $localDataArray[$i]->mobile_id,
					"login_logout_history.driver_code" => $localDataArray[$i]->driver_code
				];
				
				$logout_time = NULL;
				if(isset($localDataArray[$i]->logout_time)) {
					$logout_time = date("Y-m-d H:i:s",strtotime($localDataArray[$i]->logout_time));
				}
				
				$update_array = [
					"logout_time" => $logout_time
				];
				
				$this->db->where($upd_where);
				$this->db->update('login_logout_history', $update_array);
				
			}
			else{
				
				$logout_time = NULL;
				
				if(isset($localDataArray[$i]->logout_time)) {
					$logout_time = date("Y-m-d H:i:s",strtotime($localDataArray[$i]->logout_time));
				}
				
				// Insert 
				$insert_array = [
					"vehicle_equipment_id" => $localDataArray[$i]->vehicle_equipment_id,
					"driver_code" => $localDataArray[$i]->driver_code,
					"login_time" => date("Y-m-d H:i:s",strtotime($localDataArray[$i]->login_time)),
					"logout_time" => $logout_time,		
					"sync_date" => date("Y-m-d H:i:s"),
					"is_sync" => 'Y',
					"login_by" => $localDataArray[$i]->login_by, 
					"mobile_id" => $localDataArray[$i]->mobile_id, 
					"local_auto_inc_id" => $localDataArray[$i]->login_logout_history_id
				];
				
				$this->db->insert('login_logout_history', $insert_array);
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
	
	
	
	
	
	
	
	
	
	
	
	
}// end of class
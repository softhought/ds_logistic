<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicle extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
        $this->load->model('Vehicle_model','vehicle',TRUE);
    }

	
	public function index(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/vehicle/vehicle_list';
            $result['vehicleList']=$this->vehicle->getVehicleList();
           // pre($result['driverList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }
    
    

    public function addVehicle(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
			if($this->uri->rsegment(3) == NULL)
			{
				$result['mode'] = "ADD";
				$result['btnText'] = "Save";
				$result['btnTextLoader'] = "Saving...";
                $vehicleID = 0;
                $result['vehicleID'] = $vehicleID;
				$result['vehicleEditdata'] = [];
				
				
				
				//getAllRecordWhereOrderBy($table,$where,$orderby)
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
                $vehicleID = $this->uri->segment(3);
                $result['vehicleID'] = $vehicleID;
				
                
				$whereAry = [
                    'vehicle_master.vehicle_id' => $vehicleID
                ];
				
				$result['vehicleEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('vehicle_master',$whereAry); 
			}

            $result['vehicleTypeList'] = $this->commondatamodel->getAllDropdownData("vehicle_type");
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");

			$header = "";
			$page = 'dashboard/admin_dashboard/master/vehicle/add_vehicle';
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
        }
        

    }


    public function vehicle_action() {

        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			

			
		
			$vehicleID = trim(htmlspecialchars($dataArry['vehicleID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));

            $equipmentid = trim(htmlspecialchars($dataArry['equipmentid']));
			$eqpname = trim(htmlspecialchars($dataArry['eqpname']));
			$eqpmodel = trim(htmlspecialchars($dataArry['eqpmodel']));
			$vehicleType = trim(htmlspecialchars($dataArry['vehicleType']));
			$project = trim(htmlspecialchars($dataArry['project']));
			$capacity = trim(htmlspecialchars($dataArry['capacity']));
			
			
			


			if($equipmentid!="" && $eqpname!="" && $eqpmodel!="")
			{
	
				
				
				if($vehicleID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					

					$update = $this->vehicle->updateVehicle($dataArry,$session);
					
					
					if($update)
					{
						$json_response = array(
							"msg_status" => 1,
							"msg_data" => "Updated successfully",
							"mode" => "EDIT"
						);
					}
					else
					{
						$json_response = array(
							"msg_status" => 0,
							"msg_data" => "There is some problem while updating ...Please try again."
						);
					}



				} // end if mode
				else
				{
					/*  ADD MODE
					 *	-----------------
					*/

			
					$insertData = $this->vehicle->insertIntoVehicle($dataArry,$session);
					

					if($insertData)
					{
						$json_response = array(
							"msg_status" => 1,
							"msg_data" => "Saved successfully",
							"mode" => "ADD"
						);
					}
					else
					{
						$json_response = array(
							"msg_status" => 1,
							"msg_data" => "There is some problem.Try again"
						);
					}

				} // end add mode ELSE PART




				

			}
			else
			{
				$json_response = array(
						"msg_status" =>0,
						"msg_data" => "All fields are required"
					);
			}

			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;

			

		}
		else
		{
			redirect('adminpanel','refresh');
		}
    }



  
    public function checkVehicleEqpID() {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {

           $json_response = [];
           $eqpid = $this->input->post("eqpid");
           $where = [
               "vehicle_master.equipment_id" => trim($eqpid)
           ];
           $isExist = $this->commondatamodel->duplicateValueCheck("vehicle_master",$where);
           if($isExist) {
                $json_response = [
                    "msg_status" => 1,
                    "msg_data" => "This Equipment ID already exist.Please check...",
                    
                ];
           }
           else{
                $json_response = [
                    "msg_status" => 0,
                    "msg_data" => "",
                  
                ];
           }

           header('Content-Type: application/json');
           echo json_encode( $json_response );
           exit;

        }else{
            redirect('login','refresh');
        }
	}
	


	public function checkVehicleEqpName() {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {

           $json_response = [];
           $eqpname = $this->input->post("eqpname");
           $where = [
               "vehicle_master.equipment_name" => trim($eqpname)
           ];
           $isExist = $this->commondatamodel->duplicateValueCheck("vehicle_master",$where);
           if($isExist) {
                $json_response = [
                    "msg_status" => 1,
                    "msg_data" => "This Equipment Name already exist.Please check...",
                    
                ];
           }
           else{
                $json_response = [
                    "msg_status" => 0,
                    "msg_data" => "",
                  
                ];
           }

           header('Content-Type: application/json');
           echo json_encode( $json_response );
           exit;

        }else{
            redirect('login','refresh');
        }
	}
	



	public function setStatus(){
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$updID = trim($this->input->post('uid'));
			$setstatus = trim($this->input->post('setstatus'));
			
			$update_array  = array(
				"is_active" => $setstatus
				);
				
			$where = array(
				"vehicle_master.vehicle_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('vehicle_master',$update_array,$where);
			if($update)
			{
				$json_response = array(
					"msg_status" => 1,
					"msg_data" => "Status updated"
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "Failed to update"
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('login','refresh');
		}
	}
	
}

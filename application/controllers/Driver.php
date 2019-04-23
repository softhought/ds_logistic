<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Driver extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
        $this->load->model('Driver_model','driver',TRUE);
    }

	
	public function index(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/driver/driver_list';
            $result['driverList']=$this->mastermodel->getDriverList();
           // pre($result['driverList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }
    
    

    public function addDriver(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
			if($this->uri->rsegment(3) == NULL)
			{
				$result['mode'] = "ADD";
				$result['btnText'] = "Save";
				$result['btnTextLoader'] = "Saving...";
                $driverID = 0;
                $result['driverID'] = $driverID;
				$result['driverEditdata'] = [];
				
				
				//getAllRecordWhereOrderBy($table,$where,$orderby)
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
                $driverID = $this->uri->segment(3);
                $result['driverID'] = $driverID;
                
				$whereAry = [
                    'driver_master.driver_id' => $driverID
                ];

				// getSingleRowByWhereCls(tablename,where params)
				 $result['driverEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('driver_master',$whereAry); 
				//	pre($result['cbnaatEditdata']);exit;
				
			}

			$result['vehicleTypeList'] = $this->commondatamodel->getAllDropdownData("vehicle_type");
			$result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
          //  pre($result['projectList']);

			$header = "";
			$page = 'dashboard/admin_dashboard/master/driver/add_driver';
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
        }
        

    }


    public function driver_action() {

        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			
		
			$driverId = trim(htmlspecialchars($dataArry['driverID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));
            $drivercode = trim(htmlspecialchars($dataArry['drivercode']));
			$drivername = trim(htmlspecialchars($dataArry['drivername']));
			$workingproject = trim(htmlspecialchars($dataArry['workingproject']));
			$vehicleType = trim(htmlspecialchars($dataArry['vehicleType']));
			$driverpassword = trim(htmlspecialchars($dataArry['driverpassword']));
			
			
			


			if($drivercode!="0" && $drivername!="" && $driverpassword!="")
			{
	
				
				
				if($driverId>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					

					$update = $this->driver->updateDriver($dataArry,$session);
					
					
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

			
					$insertData = $this->driver->insertIntoDriver($dataArry,$session);
					

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



    public function checkPassword() {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {

           $json_response = [];
           $passWord = $this->input->post("pass");
           $where = [
               "driver_master.driver_password" => $passWord
           ];
           $isExist = $this->commondatamodel->duplicateValueCheck("driver_master",$where);
           if($isExist) {
                $json_response = [
                    "msg_status" => 1,
                    "msg_data" => "already in use.Try new one",
                    
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


    public function checkDriverCode() {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {

           $json_response = [];
           $driverCode = $this->input->post("drivercode");
           $where = [
               "driver_master.driver_code" => $driverCode
           ];
           $isExist = $this->commondatamodel->duplicateValueCheck("driver_master",$where);
           if($isExist) {
                $json_response = [
                    "msg_status" => 1,
                    "msg_data" => "This driver code already exist.Please check...",
                    
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
				"driver_master.driver_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('driver_master',$update_array,$where);
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

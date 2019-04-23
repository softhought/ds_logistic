<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
    }

    /***************************************** Driver List *****************************************/

    public function index()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/driver_list';
            $result['driverList']=$this->mastermodel->getDriverList();
           // pre($result['driverList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }

    /***************************************** Driver List end *****************************************/


    /***************************************** Vehicle List *****************************************/

    public function vehicle()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/vehicle_list';
            $result['vehicleList']=$this->mastermodel->getVehicleList();
           // pre($result['driverList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }

    /***************************************** Vehicle List end *****************************************/


    /***************************************** Mobile uuid List & Insert *****************************************/

    public function mobile()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/mobile_list';
            $result['mobileList']=$this->commondatamodel->getAllDropdownData('mobile_master');
           // pre($result['driverList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }

    public function setMobileId()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/addedit_mobile_id';
            
            if($this->uri->segment(3) == NULL)
			{                               
                $result['mode']='ADD';
                $result['btnText']='Save';
                $result['btnTextLoader']='Saving...';                	
            }else{                
                $result['mode'] = "EDIT";	
                $result['btnText'] = "Update";
                $result['btnTextLoader'] = "Updating...";
				$whereAry = array(
					'mobile_id' =>$this->uri->segment(3)
                );
                $result['editMobile']=$this->commondatamodel->getSingleRowByWhereCls('mobile_master',$whereAry); 
            }	



           // pre($result['driverList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }

    public function mobileIdAddEdit()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $mode=$this->input->post('mode');
            $mobile_uuid = $this->input->post('mobile_uuid');
            $mobile_no = $this->input->post('mobile_no');
            $table='mobile_master';
            $data=[
                "mobile_uuid"=>$mobile_uuid,
                "mobile_no" => $mobile_no,
                "is_new" => "Y"
            ];
            if($mode=="ADD")
            {
                $insert=$this->commondatamodel->insertSingleTableData($table,$data);
            }else{                
                $where=[
                    "mobile_id"=>$this->input->post('mobile_id')
                ];
                $insert=$this->commondatamodel->updateSingleTableData($table,$data,$where);
            }

            if($insert)
            {
                $json_response = array(
                    "msg_status" => HTTP_SUCCESS,
                    "msg_data" => "Saved successfully",
                    "mode" => "ADD"
                );
            }else{
                $json_response = array(
                    "msg_status" => HTTP_FAIL,
                    "msg_data" => "There is some problem.Try again"
                );
            }
            header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;

        }else{
            redirect('login','refresh');
        }
    }


    public function setMobileStatus(){
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$updID = trim($this->input->post('uid'));
			$setstatus = trim($this->input->post('setstatus'));
			
			$update_array  = array(
				"is_active" => $setstatus
				);
				
			$where = array(
				"mobile_master.mobile_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('mobile_master',$update_array,$where);
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


    /***************************************** Mobile uuid List & Insert end *****************************************/




    /***************************************** Assign Mobile to Vehicle *****************************************/

    public function assignMobiletoVehicleList()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/assignMobile_to_VehicleList';
            $result['ListData']=$this->mastermodel->getListofVehicleHavingMobileId();
           // pre($result['ListData']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
        
    }

    public function assignMobiletoVehicle()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            //$result['MobileList']=$this->commondatamodel->getAllDropdownData('mobile_master'); 
           // $result['VehicleList']=$this->commondatamodel->getAllDropdownData('vehicle_master'); 

            $result['MobileList']=$this->mastermodel->getUnassignMobileList();    
            $result['VehicleList']=$this->mastermodel->getUnassignVehicleList();

            if($this->uri->segment(3) == NULL)
			{                               
                $result['mode']='ADD';
                $result['btnText']='Save';
                $result['btnTextLoader']='Saving...';      

            }else{



                $result['mode'] = "EDIT";	
                $result['btnText'] = "Update";
                $result['btnTextLoader'] = "Updating...";
				$whereAry = array(
					'vehicle_id' =>$this->uri->segment(3)
                );
                $result['EditMobileAssign']=$this->commondatamodel->getSingleRowByWhereCls('vehicle_master',$whereAry);  


                            
                
            }	

            $page = 'dashboard/admin_dashboard/master/assignMobile_to_Vehicle';            
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
        
    }

    public function assignMobileAddEdit()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $mode=$this->input->post('mode');
            $mobile_uuid=$this->input->post('mobile_id');
            $vehicle_id=$this->input->post('vehicle_id');
            $table='vehicle_master';
            $data=[
                "mobile_uniq_id"=>$mobile_uuid
            ];                          
            $where=[
                "vehicle_id"=>$this->input->post('vehicle_id')
            ];
            $insert=$this->commondatamodel->updateSingleTableData($table,$data,$where);           

            if($insert)
            {
                $json_response = array(
                    "msg_status" => HTTP_SUCCESS,
                    "msg_data" => "Saved successfully",
                    "mode" => "ADD"
                );
            }else{
                $json_response = array(
                    "msg_status" => HTTP_FAIL,
                    "msg_data" => "There is some problem.Try again"
                );
            }
            header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;

        }else{
            redirect('login','refresh');
        }
    }

// reset Assign Mobile to Vehicle

    public function resetMobileToVehicle(){
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$updID = trim($this->input->post('uid'));
			
			
			$update_array  = array(
				"mobile_uniq_id" => NULL
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



    /***************************************** Assign Mobile to Vehicle end *****************************************/

   

    public function supervisor()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/supervisor_list';
            $result['supervisorList']=$this->mastermodel->getSupervisorList();
           // pre($result['superadmList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }


        public function setSupervisorStatus(){
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $updID = trim($this->input->post('uid'));
            $setstatus = trim($this->input->post('setstatus'));
            
            $update_array  = array(
                "is_active" => $setstatus
                );
                
            $where = array(
                "supervisor_master.supervisor_id" => $updID
                );
            
            
        
           $update = $this->commondatamodel->updateSingleTableData('supervisor_master',$update_array,$where);
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

    public function addSupervisor()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/supervisor_add_edit';
            
            if($this->uri->segment(3) == NULL)
            {                               
                $result['mode']='ADD';
                $result['btnText']='Save';
                $result['btnTextLoader']='Saving...';                   
            }else{                
                $result['mode'] = "EDIT";   
                $result['btnText'] = "Update";
                $result['btnTextLoader'] = "Updating...";
                $whereAry = array(
                    'supervisor_id' =>$this->uri->segment(3)
                );
                $result['editSupervisor']=$this->commondatamodel->getSingleRowByWhereCls('supervisor_master',$whereAry); 
            }   

          $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");

           // pre($result['driverList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }


    public function checkSupervisorPin() {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {

           $json_response = [];
           $supervisorpin = $this->input->post("supervisorpin");
           $where = [
               "supervisor_master.pin" => trim($supervisorpin)
           ];
           $isExist = $this->commondatamodel->duplicateValueCheck("supervisor_master",$where);
           if($isExist) {
                $json_response = [
                    "msg_status" => 1,
                    "msg_data" => "This Pin already used by another user.Please check...",
                    
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

    public function checkSupervisorEmployeeCode() {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {

           $json_response = [];
           $emp_code = $this->input->post("emp_code");
           $where = [
               "supervisor_master.emp_code" => trim($emp_code)
           ];
           $isExist = $this->commondatamodel->duplicateValueCheck("supervisor_master",$where);
           if($isExist) {
                $json_response = [
                    "msg_status" => 1,
                    "msg_data" => "This Pin already used by another user.Please check...",
                    
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

    public function supervisor_action()
    {
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $json_response = array();
            $formData = $this->input->post('formDatas');
            parse_str($formData, $dataArry);
            
           $mode=$this->input->post('mode');
           $supervisorID = $this->input->post('supervisorID');
           $spname = $this->input->post('spname');
           $emp_code = $this->input->post('emp_code');
           $supervisorpin = $this->input->post('supervisorpin');
           $project = $this->input->post('project');
           $designation = $this->input->post('sel_employee_type');

          


    
                
                
                if($supervisorID>0 && $mode=="EDIT")
                {
                    /*  EDIT MODE
                     *  -----------------
                    */

                    $array_upd = array(
                        "emp_code" => $emp_code,
                        "name" => $spname,
                        "pin" => $supervisorpin,
                        "project_id" => $project,
                        "designation" => $designation,
                       
                    );

                    $where_upd = array(
                        "supervisor_master.supervisor_id" => $supervisorID
                    );

              
                
                    $update = $this->commondatamodel->updateSingleTableData('supervisor_master',$array_upd,$where_upd);
                    
                    
                    if($update)
                    {
                        $json_response = array(
                            "msg_status" => HTTP_SUCCESS,
                            "msg_data" => "Updated successfully",
                            "mode" => "EDIT"
                        );
                    }
                    else
                    {
                        $json_response = array(
                            "msg_status" => HTTP_FAIL,
                            "msg_data" => "There is some problem while updating ...Please try again."
                        );
                    }



                } // end if mode
                else
                {
                    /*  ADD MODE
                     *  -----------------
                    */


                    $array_insert = array(
                        "emp_code" => $emp_code,
                        "name" => $spname,
                        "pin" => $supervisorpin,
                        "project_id" => $project,
                        "designation" => $designation,
                        "is_active" => 'Y',
                       
                    );
                    
                    
                        
                   
                    $insertData = $this->commondatamodel->insertSingleTableData('supervisor_master',$array_insert);

                    if($insertData)
                    {
                        $json_response = array(
                            "msg_status" => HTTP_SUCCESS,
                            "msg_data" => "Saved successfully",
                            "mode" => "ADD"
                        );
                    }
                    else
                    {
                        $json_response = array(
                            "msg_status" => HTTP_FAIL,
                            "msg_data" => "There is some problem.Try again"
                        );
                    }

                } // end add mode ELSE PART




                


            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;

            

        }
        else
        {
            redirect('login','refresh');
        }
    }

/* ************************************ Break Down Cause *************************************/

    public function breakdowncause(){
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/breakdown_cause/breakdown_cause_list';

           
            $result['breakDownCauseList']=$this->commondatamodel->getAllDropdownData("breakdown_cause_master");;

            $header = "";

            // pre($result['breakDownCauseList']);
            // exit;

            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }

}/* end of class */
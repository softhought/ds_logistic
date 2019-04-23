<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Project extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
       $this->load->model('Project_model','project',TRUE);
    }

	
	public function index(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/project/project_list';
            $result['projectList']=$this->project->getProjectList();
            $header = "";
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }
    
    
    public function addProject(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
			if($this->uri->rsegment(3) == NULL)
			{
				$result['mode'] = "ADD";
				$result['btnText'] = "Save";
				$result['btnTextLoader'] = "Saving...";
                $projectID = 0;
                $result['projectID'] = $projectID;
				$result['projectEditdata'] = [];
				
				
				//getAllRecordWhereOrderBy($table,$where,$orderby)
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
                $projectID = $this->uri->segment(3);
                $result['projectID'] = $projectID;
                
				$whereAry = [
                    'project_master.project_id' => $projectID
                ];

				// getSingleRowByWhereCls(tablename,where params)
				 $result['projectEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('project_master',$whereAry); 
				//	pre($result['cbnaatEditdata']);exit;
				
			}

                 $result['locationList'] = $this->commondatamodel->getAllDropdownData("location_master");

			$header = "";
			$page = 'dashboard/admin_dashboard/master/project/project_add_edit.php';
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
        }
        

    }

    public function checkProjectCode() {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {

           $json_response = [];
           $projectcode = $this->input->post("projectcode");
           $where = [
               "project_master.project_nickname" => trim($projectcode)
           ];
           $isExist = $this->commondatamodel->duplicateValueCheck("project_master",$where);
           if($isExist) {
                $json_response = [
                    "msg_status" => 1,
                    "msg_data" => "This Project Code already exist.Please check...",
                    
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
	
    public function project_action() {

        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			

			
		
			$projectID = trim(htmlspecialchars($dataArry['projectID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));

            $projectname = trim(htmlspecialchars($dataArry['projectname']));
            $projectcode = trim(htmlspecialchars($dataArry['projectcode']));
            $location = trim(htmlspecialchars($dataArry['location']));

			
			


			if($projectname!="" && $projectcode!="")
			{
	
				
				
				if($projectID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					$upd_where = array('project_master.project_id' =>$projectID);

                    $upd_array = array(
                        'project_name' => $projectname,
                        'project_nickname' => $projectcode,
                        'location_id' => $location,
                     );

                        $update = $this->commondatamodel->updateSingleTableData('project_master',$upd_array,$upd_where);
					
					
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

                    $insert_array = array(
                                            'project_name' => $projectname,
                                            'project_nickname' => $projectcode,
                                            'location_id' => $location,
                                         );
			
					$insertData = $this->commondatamodel->insertSingleTableData('project_master',$insert_array);
					

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
	

	public function setProjectStatus(){
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$updID = trim($this->input->post('uid'));
			$setstatus = trim($this->input->post('setstatus'));
			
			$update_array  = array(
				"is_active" => $setstatus
				);
				
			$where = array(
				"project_master.project_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('project_master',$update_array,$where);
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
 
}// end of class

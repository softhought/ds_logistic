<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dumpingyard extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
       $this->load->model('Dumpingyard_model','dumping',TRUE);
    }

	
	public function index(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/dumping_yard/dumping_yard_list';
            $result['dumpingyardList']=$this->dumping->getDumpingyardList();
            $header = "";
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }
    
    
    public function addYard(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
			if($this->uri->rsegment(3) == NULL)
			{
				$result['mode'] = "ADD";
				$result['btnText'] = "Save";
				$result['btnTextLoader'] = "Saving...";
                $yardID = 0;
                $result['yardID'] = $yardID;
				$result['yardEditdata'] = [];
				
				
				//getAllRecordWhereOrderBy($table,$where,$orderby)
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
                $yardID = $this->uri->segment(3);
                $result['yardID'] = $yardID;
                
				$whereAry = [
                    'dumping_yard_master.dumping_yard_id' => $yardID
                ];

				// getSingleRowByWhereCls(tablename,where params)
				 $result['yardEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('dumping_yard_master',$whereAry); 
				//	pre($result['yardEditdata']);exit;
				
			}

                 $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");

			$header = "";
			$page = 'dashboard/admin_dashboard/master/dumping_yard/dumping_yard_add_edit.php';
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
        }
        

    }


	
    public function dumpingyard_action() {

        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			

			
		
			$yardID = trim(htmlspecialchars($dataArry['yardID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));

            $yardname = trim(htmlspecialchars($dataArry['yardname']));
            $project = trim(htmlspecialchars($dataArry['project']));
            

			
			


			if($yardname!="" && $project!="")
			{
	
				
				
				if($yardID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					$upd_where = array('dumping_yard_master.dumping_yard_id' =>$yardID);

                    $upd_array = array(
                        'dumping_yard_name' => $yardname,
                        'project_id' => $project
                       
                     );

                        $update = $this->commondatamodel->updateSingleTableData('dumping_yard_master',$upd_array,$upd_where);
					
					
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
                                            'dumping_yard_name' => $yardname,
                                            'project_id' => $project,
                                            'is_active' => 'Y'
                                         );
			
					$insertData = $this->commondatamodel->insertSingleTableData('dumping_yard_master',$insert_array);
					

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
	

	public function setYardStatus(){
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$updID = trim($this->input->post('uid'));
			$setstatus = trim($this->input->post('setstatus'));
			
			$update_array  = array(
				"is_active" => $setstatus
				);
				
			$where = array(
				"dumping_yard_master.dumping_yard_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('dumping_yard_master',$update_array,$where);
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

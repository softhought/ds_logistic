<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Material extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
        $this->load->model('Material_model','material',TRUE);
       
    }

	
	public function index(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/material/material_list';
            $result['materialList']=$this->commondatamodel->getAllDropdownData("material_type");
            $header = "";
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }


    
    
    public function addMaterial(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
			if($this->uri->rsegment(3) == NULL)
			{
				$result['mode'] = "ADD";
				$result['btnText'] = "Save";
				$result['btnTextLoader'] = "Saving...";
                $materialID = 0;
                $result['materialID'] = $materialID;
				$result['materialEditdata'] = [];
				
				
				//getAllRecordWhereOrderBy($table,$where,$orderby)
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
                $materialID = $this->uri->segment(3);
                $result['materialID'] = $materialID;
                
				$whereAry = [
                    'material_type.material_type_id' => $materialID
                ];

				// getSingleRowByWhereCls(tablename,where params)
				 $result['materialEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('material_type',$whereAry); 
				//	pre($result['cbnaatEditdata']);exit;
				
			}

               

			$header = "";
			$page = 'dashboard/admin_dashboard/master/material/material_add_edit';
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
        }
        

    }


	
    public function material_action() {

        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			

			
		
			$materialID = trim(htmlspecialchars($dataArry['materialID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));

            $material = trim(htmlspecialchars($dataArry['material']));
           
			
			


			if($material!="")
			{
	
				
				
				if($materialID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					$upd_where = array('material_type.material_type_id' =>$materialID);

                    $upd_array = array(
                        'material' => $material
                       
                     );

                        $update = $this->commondatamodel->updateSingleTableData('material_type',$upd_array,$upd_where);
					
					
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
                                            'material' => $material,
                                            'is_active' => 'Y'
                                         );
			
					$insertData = $this->commondatamodel->insertSingleTableData('material_type',$insert_array);
					

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
	

	public function setMaterialStatus(){
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$updID = trim($this->input->post('uid'));
			$setstatus = trim($this->input->post('setstatus'));
			
			$update_array  = array(
				"is_active" => $setstatus
				);
				
			$where = array(
				"material_type.material_type_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('material_type',$update_array,$where);
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


	/*=============================================== Project material assign ==============================*/


   public function materialassign(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/material/project_material_assign_list.php';
            $result['assignmaterialList']=$this->material->getMaterialAgainstProjectList();
           // pre( $result['assignmaterialList']);
            $header = "";
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }



    public function addMaterialAssign(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
			if($this->uri->rsegment(3) == NULL)
			{
				$result['mode'] = "ADD";
				$result['btnText'] = "Save";
				$result['btnTextLoader'] = "Saving...";
                $materialassignID = 0;
                $result['materialassignID'] = $materialassignID;
				$result['materialAssignEditdata'] = [];
				
				
				//getAllRecordWhereOrderBy($table,$where,$orderby)
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
                $materialassignID = $this->uri->segment(3);
                $result['materialassignID'] = $materialassignID;
                
				$whereAry = [
                    'project_material_details.project_material_id' => $materialassignID
                ];

				// getSingleRowByWhereCls(tablename,where params)
				 $result['materialAssignEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('project_material_details',$whereAry); 
				//	pre($result['materialAssignEditdata']);exit;
				
			}

            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master"); 
            $result['materialList'] = $this->commondatamodel->getAllDropdownData("material_type"); 

			$header = "";
			$page = 'dashboard/admin_dashboard/master/material/project_material_assign_add_edit';
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
        }
        

    }


    	public function setMaterialAssignProjectStatus(){
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$updID = trim($this->input->post('uid'));
			$setstatus = trim($this->input->post('setstatus'));
			
			$update_array  = array(
				"is_active" => $setstatus
				);
				
			$where = array(
				"project_material_details.project_material_id" => $updID
				);
			
			
		
			$update = $this->commondatamodel->updateSingleTableData('project_material_details',$update_array,$where);
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



    public function materialassign_action() {

        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			

			
		
			$materialassignID = trim(htmlspecialchars($dataArry['materialassignID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));

            $project = $dataArry['project'];
            $material = $dataArry['material'];
            $conversation_factor = $dataArry['cf'];
           
			
			


			if($conversation_factor!="")
			{
	
				
				
				if($materialassignID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

							$checkarray = array(
												'project_id' => $project,
								                'material_type_id' => $material,
								                'project_material_id!='=> $materialassignID
											   );

							$chechexist=$this->commondatamodel->duplicateValueCheck('project_material_details',$checkarray);
						
						if (!$chechexist) {
							
							$upd_where = array('project_material_details.project_material_id' =>$materialassignID);

		                    $upd_array = array(
		                        'project_id' => $project,
		                        'material_type_id' => $material,
		                        'conversation_factor' => $conversation_factor,
		                       
		                     );

		                        $update = $this->commondatamodel->updateSingleTableData('project_material_details',$upd_array,$upd_where);
							
							
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



					


					}else{

								$json_response = array(
									"msg_status" => 0,
									"msg_data" => "Data already exist!"
								);
						}



				} // end if mode
				else
				{
					/*  ADD MODE
					 *	-----------------
					*/
					$checkarray = array(
										'project_id' => $project,
						                'material_type_id' => $material
									   );

					$chechexist=$this->commondatamodel->duplicateValueCheck('project_material_details',$checkarray);

						if (!$chechexist) {

							 $insert_array = array(
                                             'project_id' => $project,
						                     'material_type_id' => $material,
						                     'conversation_factor' => $conversation_factor,
                                             'is_active' => 'Y'
                                         );
			
							$insertData = $this->commondatamodel->insertSingleTableData('project_material_details',$insert_array);
							

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
									"msg_status" => 0,
									"msg_data" => "There is some problem.Try again"
								);
							}


							
						}else{

								$json_response = array(
									"msg_status" => 0,
									"msg_data" => "Data already exist!"
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

 
}// end of class

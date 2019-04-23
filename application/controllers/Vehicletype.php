<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicletype extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
        $this->load->model('Vehicletype_model','vehicletype',TRUE);
    }

	
	public function index(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/master/vehicletype/vehicletype_list';
            $result['vehicleTypeList']=$this->commondatamodel->getAllDropdownData("vehicle_type");
           // pre($result['driverList']);
            $header = "";
           
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }
    
    

    public function addVehicletype(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
			if($this->uri->rsegment(3) == NULL)
			{
				$result['mode'] = "ADD";
				$result['btnText'] = "Save";
				$result['btnTextLoader'] = "Saving...";
                $vehicletypeID = 0;
                $result['vehicletypeID'] = $vehicletypeID;
				$result['vehicletypeEditdata'] = [];
				
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
                $vehicletypeID = $this->uri->segment(3);
                $result['vehicletypeID'] = $vehicletypeID;
                $whereAry = [
                    'vehicle_type.vehicle_type_id' => $vehicletypeID
                ];
				$result['vehicletypeEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('vehicle_type',$whereAry); 

			}

          
			$header = "";
			$page = 'dashboard/admin_dashboard/master/vehicletype/add_vehicletype';
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
        }
        

    }


    public function vehicletype_action() {

        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			
			$vehicletypeID = trim(htmlspecialchars($dataArry['vehicletypeID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));
			$vehicletype = trim(htmlspecialchars($dataArry['vehicletype']));
			
			
			
			


			if($vehicletype!="")
			{
	
				
				
				if($vehicletypeID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					

					$update = $this->vehicletype->updateVehicletype($dataArry,$session);
					
					
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

			
					$insertData = $this->vehicletype->insertIntoVehicletype($dataArry,$session);
					

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
			redirect('login','refresh');
		}
    }



 
}

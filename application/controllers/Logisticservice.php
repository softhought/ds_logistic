<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logisticservice extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->model("Logistic_model", "logisticmodel", TRUE);
	}
	
	public function index()
    { }

    public function getProjects()
    {
			//CUSTOMHEADER::getCustomHeader();
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
          
			$data = $this->commondatamodel->getAllDropdownData('project_master');
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => $data
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
        
      
    }
	
	
	public function getLocation() 
	{
			//CUSTOMHEADER::getCustomHeader();
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
          
			$data = $this->commondatamodel->getAllDropdownData('location_master');
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => $data
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
	}
	
	
	
	public function getVehicleType() 
	{
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
          
			$data = $this->commondatamodel->getAllDropdownData('vehicle_type');
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => $data
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
	}
    
	
	public function getVehicles() 
	{
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
          
			$data = $this->commondatamodel->getAllDropdownData('vehicle_master');
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => $data
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
	}
	
	
	public function getDrivers() 
	{
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
          
			$data = $this->commondatamodel->getAllDropdownData('driver_master');
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => $data
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
	}
	
	public function getMobile() {
			
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
          
			$data = $this->commondatamodel->getAllDropdownData('mobile_master');
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => $data
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
	}
	
	public function updateLocalTransHistory() {
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
			
			
			$data = $this->logisticmodel->updateLocalTransHistory($request);
			
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => $data
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
	}


	public function updateLocalTransExcavatorAssign() {
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 1000");
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
		header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
		
		$json_response = [];
		$headers = $this->input->request_headers();
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		
		
		$data = $this->logisticmodel->updateLocalTransExcavatorAssign($request);
	
		if($data){
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"SUCCESS",
				"result_data" => $data
			];
		}
		else{
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"There is some problem.Please try again",
			];
		}
	
	
	header('Content-Type: application/json');
	echo json_encode( $json_response );
	exit;
}
	
	
	public function getAppUpdateVerion(){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 1000");
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
		header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
		//return CURRENT_APP_VERSION; 
		
		$json_response = [];
		$headers = $this->input->request_headers();
		$json_response = [
                    "msg_status" => HTTP_SUCCESS,
					"version" => CURRENT_APP_VERSION,
                    "msg_data" => "SUCCESS"
                ];
				
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
	}
	
	
	public function updateBreakDownData() {
		
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
			
			
			$data = $this->logisticmodel->updateBreakDownData($request);
			
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => NULL
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
	}
	
	/*------------------- get supervisor_master added on 13.02.2019 ------------ */
	public function getSupervisor() {
			
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 1000");
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
		header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
		
		$json_response = [];
		$headers = $this->input->request_headers();
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
	  
		$data = $this->commondatamodel->getAllDropdownData('supervisor_master');
		if($data){
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"SUCCESS",
				"result_data" => $data
			];
		}
		else{
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"There is some problem.Please try again",
			];
		}
	
	
	header('Content-Type: application/json');
	echo json_encode( $json_response );
	exit;
}	
	

	/*------------------- get dumping_yard_master added on 30.03.2019 ------------ */
	public function getYardMaster() {
			
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 1000");
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
		header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
		
		$json_response = [];
		$headers = $this->input->request_headers();
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
	  
		$data = $this->commondatamodel->getAllDropdownData('dumping_yard_master');
		if($data){
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"SUCCESS",
				"result_data" => $data
			];
		}
		else{
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"There is some problem.Please try again",
			];
		}
	
	
	header('Content-Type: application/json');
	echo json_encode( $json_response );
	exit;
}


/**
  * By Mithilesh 
  * On 11.04.2019
  * 
  */

	public function syncVehicalDistanceData(){
		
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Access-Control-Max-Age: 1000");
			header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
			header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
			
			$json_response = [];
			$headers = $this->input->request_headers();
        
		    $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
			
			
			$data = $this->logisticmodel->updateVehicalDistanceLocalTransHistory($request);
			
			if($data){
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"SUCCESS",
					"result_data" => $data
                ];
			}
			else{
				$json_response = [
                    "msg_status"=>HTTP_SUCCESS,
                    "msg_data"=>"There is some problem.Please try again",
                ];
			}
        
        
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
	}
	
	
	
	
	
    /*
	* Name : getMaterialType 
	* On   : 18.04.2019
	*/
	
	
	public function getMaterialType() {
			
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 1000");
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
		header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
		
		$json_response = [];
		$headers = $this->input->request_headers();
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
	  
		$data = $this->commondatamodel->getAllDropdownData('material_type');
		if($data){
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"SUCCESS",
				"result_data" => $data
			];
		}
		else{
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"There is some problem.Please try again",
			];
		}
	
	
	header('Content-Type: application/json');
	echo json_encode( $json_response );
	exit;
}

	
	
	
	
	
	 /*
	* Name : getProjectWiseMaterial 
	* On   : 18.04.2019
	*/
	
	
	public function getProjectWiseMaterial() {
			
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 1000");
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding,x-api-key");
		header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE"); 
		
		$json_response = [];
		$headers = $this->input->request_headers();
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
	  
		$data = $this->commondatamodel->getAllDropdownData('project_material_details');
		if($data){
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"SUCCESS",
				"result_data" => $data
			];
		}
		else{
			$json_response = [
				"msg_status"=>HTTP_SUCCESS,
				"msg_data"=>"There is some problem.Please try again",
			];
		}
	
	
	header('Content-Type: application/json');
	echo json_encode( $json_response );
	exit;
}

	
	
	
	
	
	
	
  
  
}//end of class
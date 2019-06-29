<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lead extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
       $this->load->model('Lead_model','lead',TRUE);
    }

	
	public function index(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/lead/lead_list';

            $today=date("Y-m-d");
            $project=0;
            $result['leadagvehiList']=$this->lead->getLeadAgainstVehicleList($today,$project);
             $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
            $header = "";
            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }

    public function getLeadListByDate(){
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/lead/lead_list_partial_view';

           // $shiftdate = date("Y-m-d",strtotime($this->input->post('shiftdate')));


               $shiftdate=$this->input->post('shiftdate');
               $project=$this->input->post('project');
            
            if($shiftdate!=""){
                $shiftdate = str_replace('/', '-', $shiftdate);
                $shiftdate = date("Y-m-d",strtotime($shiftdate));
             }
             else{
                 $shiftdate = NULL;
             }

            $result['leadagvehiList']=$this->lead->getLeadAgainstVehicleList($shiftdate,$project);
            $header = "";

             $display = $this->load->view($page,$result,TRUE);
            echo $display;
 
           // createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }



    public function addLead(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            if($this->uri->rsegment(3) == NULL)
            {
                $result['mode'] = "ADD";
                $result['btnText'] = "Save";
                $result['btnTextLoader'] = "Saving...";
                $leadID = 0;
                $result['leadID'] = $leadID;
                $result['leadEditdata'] = [];
                
                
                //getAllRecordWhereOrderBy($table,$where,$orderby)
                
                
            
            }
            else
            {
                $result['mode'] = "EDIT";
                $result['btnText'] = "Update";
                $result['btnTextLoader'] = "Updating...";
                $leadID = $this->uri->segment(3);
                $result['leadID'] = $leadID;
                
                $whereAry = [
                    'lead_against_vehicle.id' => $leadID
                ];

                // getSingleRowByWhereCls(tablename,where params)
                 $result['leadEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('lead_against_vehicle',$whereAry); 
                //  pre($result['cbnaatEditdata']);exit;
                
            }
                 // $where = array('vehicle_master.vehicle_type_id' => 1 ); //1=EXCAVATOR
                 // $result['excavatorList'] = $this->commondatamodel->getAllRecordWhere('vehicle_master',$where);

                 $whereservier = array('supervisor_master.designation' =>'SERVIER' );

                 $result['servierList'] = $this->commondatamodel->getAllRecordWhere('supervisor_master',$whereservier);

                 $result['materialTypeList'] = $this->commondatamodel->getAllDropdownData('material_type');
                 $result['shiftList'] = $this->commondatamodel->getAllDropdownData('shift_master');
                  $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
                // pre($result['excavatorList'] );

            $header = "";
            $page = 'dashboard/admin_dashboard/lead/lead_add_edit.php';
            createbody_method($result, $page, $header,$session);
        }
        else
        {
            redirect('login','refresh');
        }
        

    }


        public function lead_action() {

        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $json_response = array();
            $formData = $this->input->post('formDatas');
            $rowDtlNo = $this->input->post('rowDtlNo');
            parse_str($formData, $dataArry);
            
         
          
    
            $leadID = trim(htmlspecialchars($dataArry['leadID']));
            $mode = trim(htmlspecialchars($dataArry['mode']));
            $sel_servier = $dataArry['sel_servier'];
            $sel_shift = $dataArry['sel_shift'];
            
            $sel_excavator = $dataArry['sel_excavator'];

            $material_type = $dataArry['material_type_'.$rowDtlNo];
            $lead = trim(htmlspecialchars($dataArry['lead_'.$rowDtlNo]));
            $rl_in_face = trim(htmlspecialchars($dataArry['rl_in_face_'.$rowDtlNo]));
            $rl_in_dump = trim(htmlspecialchars($dataArry['rl_in_dump_'.$rowDtlNo]));

            $shiftdate = $dataArry['shiftdate'];
            
            if($shiftdate!=""){
                $shiftdate = str_replace('/', '-', $shiftdate);
                $shiftdate = date("Y-m-d",strtotime($shiftdate));
             }
             else{
                 $shiftdate = NULL;
             }

  
            $where_serv = array('supervisor_master.supervisor_id' => $sel_servier); 
            $result['servierData']=$this->commondatamodel->getSingleRowByWhereCls('supervisor_master',$where_serv);

            $projectId=$result['servierData']->project_id;


            if($sel_servier!="" && $sel_shift!="")
            {
    
                
                
                if($leadID>0 && $mode=="EDIT")
                {
                    /*  EDIT MODE
                     *  -----------------
                    */


                        $update =1;
                    
                    
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
                     *  -----------------
                    */
                    $checkarray = array(
                                            'shift_date' => $shiftdate,
                                            'shift_code' => $sel_shift,
                                            'vehicle_mst_id' => $sel_excavator,
                                            'project_material_id' => $material_type,
                                            'project_id' => $projectId 
                                         );
                    $check = $this->commondatamodel->checkExistanceData('lead_against_vehicle',$checkarray);
                    if (!$check) {
                       
                    $insert_array = array(
                                            'servier_mst_id' => $sel_servier,
                                            'shift_date' => $shiftdate,
                                            'shift_code' => $sel_shift,
                                            'vehicle_mst_id' => $sel_excavator,
                                            'project_material_id' => $material_type,
                                            'lead' => $lead,
                                            'rl_in_face' => $rl_in_face,
                                            'rl_in_dump' => $rl_in_dump,
                                            'project_id' => $projectId
                                           
                                         );
            
                    $insertData = $this->commondatamodel->insertSingleTableData('lead_against_vehicle',$insert_array);
                    

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


                // -------------------

                 $LeadData=$this->commondatamodel->getSingleRowByWhereCls('lead_against_vehicle',$checkarray);

                 $leadagveid=$LeadData->id;   
                  
                 $update_array  = array(
                    "lead" => $lead,
                    "rl_in_face" => $rl_in_face,
                    "rl_in_dump" => $rl_in_dump
               
                );
                
            $where = array(
                "lead_against_vehicle.id" => $leadagveid
                );
            
            
        
            $update = $this->commondatamodel->updateSingleTableData('lead_against_vehicle',$update_array,$where);






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


        /* get  district by state*/
public function getExcavatorByServier()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $sel_servier = $this->input->post('sel_servier');
            $project = $this->input->post('project');
            $sel_shift = $this->input->post('sel_shift');
            $shiftdate = $this->input->post('shiftdate');
            
              if($shiftdate!=""){
                $shiftdate = str_replace('/', '-', $shiftdate);
                $shiftdate = date("Y-m-d",strtotime($shiftdate));
              
             }
             else{
                 $shiftdate = NULL;
                
             }
            
            if($sel_servier!='0'){
            $where_serv = array('supervisor_master.supervisor_id' => $sel_servier); 
            $result['servierData']=$this->commondatamodel->getSingleRowByWhereCls('supervisor_master',$where_serv);

            $projectId=$result['servierData']->project_id;

            $where_vehicle = array(
                                    'vehicle_master.project_id' => $projectId, 
                                    'vehicle_master.vehicle_type_id' => 1, //1=EXCAVATOR
                                    'vehicle_master.is_active' => 'Y'
                                   
                                  ); 


            }


            if($sel_servier!='0' && $sel_shift!='0' && $shiftdate!=''){

                $result['excavatorList']=$this->lead->getExcavatorListByProjectDateShift($projectId,$sel_shift,$shiftdate);

            }else if($sel_servier!='0'){

               $result['excavatorList']=$this->commondatamodel->getAllRecordWhere('vehicle_master',$where_vehicle); 

            }else{
               $result['excavatorList']=[];
              

           }
           

            // pre($result['excavatorList']);

            // exit;
             

            $page = 'dashboard/admin_dashboard/lead/excavator_view';
            //$partial_view = $this->load->view($page,$result);
            echo $this->load->view($page, $result, TRUE);
            //echo $partial_view;
        }
        else
        {
            redirect('login','refresh');
        }
    }



    /* change servier by project wise*/

    public function getServierByProject()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $project = $this->input->post('project');
          
            

          if($project!='0'){
                        $where_servier = array(
                                    'supervisor_master.project_id' => $project, 
                                    'supervisor_master.designation' => 'SURVEYOR', 
                                    'supervisor_master.is_active' => 'Y'
                                   
                                  ); 

               $result['servierList']=$this->commondatamodel->getAllRecordWhere('supervisor_master',$where_servier); 

            }else{
               $result['servierList']=[];
              

           }
           

      

            // pre($result['excavatorList']);

            // exit;
             

            $page = 'dashboard/admin_dashboard/lead/servier_view';
            //$partial_view = $this->load->view($page,$result);
            echo $this->load->view($page, $result, TRUE);
            //echo $partial_view;
        }
        else
        {
            redirect('login','refresh');
        }
    }


    /* change material by project wise*/

    public function getMaterialByProject()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $project = $this->input->post('project');
          
            

          if($project!='0'){
                        

               $result['materialTypeList']=$this->lead->getMaterialByProject($project); 

            }else{
               $result['materialTypeList']=[];
              

           }

             // pre($result['materialTypeList']);

             // exit;
             

         //   $page = 'dashboard/admin_dashboard/lead/material_view';
            $page = 'dashboard/admin_dashboard/lead/material_list_view';
            //$partial_view = $this->load->view($page,$result);
            echo $this->load->view($page, $result, TRUE);
            //echo $partial_view;
        }
        else
        {
            redirect('login','refresh');
        }
    }


     public function updateLeadData(){
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $json_response = array();
            $formData = $this->input->post('formDatas');
            parse_str($formData, $dataArry);
            
             $leadagveid = $dataArry['leadagveid'];
          
        
            
            $rl_in_face = trim(htmlspecialchars($dataArry['rl_in_face']));
            $lead = trim(htmlspecialchars($dataArry['lead']));
            $rl_in_dump = trim(htmlspecialchars($dataArry['rl_in_dump']));
            
            $update_array  = array(
                "lead" => $lead,
                "rl_in_face" => $rl_in_face,
                "rl_in_dump" => $rl_in_dump
               
                );
                
            $where = array(
                "lead_against_vehicle.id" => $leadagveid
                );
            
            
        
            $update = $this->commondatamodel->updateSingleTableData('lead_against_vehicle',$update_array,$where);
            if($update)
            {
                $json_response = array(
                    "msg_status" => 1,
                    "msg_data" => "Successfully updated"
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


} // end of class
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicledistance extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Vehicledistance_model','vehicledistance',TRUE);

        ini_set('memory_limit', '960M');
        ini_set('post_max_size', '640M');
        ini_set('upload_max_filesize', '640M');
        ini_set('max_execution_time', 900);
    }

    public function index()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {   $result = [];            
            $page = 'dashboard/admin_dashboard/vehicle_distance/vehicle_distance_view.php';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
            $result['vehicleType'] = $this->commondatamodel->getAllDropdownData("vehicle_type");
            $result['shiftList'] = $this->commondatamodel->getAllDropdownData("shift_master");
           
          
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }



 /* get Observer By Project */

public function getObserverByProject()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            
            $project = $this->input->post('project');
           
            if($project!='0'){

              $where_vehicle = array(
                                    'supervisor_master.project_id' => $project, 
                                    'supervisor_master.designation' => 'OBSERVABLE', // Tipper
                                    'supervisor_master.is_active' => 'Y'
                                   
                                  ); 

            $result['observerData']=$this->commondatamodel->getAllRecordWhere('supervisor_master',$where_vehicle);

            }else{
               $result['observerData']=[];
              

           }
           

             // pre($result['observerData']);

             // exit;
             $page = 'dashboard/admin_dashboard/vehicle_distance/observer_view.php';
           
          
            //$partial_view = $this->load->view($page,$result);
            echo $this->load->view($page, $result, TRUE);
            //echo $partial_view;
        }
        else
        {
            redirect('login','refresh');
        }
    }



     public function distanceAddEdit()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        { 
            $result =[];

            $result['allinputreadonly']='N';
            $result['startinput']='';
            $result['projectid']=$project=$this->input->post('project');
            $result['observerid']=$sel_observer=$this->input->post('sel_observer');
            $result['vehicle_type_id']=$vehicle_type=$this->input->post('vehicle_type');
            $shiftdate=$this->input->post('shiftdate');
            $result['shift']=$shift_code=$this->input->post('shiftcode');
           

            if($shiftdate!=""){
                $shiftdate = str_replace('/', '-', $shiftdate);
                $shiftdate = date("Y-m-d",strtotime($shiftdate));
                $result['shiftdate']=date("d-m-Y",strtotime($shiftdate));
             }
             else{
                 $shiftdate = NULL;
               
             }
           /* get project data */
           $where_project = array('project_master.project_id' =>$project);
           $projectData = $this->commondatamodel->getSingleRowByWhereCls('project_master',$where_project);
           $result['project']=$projectData->project_nickname; 

           /* get vehicle_type data */
           $where_vehicle_type = array('vehicle_type.vehicle_type_id' =>$vehicle_type);
           $vehicleTypeData = $this->commondatamodel->getSingleRowByWhereCls('vehicle_type',$where_vehicle_type);
           $result['vehicle_type']=$vehicleTypeData->vehicle_type;

           /* get observer data */
           $where_observer = array('supervisor_master.supervisor_id' =>$sel_observer);
           $observerData = $this->commondatamodel->getSingleRowByWhereCls('supervisor_master',$where_observer);
           $result['observer']=$observerData->name;

          
       
           /* check data exist or not */ 


              $check_array = array(
                                    'project_id' =>  $project, 
                                    'vehicle_type_id' =>  $vehicle_type, 
                                    'shift_date' =>  $shiftdate, 
                                    'shift_code' =>  $shift_code, 
                                  );

               $checkdata=$this->commondatamodel->getSingleRowByWhereCls('vehicle_distance_master',$check_array);

      //  print_r($checkdata);

              if ($checkdata) {

                $rowcount=$this->vehicledistance->rowcountvehicledistance($project,$vehicle_type);
                if ($rowcount>1) {
                 $result['startinput']='readonly';
                }

                
                $result['btnText'] = "Update";
                $result['btnTextLoader'] = "Updating...";
                $result['mode'] ='EDIT';
                $result['allinputreadonly']=$checkdata->is_readonly;
                $result['distancemstID'] =$checkdata->vehicle_distance_id;
                $result['vehicleData']=$this->vehicledistance->getVehicleDistanceDetailsBymstId($result['distancemstID']);
             //  pre($result['vehicleData']);
                 $page = 'dashboard/admin_dashboard/vehicle_distance/vehicle_distance_partial_view.php';
                
              }else{

                    //checkupper data
                 $checknextData=$this->vehicledistance->checknextdata($project,$vehicle_type,$shiftdate,$shift_code);


                 if ($checknextData=='N') {
                 
              
                   // last master data

                    $lastRowData=$this->vehicledistance->getLastRowVehicleDistanceMaster($project,$vehicle_type);
                  

                    if ($lastRowData) {
                              $result['startinput']='readonly';
                              $result['btnText'] = "Save";
                              $result['btnTextLoader'] = "Saving...";
                              $result['mode'] ='ADD';
                              $result['distancemstID'] ='0';
                      $vehicle_distance_id =$lastRowData->vehicle_distance_id;


                      $result['srattimetaken'] = 'End km of shift -'.$lastRowData->shift_code.' on '.date("d-m-Y", strtotime($lastRowData->shift_date));

                     $result['vehicleData']=$this->vehicledistance->getVehicleLastDistanceByMasterId($vehicle_distance_id,$project,$vehicle_type);
                       

                       // foreach ($result['vehicleData'] as $key => $value) {
                       //  // pre($value);
                       //   echo $value['vihicleData']->equipment_name;
                       //   echo $value['vihicleData']->equipment_id;
                       //   echo $value['lastDistance'];
                       // }

                         $page = 'dashboard/admin_dashboard/vehicle_distance/vehicle_distance_partial_view_with_previous_data.php';

                    }else{

                              $result['startinput']='';
                              $result['btnText'] = "Save";
                              $result['btnTextLoader'] = "Saving...";
                              $result['mode'] ='ADD';
                              $result['distancemstID'] ='0';


                              $where_vehicle = array(
                                                  'vehicle_master.project_id' => $project, 
                                                  'vehicle_master.vehicle_type_id' => $vehicle_type,
                                                  'vehicle_master.is_active' => 'Y'
                                                 
                                                ); 

                              $result['vehicleData']=$this->commondatamodel->getAllRecordWhere('vehicle_master',$where_vehicle);

                               $page = 'dashboard/admin_dashboard/vehicle_distance/vehicle_distance_partial_view.php';

                    }


                  }else{
                    $result['vehicleData']=[];
                    $result['error']= " Next date or next shift information already entered!";
                      $page = 'dashboard/admin_dashboard/vehicle_distance/error_view.php';
                  }




              }
            //  pre($result['vehicleData']);

             //  exit;
                        
          
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }



    /* save distance details data */



        public function vehicle_details_action() {

        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $json_response = array();
            $formData = $this->input->post('formDatas');
            parse_str($formData, $dataArry);
            
        
            $distancemstID = $dataArry['distancemstID'];
            $mode = $dataArry['mode'];
            $projectid =$dataArry['projectid'];
            $vehicle_type_id =$dataArry['vehicle_type_id'];
            $observerid =$dataArry['observerid'];
            $shiftdate = date("Y-m-d",strtotime($dataArry['shiftdate']));
            $shift_code =$dataArry['shift'];

            $distance_details_id =$dataArry['distance_details_id'];
            $equipment_id =$dataArry['equipment_id'];
            $start_km =$dataArry['start_km'];
            $start_hour =$dataArry['start_hour'];
            $end_km =$dataArry['end_km'];
            $end_hour =$dataArry['end_hour'];


           

        
            
           
            
            
            


            if($projectid!="0" && $vehicle_type_id!="" && $shift_code!="")
            {
    
                
                
                if($distancemstID>0 && $mode=="EDIT")
                {
                    /*  EDIT MODE
                     *  -----------------
                    */

                            /* update detail data*/
                    for ($i=0; $i < count($equipment_id); $i++) { 


                         $_upd_dist_vehicle_dtl = array( 
                                                    'start_km' => $start_km[$i],
                                                    'start_time' => $start_hour[$i],
                                                    'end_km' => $end_km[$i], 
                                                    'end_time' => $end_hour[$i], 
                                                   );
                          /* update vehicle distance details */
                       $update=$this->vehicledistance->updateVehicleDistancrDetails($_upd_dist_vehicle_dtl,$distance_details_id[$i]);


                          $dist_audit_repor_dtl = array(
                                                    'distance_master_id' => $distancemstID, 
                                                    'distance_details_id' => $distance_details_id[$i],
                                                    'observer_id' => $observerid, 
                                                    'equipment_id' => $equipment_id[$i], 
                                                    'shift_date' => $shiftdate, 
                                                    'shift_code' => $shift_code, 
                                                    'start_km' => $start_km[$i],
                                                    'start_time' => $start_hour[$i], 
                                                    'end_km' => $end_km[$i], 
                                                    'end_time' => $end_hour[$i], 
                                                    'entry_date' => date('Y-m-d H:i'), 
                                                   );

                           /* insert into audit_report_vehicle_distance to track observer */
                           $insertData=$this->commondatamodel->insertSingleTableData('audit_report_vehicle_distance',$dist_audit_repor_dtl);



                      
                    }



                    

                  
                    
                    
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

                    //set readonly all before insert new data

                    $readonly_arr = array('is_readonly' => 'Y' );

                    $update = $this->commondatamodel->updateSingleTableData('vehicle_distance_master',$readonly_arr,[]);

                    /* insert into vehicle distance master */

                    $arr_vehicle_dist_mst = array(
                                                    'project_id' => $projectid,
                                                    'observer_id' => $observerid,
                                                    'vehicle_type_id' => $vehicle_type_id,
                                                    'shift_date' => $shiftdate,
                                                    'shift_code' => $shift_code,
                                                    'entry_date' => date('Y-m-d h:i'),
                                                 );

                     $insert_mst_id=$this->commondatamodel->insertSingleTableData('vehicle_distance_master',$arr_vehicle_dist_mst);


                   

                   
                     /* insert detail data*/
                    for ($i=0; $i < count($equipment_id); $i++) { 


                         $dist_vehicle_dtl = array(
                                                    'distance_master_id' => $insert_mst_id, 
                                                    'equipment_id' => $equipment_id[$i], 
                                                    'shift_date' => $shiftdate, 
                                                    'shift_code' => $shift_code, 
                                                    'start_km' => $start_km[$i], 
                                                    'start_time' => $start_hour[$i],
                                                    'end_km' => $end_km[$i], 
                                                    'end_time' => $end_hour[$i], 
                                                   );
                          /* insert into vehicle distance details */
                         $insert_dtl_id=$this->commondatamodel->insertSingleTableData('vehicle_distance_details',$dist_vehicle_dtl);


                          $dist_audit_repor_dtl = array(
                                                    'distance_master_id' => $insert_mst_id, 
                                                    'distance_details_id' => $insert_dtl_id,
                                                    'observer_id' => $observerid, 
                                                    'equipment_id' => $equipment_id[$i], 
                                                    'shift_date' => $shiftdate, 
                                                    'shift_code' => $shift_code, 
                                                    'start_km' => $start_km[$i], 
                                                    'start_time' => $start_hour[$i],
                                                    'end_km' => $end_km[$i], 
                                                    'end_time' => $end_hour[$i],
                                                    'entry_date' => date('Y-m-d H:i'), 
                                                   );

                           /* insert into audit_report_vehicle_distance to track observer */
                           $insertData=$this->commondatamodel->insertSingleTableData('audit_report_vehicle_distance',$dist_audit_repor_dtl);



                      
                    }



            
               
                    

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


function checkEmpty($val){
  if ($val=='') {
    return NULL;
  }else{
    return $val;
  }
}



/* ----------------------------- vehicle distance report--------------------------------*/

    public function distancereport()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {   $result = [];            
            $page = 'dashboard/admin_dashboard/reports/vehicle_distance/vehicle_distance_report_view';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
          
            $result['vehicleType'] = $this->commondatamodel->getAllDropdownData("vehicle_type");
          
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }




       /* vehicle Distance Report Data by project and shift date */   
    public function vehicleDistanceReportData()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        { 
            $result =[];
            $shiftdate=$this->input->post('shiftdate');
           

            if($shiftdate!=""){
                $shiftdate = str_replace('/', '-', $shiftdate);
                $shiftdate = date("Y-m-d",strtotime($shiftdate));
             
             }
             else{
                 $shiftdate = NULL;
               
             }


 
           $project=$this->input->post('sel_project');
           $vehicle_type=$this->input->post('vehicle_type');
           $reoprtType='Distance';
           $where_type = array('vehicle_type.vehicle_type_id' => $vehicle_type);

            $vehicleTypeData=$this->commondatamodel->getSingleRowByWhereCls('vehicle_type',$where_type);

            $result['vehicle'] = $vehicleTypeData->vehicle_type;
           

             $result['shiftList'] = $this->commondatamodel->getAllDropdownData("shift_master");
            $result['distanceReport']=$this->vehicledistance->getVehicleDistanceReport($shiftdate,$project,$vehicle_type);
           

           // pre($result['distanceReport']);

            // foreach ($result['distanceReport'] as $key => $value) {
              
            //     echo $value['distanceMasterData']->equipment_name;
            //     foreach ($value['shiftType'] as $shifttype) {
                  
            //      pre($shifttype);
                 
                 
            //     }

            // }

            // exit;
           


            $result['shift']=$this->commondatamodel->getAllDropdownData('shift_master');
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['distanceReportProject']="Vehicle Distance Report For ".$projectName->project_nickname;
            }else {
                $result['distanceReportProject']="Vehicle Distance Report";
            }
           
    
            $page = 'dashboard/admin_dashboard/reports/vehicle_distance/vehicle_distance_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }


} // end of class
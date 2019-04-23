<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Breakdown extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('mastermodel','mastermodel',TRUE);
       $this->load->model('Breakdown_model','breakdown',TRUE);
    }

	
	public function index(){
		$session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/breakdown/breakdown_list';

            $today=date("Y-m-d");
            $result['breakDownList']=$this->breakdown->getBreakdownList($today);

            $header = "";

            // pre($result['breakDownList']);
            // exit;

            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }


        public function history(){
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $page = 'dashboard/admin_dashboard/breakdown/breakdown_history_list';

            $today=date("Y-m-d");
            $result['breakDownHistoryList']=$this->breakdown->getBreakdownListHistory($today);

            $header = "";

            // pre($result['breakDownList']);
            // exit;

            createbody_method($result,$page,$header,$session);

        }else{
            redirect('login','refresh');
        }
    }


        public function addBreakdown(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            if($this->uri->rsegment(3) == NULL)
            {
                $result['mode'] = "ADD";
                $result['btnText'] = "Save";
                $result['btnTextLoader'] = "Saving...";
                $breakdownID = 0;
                $result['breakdownID'] = $breakdownID;
                $result['breakdownEditdata'] = [];
                
                
                //getAllRecordWhereOrderBy($table,$where,$orderby)
                
                
            
            }
            else
            {
                $result['mode'] = "EDIT";
                $result['btnText'] = "Save";
                $result['btnTextLoader'] = "Saving...";
                $breakdownID = $this->uri->segment(3);
                $result['breakdownID'] = $breakdownID;
                


                // getSingleRowByWhereCls(tablename,where params)
                 $result['breakdownEditdata'] = $this->breakdown->getBreakdownDataById($breakdownID); 
                  //pre($result['breakdownEditdata']);exit;
                
            }

              $result['breakdowncauseList'] = $this->commondatamodel->getAllDropdownData('breakdown_cause_master');    

            $header = "";
             $page = 'dashboard/admin_dashboard/breakdown/breakdown_add_edit';
            createbody_method($result, $page, $header,$session);
        }
        else
        {
            redirect('login','refresh');
        }
        

    }



        public function breakdown_action() {

        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $json_response = array();
            $formData = $this->input->post('formDatas');
            parse_str($formData, $dataArry);
            

            
        
            $breakdownID = trim(htmlspecialchars($dataArry['breakdownID']));
            $mode = trim(htmlspecialchars($dataArry['mode']));
            $start_time = date ('H:i',strtotime($dataArry['start_time']));
            $end_time =  date ('H:i',strtotime($dataArry['end_time']));
            $breakdown_cause = trim(htmlspecialchars($dataArry['breakdown_cause']));
            $narration = trim(htmlspecialchars($dataArry['narration']));

          

            $resolvedate=$dataArry['resolvedate'];
            
            if($resolvedate!=""){
                $resolvedate = str_replace('/', '-', $resolvedate);
                $resolvedate = date("Y-m-d",strtotime($resolvedate));
             }
             else{
                 $resolvedate = NULL;
             }

           
            


            if($start_time!="" && $end_time!="")
            {
    
                
                
                if($breakdownID>0 && $mode=="EDIT")
                {
                    /*  EDIT MODE
                     *  -----------------
                    */

                    $upd_where = array('breakdown.breakdown_id' =>$breakdownID);

                    $upd_array = array(
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'resolve_date' => $resolvedate,
                        'narration' => $narration,
                        'breakdown_cause_id' => $breakdown_cause,
                        'is_approved' => 'Y',
                     );

                        $update = $this->commondatamodel->updateSingleTableData('breakdown',$upd_array,$upd_where);
                    
                    
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

                   
            
                    $insertData =1;
                    

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



        /* get  getBreakdownlistbydate */
public function getBreakdownlistbydate()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
           
          

              $breakdowndate = $this->input->post('breakdowndate');

                if($breakdowndate!=""){
                $breakdowndate = str_replace('/', '-', $breakdowndate);
                $breakdowndate = date("Y-m-d",strtotime($breakdowndate));
             }
             else{
                 $breakdowndate = NULL;
             }
            
    
           
            $result['breakDownList']=$this->breakdown->getBreakdownList($breakdowndate);


            // pre($result['breakDownList']);

            // exit;
             

            $page = 'dashboard/admin_dashboard/breakdown/breakdown_partial_view';
            //$partial_view = $this->load->view($page,$result);
            echo $this->load->view($page, $result, TRUE);
            //echo $partial_view;
        }
        else
        {
            redirect('login','refresh');
        }
    }


            /* get  getBreakdownHistorylistbydate */
public function getBreakdownHistorylistbydate()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
           
            $breakhistorydate = $this->input->post('breakhistorydate');

                if($breakhistorydate!=""){
                $breakhistorydate = str_replace('/', '-', $breakhistorydate);
                $breakhistorydate = date("Y-m-d",strtotime($breakhistorydate));
             }
             else{
                 $breakhistorydate = NULL;
             }
            
    
           
            $result['breakDownHistoryList']=$this->breakdown->getBreakdownListHistory($breakhistorydate);


            // pre($result['breakDownList']);

            // exit;
             

            $page = 'dashboard/admin_dashboard/breakdown/breakdown_partial_view_history.php';
            //$partial_view = $this->load->view($page,$result);
            echo $this->load->view($page, $result, TRUE);
            //echo $partial_view;
        }
        else
        {
            redirect('login','refresh');
        }
    }


// change breakdown status
        public function setBreakdownStatus(){
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $updID = trim($this->input->post('uid'));
            $setstatus = trim($this->input->post('setstatus'));
            
            $update_array  = array(
                "is_approved" => $setstatus,
                "start_time" => NULL,
                "end_time" => NULL,
                "is_approved" => NULL,
                "breakdown_cause_id" => NULL,
                "narration" => NULL,
                );
                
            $where = array(
                "breakdown.breakdown_id" => $updID
                );
            
            
        
            $update = $this->commondatamodel->updateSingleTableData('breakdown',$update_array,$where);
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


/* *********************************** Break Down Cause ************************************* */

        public function addBreakdownCause(){
        
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            if($this->uri->rsegment(3) == NULL)
            {
                $result['mode'] = "ADD";
                $result['btnText'] = "Save";
                $result['btnTextLoader'] = "Saving...";
                $breakdowncauseID = 0;
                $result['breakdowncauseID'] = $breakdowncauseID;
                $result['breakdowncauseEditdata'] = [];
                
                
                //getAllRecordWhereOrderBy($table,$where,$orderby)
                
                
            
            }
            else
            {
                $result['mode'] = "EDIT";
                $result['btnText'] = "Update";
                $result['btnTextLoader'] = "Saving...";
                $breakdowncauseID = $this->uri->segment(3);
                $result['breakdowncauseID'] = $breakdowncauseID;
                
                $where = array('breakdown_cause_master.id' => $breakdowncauseID );

                // getSingleRowByWhereCls(tablename,where params)
                 $result['breakdowncauseEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('breakdown_cause_master',$where); 
                  //pre($result['breakdowncauseEditdata']);exit;
                
            }

              

            $header = "";
             $page = 'dashboard/admin_dashboard/master/breakdown_cause/breakdown_cause_add_edit.php';
            createbody_method($result, $page, $header,$session);
        }
        else
        {
            redirect('login','refresh');
        }
        

    }


    public function breakdowncause_action() {

        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $json_response = array();
            $formData = $this->input->post('formDatas');
            parse_str($formData, $dataArry);
            

            
        
            $breakdowncauseID = trim(htmlspecialchars($dataArry['breakdowncauseID']));
            $mode = trim(htmlspecialchars($dataArry['mode']));
            $breakdowncause = trim(htmlspecialchars($dataArry['breakdowncause']));


            if($breakdowncause!="")
            {
    
                
                
                if($breakdowncauseID>0 && $mode=="EDIT")
                {
                    /*  EDIT MODE
                     *  -----------------
                    */

                    $upd_where = array('breakdown_cause_master.id' =>$breakdowncauseID);

                    $upd_array = array(
                        'cause' => $breakdowncause
                       
                     );

                        $update = $this->commondatamodel->updateSingleTableData('breakdown_cause_master',$upd_array,$upd_where);
                    
                    
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

                   
            
                    $insert_array = array(
                                             'cause' => $breakdowncause,
                                             'is_active' => 'Y',
                                         );
            
                    $insertData = $this->commondatamodel->insertSingleTableData('breakdown_cause_master',$insert_array);
                    

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


/* change breakdown cause status */


    public function setBreakdownCauseStatus(){
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            $updID = trim($this->input->post('uid'));
            $setstatus = trim($this->input->post('setstatus'));
            
            $update_array  = array(
                "is_active" => $setstatus
                );
                
            $where = array(
                "breakdown_cause_master.id" => $updID
                );
            
            
        
            $update = $this->commondatamodel->updateSingleTableData('breakdown_cause_master',$update_array,$where);
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


/************************************ End of Breakdown cause ******************************/

}// end of class
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Excavatoleadliftreport extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Excavatoleadliftreport_model','excavatoleadlift',TRUE);

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
            $page = 'dashboard/admin_dashboard/reports/excaveror_lead_lift/excaveror_lead_lift_report';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
           // $result['trackingList']=$this->trackingmodel->getTrackingDetailsList();
        
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }


    public function excavatorLeadLiftReport()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        { 
            $result =[];
            $fromdate=$this->input->post('fromDate');
            $todate=$this->input->post('toDate');

            if($fromdate!=""){
                $fromdate = str_replace('/', '-', $fromdate);
                $fromDate = date("Y-m-d",strtotime($fromdate));
               
             }
             else{
                 $fromDate = NULL;
               
             }

             $result['period']='('.date("d-m-Y",strtotime($fromdate)).')';
             
 
           $project=$this->input->post('project');
           $reoprtType='Trip';
           

            $materialCount=$this->commondatamodel->rowcount('material_type');
            $shiftCount=$this->commondatamodel->rowcount('shift_master');
            $result['excawiseLeadLift']=$this->excavatoleadlift->getExcavatorLeadLiftReport($fromDate,$project,$reoprtType);
            $result['materialList']=$this->excavatoleadlift->getMererialTypeList($project);
           // pre($result['excawiseLeadLift']);
           


            $result['shift']=$this->commondatamodel->getAllDropdownData('shift_master');
            $result['lead_lift_report']=$this->commondatamodel->getAllDropdownData('lead_lift_report');

            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['tripReportProject']="Excavator Lead and Lift Report For ".$projectName->project_nickname;
            }else {
                $result['tripReportProject']="Excavator Lead and Lift Report";
            }
            
/*
      foreach ($result['excawiseLeadLift'] as $excawiseLeadLift) {
        
                foreach ($excawiseLeadLift['excavatorList'] as $excavatorList) {
                 //  pre($excavatorList['LeadLiftColumn']);
                        echo '<br>'. $excavatorList['excavator']->equipment_name;
                        echo "<br>-------------------------------<br>";
                       foreach ($excavatorList['LeadLiftColumn'] as $leadliftcolumn) {

                            // pre($leadliftcolumn['materialType']);
                            foreach ($leadliftcolumn['materialType'] as $meterialtype) {
                             // echo '<br>'.$meterialtype['material'];
                              //  pre($meterialtype);
                            }
                       }
                      

                }
        } */

                 // exit;      
            $page = 'dashboard/admin_dashboard/reports/excaveror_lead_lift/excaveror_lead_lift_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }





} // end of class

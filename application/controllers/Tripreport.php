<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Tripreport extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('tripreportmodel','tripreportmodel',TRUE);

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
            $page = 'dashboard/admin_dashboard/reports/shift_working_report/trip_report';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
           // $result['trackingList']=$this->trackingmodel->getTrackingDetailsList();
          
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }


    public function Tripreport()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        { 
            $result =[];
            $fromdate=$this->input->post('fromDate');
            $todate=$this->input->post('toDate');

            if($fromdate!="" && $todate!=""){
                $fromdate = str_replace('/', '-', $fromdate);
                $fromDate = date("Y-m-d",strtotime($fromdate));
                $todate = str_replace('/', '-', $todate);
                $toDate = date("Y-m-d",strtotime($todate));
             }
             else{
                 $fromDate = NULL;
                 $toDate = NULL;
             }

            $project=$this->input->post('project');
           

            $materialCount=$this->commondatamodel->rowcount('material_type');
            $shiftCount=$this->commondatamodel->rowcount('shift_master');
            $result['tripReport']=$this->tripreportmodel->getTripReport($fromDate,$toDate,$project);
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['tripReportProject']="Trip Report For ".$projectName->project_nickname;
            }else {
                $result['tripReportProject']="Trip Report";
            }
            

        //print_r($result['tripReportProject']);exit;

                        
            $page = 'dashboard/admin_dashboard/reports/shift_working_report/trip_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }










}/* end of class */
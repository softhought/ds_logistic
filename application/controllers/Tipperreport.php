<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Tipperreport extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Tipperreport_model','tipperreport',TRUE);

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
            $page = 'dashboard/admin_dashboard/reports/tipper_wise_trip/tipper_report';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
           // $result['trackingList']=$this->trackingmodel->getTrackingDetailsList();
          
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }

   /* Tipper wise Trip Report */  
    public function tipperWisereport()
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
           $reoprtType='Trip';
           

            $materialCount=$this->commondatamodel->rowcount('material_type');
            $shiftCount=$this->commondatamodel->rowcount('shift_master');
            $result['tipperawiseReport']=$this->tipperreport->getTipperTripReport($fromDate,$toDate,$project,$reoprtType);
            $result['materialList']=$this->tipperreport->getMererialTypeList($project);

           // pre($result['tipperawiseReport']);
           


            $result['shift']=$this->commondatamodel->getAllDropdownData('shift_master');
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['tripReportProject']="Tripper wise Report For ".$projectName->project_nickname;
            }else {
                $result['tripReportProject']="Tripper wise Report";
            }
            
    
            $page = 'dashboard/admin_dashboard/reports/tipper_wise_trip/tipper_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }

    public function quantityview()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {   $result = [];            
            $page = 'dashboard/admin_dashboard/reports/tipper_wise_trip/quantity_tipper_report';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
           
          
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }

   /* Tipper wise Quantity Report */   
    public function tipperWiseQuantityreport()
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
           $reoprtType='Quantity';
           

            $materialCount=$this->commondatamodel->rowcount('material_type');
            $shiftCount=$this->commondatamodel->rowcount('shift_master');
            $result['tipperawiseReport']=$this->tipperreport->getTipperTripReport($fromDate,$toDate,$project,$reoprtType);
            $result['materialList']=$this->tipperreport->getMererialTypeList($project);

           // pre($result['tipperawiseReport']);
           


            $result['shift']=$this->commondatamodel->getAllDropdownData('shift_master');
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['quantityReportProject']="Tripper wise Quantity Report For ".$projectName->project_nickname;
            }else {
                $result['quantityReportProject']="Tripper wise Quantity Report";
            }
            
    
            $page = 'dashboard/admin_dashboard/reports/tipper_wise_trip/quantity_tipper_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }









}/* end of class */
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Excavatorreport extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Excavatorreport_model','excavatorreport',TRUE);

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
            $page = 'dashboard/admin_dashboard/reports/excavator_wise_trip/excavaror_report';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
           // $result['trackingList']=$this->trackingmodel->getTrackingDetailsList();
          
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }


    public function excavatorWisereport()
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
            $result['excawiseReport']=$this->excavatorreport->getExcavatorTripReport($fromDate,$toDate,$project,$reoprtType);
            $result['materialList']=$this->excavatorreport->getMererialTypeList($project);
           


            $result['shift']=$this->commondatamodel->getAllDropdownData('shift_master');
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['tripReportProject']="Excavator wise Report For ".$projectName->project_nickname;
            }else {
                $result['tripReportProject']="Excavator wise Report";
            }
            

   /*     foreach ($result['excawiseReport'] as $excawisereport) {
         //  pre($excawisereport['materialType']);
                foreach ($excawisereport['materialType'] as $materialtype) {
                     // pre($materialtype);

                       foreach($materialtype['shiftType'] as $shiftType) {
                      //     pre($shiftType['shiftTripCount']);
                            echo $shiftType['shiftTripCount'];
                        

                       }


                }
        } */

                //  exit;      
            $page = 'dashboard/admin_dashboard/reports/excavator_wise_trip/excavaror_report_partial_view';
           
           
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
            $page = 'dashboard/admin_dashboard/reports/excavator_wise_trip/quantity_excavaror_report.php';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
           
          
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }




    public function excavatorWiseQuantityReport()
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
            $result['excawiseReport']=$this->excavatorreport->getExcavatorTripReport($fromDate,$toDate,$project,$reoprtType);
            $result['materialList']=$this->excavatorreport->getMererialTypeList($project);
           


            $result['shift']=$this->commondatamodel->getAllDropdownData('shift_master');
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['quantityReportProject']="Excavator wise  Quantity Report For ".$projectName->project_nickname;
            }else {
                $result['quantityReportProject']="Excavator wise Quantity Report";
            }
            

   /*     foreach ($result['excawiseReport'] as $excawisereport) {
         //  pre($excawisereport['materialType']);
                foreach ($excawisereport['materialType'] as $materialtype) {
                     // pre($materialtype);

                       foreach($materialtype['shiftType'] as $shiftType) {
                      //     pre($shiftType['shiftTripCount']);
                            echo $shiftType['shiftTripCount'];
                        

                       }


                }
        } */

                //  exit;      
            $page = 'dashboard/admin_dashboard/reports/excavator_wise_trip/quantity_excavaror_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }


}/* end of class */
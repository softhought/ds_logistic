<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dumpreport extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Dumpreportmodel','dumpreport',TRUE);

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
            $page = 'dashboard/admin_dashboard/reports/dump_report/tipper_dump_report';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
           // $result['trackingList']=$this->trackingmodel->getTrackingDetailsList();
          
            $header = "";
           
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }



 /* get  district by state*/

public function getTipperByProject()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {
            
            $project = $this->input->post('project');
           
            if($project!='0'){

              $where_vehicle = array(
                                    'vehicle_master.project_id' => $project, 
                                    'vehicle_master.vehicle_type_id' => 2, // Tipper
                                    'vehicle_master.is_active' => 'Y'
                                   
                                  ); 

            $result['tipperData']=$this->commondatamodel->getAllRecordWhere('vehicle_master',$where_vehicle);

            }else{
               $result['tipperData']=[];
              

           }
           

             // pre($result['tipperData']);

             // exit;
             
            $page = 'dashboard/admin_dashboard/reports/dump_report/tipper_view';
          
            //$partial_view = $this->load->view($page,$result);
            echo $this->load->view($page, $result, TRUE);
            //echo $partial_view;
        }
        else
        {
            redirect('login','refresh');
        }
    }


 public function tipperdumpreport()
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
            $sel_tipper=$this->input->post('sel_tipper');
           
            $result['period']='('.date("d-m-Y",strtotime($fromdate)).' to '.date("d-m-Y",strtotime($todate)).')';
            
            $result['reportData']=$this->dumpreport->getTripReport($fromDate,$toDate,$project,$sel_tipper);
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['tipperdumpReport']="Tipper Performance Report For ".$projectName->project_nickname;
            }else {
               // $result['tipperdumpReport']="Tipper Travelling Trip Report";
                $result['tipperdumpReport']="Tipper Travelling Trip Report";
            }
            

      //  print_r($result['reportData']);

                        
            $page = 'dashboard/admin_dashboard/reports/dump_report/tipper_dump_report_partial_view.php';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }

}// end of class
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Syncreport extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('syncreport_model','syncreport',TRUE);

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
            $page = 'dashboard/admin_dashboard/reports/sync_report/sync_report_view.php';
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
           

            $where_vehicle = array(
                                    'vehicle_master.project_id' => $project, 
                                    'vehicle_master.vehicle_type_id' => 2, //2=TIPPER
                                    'vehicle_master.is_active' => 'Y'
                                   
                                  ); 

        if($project!='0'){
 
           $result['tipperList']=$this->commondatamodel->getAllRecordWhere('vehicle_master',$where_vehicle); 

            }else{
               $result['tipperList']=[];
              

           }
           

           /*  pre($result['tipperList']);

             exit;
             */
             $page = 'dashboard/admin_dashboard/reports/sync_report/tipper_view.php';
          
            //$partial_view = $this->load->view($page,$result);
            echo $this->load->view($page, $result, TRUE);
            //echo $partial_view;
        }
        else
        {
            redirect('login','refresh');
        }
    }


       /* Tipper sqnc Report */  
    public function tipperWiseSyncreport()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        { 
            $result =[];
            $sel_date=$this->input->post('sel_date');
            $equipment_id=$this->input->post('sel_tipper');
            

            if($sel_date!=""){
                $sel_date = str_replace('/', '-', $sel_date);
                $sel_date = date("Y-m-d",strtotime($sel_date));
              
             }
             else{
                 $sel_date = NULL;
                
             }
 
           $project=$this->input->post('project');
           $reoprtType='Trip';
           
           $result['period']='('.date("d-m-Y",strtotime($sel_date)).')'; 

            $result['syncReport']=$this->syncreport->getTipperSyncReport($project,$sel_date,$equipment_id);
          

          //  pre($result['syncReport']);
           


         
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['tripReportProject']="Tripper wise synchronization report For ".$projectName->project_nickname;
            }else {
                $result['tripReportProject']="Tripper wise synchronization report";
            }
            
    
            $page = 'dashboard/admin_dashboard/reports/sync_report/sync_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }

}// end of class
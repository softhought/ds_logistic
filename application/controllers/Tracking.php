<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Tracking extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('trackingmodel','trackingmodel',TRUE);

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
            $page = 'dashboard/admin_dashboard/tracking/tracking_list';
            $result['projectList'] = $this->commondatamodel->getAllDropdownData("project_master");
           // $result['trackingList']=$this->trackingmodel->getTrackingDetailsList();
          
            $header = "";
            
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }


    public function getTrackingList() {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {     
            $formData = $this->input->post('formDataserialize');
            parse_str($formData, $dataArry);

            
             $fromDt=$dataArry['fromDate'];
            
            if($fromDt!=""){
                $fromDt = str_replace('/', '-', $fromDt);
                $fromDt = date("Y-m-d",strtotime($fromDt));
             }
             else{
                 $fromDt = NULL;
             }

         

             $toDt=$dataArry['toDate'];
            
            if($toDt!=""){
                $toDt = str_replace('/', '-', $toDt);
                $toDt = date("Y-m-d",strtotime($toDt));
             }
             else{
                 $toDt = NULL;
             }



            $page = 'dashboard/admin_dashboard/tracking/tracking_list';

            if($dataArry['project']!=0){
                $projectid=$dataArry['project'];
                $result['trackingList']=$this->trackingmodel->getTrackingDetailsListByProject($projectid,$fromDt,$toDt);
               
            }else{
                $result['trackingList']=$this->trackingmodel->getTrackingDetailsList($fromDt,$toDt);
            }
          
        #  pre($result['trackingList']);
            
            
          
          //  $result['trackingList']=$this->trackingmodel->getTrackingDetailsList();
            $display = $this->load->view("dashboard/admin_dashboard/tracking/tracking_list_view",$result,TRUE);
            echo $display;
 
         // echo "Hello";
        }
        else{
            redirect('login','refresh');
        }
    }


}/* end of class */

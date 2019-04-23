<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Excavatorassign extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Excavatorassignmodel','excavatorassign',TRUE);
      
    }

    public function index()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {   $result = [];            
            $page = 'dashboard/admin_dashboard/excavator_assign/excavator_assign_list.php';
           
            $result['excavatorassignList'] = $this->excavatorassign->getExcavatorAssign();
           // $result['trackingList']=$this->trackingmodel->getTrackingDetailsList();
          
            $header = "";
            
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }

    public function tripexcavatormap()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {   $result = [];            
            $page = 'dashboard/admin_dashboard/excavator_assign/trip_excavator_map_list.php';
           
            $result['tripexcavatorList'] = $this->excavatorassign->getTripExcavatorList();
         
          
            $header = "";
            
            createbody_method($result, $page, $header, $session);
        }
        else{
            redirect('login','refresh');
        }
    }





}/* end of class */

<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Delayreport extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Delayreport_model','delayreport',TRUE);

        ini_set('memory_limit', '960M');
        ini_set('post_max_size', '640M');
        ini_set('upload_max_filesize', '640M');
        ini_set('max_execution_time', 900);
    }


// tipper delay
    public function index()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {   $result = [];            
            $page = 'dashboard/admin_dashboard/reports/delay_report/tipper_delay_report_view.php';
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


    // excavator delay
    public function excavator()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        {   $result = [];            
            $page = 'dashboard/admin_dashboard/reports/delay_report/excavator_delay_report_view.php';
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


           /* tipper Delay report Data */  
    public function tipperDelayreportData()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        { 
            $result =[];
            $shift_date=$this->input->post('shiftdate');
           

            if($shift_date!=""){
                $shift_date = str_replace('/', '-', $shift_date);
                $shift_date = date("Y-m-d",strtotime($shift_date));
               
             }
             else{
                 $shift_date = NULL;
                
             }
 
           $project=$this->input->post('sel_project');
           $reoprtType='TipperDelay';
           
             $result['period']='('.date("d-m-Y",strtotime($shift_date)).')';
         
            $result['tipperDelayReport']=$this->delayreport->getTipperDelay($shift_date,$project);


//             echo $from_time = strtotime("06:00");
// echo '<br>'.$to_time = strtotime("07:58");
// echo '<br>'.round(floor($to_time - $from_time) / 60,2). " minute";
         

          // pre($result['tipperDelayReport']);exit;
           


            
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['tripReportProject']="Tipper Delay Report For ".$projectName->project_nickname;
            }else {
                $result['tripReportProject']="Tipper Delay Report";
            }
            
    
            $page = 'dashboard/admin_dashboard/reports/delay_report/tipper_delay_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }



           /* excavator Delay report Data */  
    public function excavatorDelayreportData()
    {
        $session = $this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
        { 
            $result =[];
            $shift_date=$this->input->post('shiftdate');
           

            if($shift_date!=""){
                $shift_date = str_replace('/', '-', $shift_date);
                $shift_date = date("Y-m-d",strtotime($shift_date));
               
             }
             else{
                 $shift_date = NULL;
                
             }
 
           $project=$this->input->post('sel_project');
           $reoprtType='ExcavatorDelay';
           
           $result['period']='('.date("d-m-Y",strtotime($shift_date)).')';
         
            $result['excavatorDelayReport']=$this->delayreport->getExcavatorDelay($shift_date,$project);
         

          //  pre($result['excavatorDelayReport']);exit;
           


            
            
            if ($project!=0) {
                $where=[
                    "project_id"=>$project
                ];
                $projectName=$this->commondatamodel->getSingleRowByWhereCls('project_master',$where);
               $result['tripReportProject']="Excavator Delay Report For ".$projectName->project_nickname;
            }else {
                $result['tripReportProject']="Excavator Delay Report";
            }
            
    
            $page = 'dashboard/admin_dashboard/reports/delay_report/excavator_delay_report_partial_view';
           
           
            $display = $this->load->view($page,$result,TRUE);
            echo $display;
        }
        else{
            redirect('login','refresh');
        }
    }



function minutes($time){
$time = explode(':', $time);
return ($time[0]*60) + ($time[1]) + ($time[2]/60);
}

}// end of class
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Import extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Import_model','import',TRUE);

    }

	
	public function index(){
        echo "Driver tracking list";
         $projectid=1;
         $result['driverTrackingList']=$this->import->getHistoryByProject($projectid);



         foreach ($result['driverTrackingList'] as  $value) {
             echo "<br>Tid: ".$value->track_history_id;
             echo "<br> Mt: ".$value->material_type;
             echo "<br> PM: ".$value->project_material_id;
             echo "<br> Pid: ".$value->project_id;
            
             if ($value->material_type!='') {
               $result['projectMaterial']=$this->import->getProjectMaterialId($value->project_id,$value->material_type);
             echo "<br>".$project_mat_id=$result['projectMaterial']->project_material_id;
                $upd_array = array('driver_tracking_history.project_material_id' =>$project_mat_id);
                $update_where = array('driver_tracking_history.track_history_id' =>$value->track_history_id );
                $this->commondatamodel->updateSingleTableData('driver_tracking_history',$upd_array,$update_where);
             }
             
             echo "<br>--------------------------------------";
         }

       //pre($result['driverTrackingList']);
	
    }


} // end of class
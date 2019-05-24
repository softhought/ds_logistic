<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class syncreport_model extends CI_Model{


    public function getTipperSyncReport($project,$sel_date,$equipment_id)
    {
      $data=[];


        if ($equipment_id!=0) {
               $where = array(
                       
                        'vehicle_master.project_id' => $project,
                        'driver_tracking_history.tipper_equipment_id' => $equipment_id,
                        'DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d")' => $sel_date,
                      
              );
        }else{
          $where = array(
                       
                        'vehicle_master.project_id' => $project,
                        'DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d")' => $sel_date,
                      
              );

        }
     

      $query=$this->db->select('*')
                        ->from('driver_tracking_history')
                        ->join('vehicle_master','vehicle_master.equipment_id=driver_tracking_history.tipper_equipment_id','INNER')
                        ->where($where)
                        ->group_by('driver_tracking_history.tipper_equipment_id')
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
               // $data[] = $rows;

            $data[]=[
                        "tipperData"=>$rows,
                        "lastSync"=>$this->getTipperLastHistory($rows->equipment_id)
                      ];
 
            
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }



    /* get vehicle last distance */
    public function getTipperLastHistory($equipment_id)
    {
        $data = array();
        $where = array('driver_tracking_history.tipper_equipment_id' => $equipment_id );
        $this->db->select("*")
                ->from('driver_tracking_history')
                ->join('mobile_master','mobile_master.mobile_id=driver_tracking_history.mobile_id','INNER')
                ->where($where)
                ->order_by('driver_tracking_history.track_history_id',"desc")
                ->limit(1);
        $query = $this->db->get();
        
        //echo $this->db->last_query();
        
        if($query->num_rows()> 0)
        {
           $row = $query->row();
           return $data = $row;
             
        }
        else
        {
            return $data;
        }
    }


  }// end of model
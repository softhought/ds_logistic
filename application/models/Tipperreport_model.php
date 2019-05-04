<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tipperreport_model extends CI_Model{


    public function getTipperTripReport($fromDate,$toDate,$projectid=null,$reoprtType)
    {
      $data=[];

      $where = array(
                        'vehicle_type.vehicle_type' => 'TIPPER',
                        'vehicle_master.project_id' => $projectid,
                      
       );

      $query=$this->db->select('*')
                        ->from('vehicle_master')
                        ->join('vehicle_type','vehicle_type.vehicle_type_id=vehicle_master.vehicle_type_id','INNER')
                        ->where($where)
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
               // $data[] = $rows;

                $data[]=[
                  "tipperData"=>$rows,
                  "materialType"=>$this->getMererialByProject($fromDate,$toDate,$projectid,$rows->equipment_id,$reoprtType)
                ];
            
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }


     public function getMererialByProject($fromDate,$toDate,$projectid,$tipper_equipment_id,$reoprtType)
    {
      $data=[];

      $where = array(
                      'project_material_details.project_id' => $projectid,
                      
                     );

      $query=$this->db->select('project_material_details.*,material_type.material')
                        ->from('project_material_details')
                        ->join('material_type','material_type.material_type_id=project_material_details.material_type_id','INNER')
                        ->where($where)
                        ->order_by('material_type.material_type_id', 'asc')
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
              //  $data[] = $rows;
           $data[]=[
                  "materialTypeData"=>$rows,
                  "shiftType"=>$this->getShiftType($fromDate,$toDate,$rows->material,$rows->project_material_id,$projectid,$tipper_equipment_id,$reoprtType)
                ]; 
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }


        public function getShiftType($fromDate,$toDate,$material,$project_material_id,$projectid,$tipper_equipment_id,$reoprtType)
    {
      $data=[];

      $where = array(
                      'shift_master.is_active' => 'Y',
                      
                     );

      $query=$this->db->select('*')
                        ->from('shift_master')
                        ->where($where)
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
              //  $data[] = $rows;

              /*   $data[]=[
                        "shiftData"=>$rows,
                        "shiftTripCount"=>$this->getShiftWiseTripCount($fromDate,$toDate,$material,$project_material_id,$rows->shift_code,$projectid,$tipper_equipment_id)
                      ];*/

                if($reoprtType=='Quantity'){

                       $data[]=[
                        "shiftData"=>$rows,
                        "shiftTripQuantity"=>$this->getShiftWiseQuantity($fromDate,$toDate,$material,$project_material_id,$rows->shift_code,$projectid,$tipper_equipment_id)
                      ];

                }else{

                     $data[]=[
                        "shiftData"=>$rows,
                        "shiftTripCount"=>$this->getShiftWiseTripCount($fromDate,$toDate,$material,$project_material_id,$rows->shift_code,$projectid,$tipper_equipment_id)
                      ];

                } 
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }


// get shiftwise trip count  tipper
public function getShiftWiseTripCount($fromDate,$toDate,$material,$project_material_id,$shift_code,$projectid,$tipper_equipment_id){
 
       $count=0;

      $where = array(
                        'driver_tracking_history.tipper_equipment_id' => $tipper_equipment_id,
                        'driver_tracking_history.project_material_id' => $project_material_id,
                        'driver_tracking_history.shift_code' => $shift_code,
                        'project_material_details.project_id' => $projectid
       );

      $query=$this->db->select('
                          COUNT(*) AS tripcount
                          ')
                        ->from('driver_tracking_history')
                        ->join('project_material_details','project_material_details.project_material_id=driver_tracking_history.project_material_id','INNER')
                        ->where($where)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->get();
                        #q();

      if($query->num_rows()>0){
       
        $row = $query->row();
           return $count = $row->tripcount;
       
      }
      else
      {
        return $count;
      }

}


// tipper shift wise trip quantity

public function getShiftWiseQuantity($fromDate,$toDate,$material,$project_material_id,$shift_code,$projectid,$equipment_id){
 
       $qty=0;

      $where = array(
                        'driver_tracking_history.tipper_equipment_id' => $equipment_id,
                        'driver_tracking_history.project_material_id' => $project_material_id,
                        'driver_tracking_history.shift_code' => $shift_code,
                        'project_material_details.project_id' => $projectid
       );

      $query=$this->db->select('
                           IFNULL(SUM(IFNULL(tripper.capacity, 0)*IFNULL(project_material_details.conversation_factor, 0)),0) AS qty
                          ')
                        ->from('driver_tracking_history')
                        ->join('vehicle_master AS tripper','tripper.equipment_id=driver_tracking_history.tipper_equipment_id','INNER')
                        ->join('project_material_details','project_material_details.project_material_id=driver_tracking_history.project_material_id','INNER')
                        ->where($where)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->get();
                        #q();

      if($query->num_rows()>0){
       
        $row = $query->row();
           return $qty = number_format($row->qty,2);
       
      }
      else
      {
        return $count;
      }

}

    // only userd for material name for project
    public function getMererialTypeList($projectid)
    {
      $data=[];

      $where = array(
                      'project_material_details.project_id' => $projectid,
                      
                     );

      $query=$this->db->select('project_material_details.*,material_type.material')
                        ->from('project_material_details')
                        ->join('material_type','material_type.material_type_id=project_material_details.material_type_id','INNER')
                        ->where($where)
                        ->order_by('material_type.material_type_id', 'asc')
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
                $data[] = $rows;
         
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }



}
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excavatoleadliftreport_model extends CI_Model
{

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




    public function getExcavatorLeadLiftReport($fromDate,$project,$reoprtType)
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
           
              $data[]=[
                        "shift"=>$rows,
                        "excavatorList"=>$this->getLeadAgainstVehicleList($fromDate,$project,$reoprtType,$rows->shift_code)
                      ];
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }


    public function getLeadAgainstVehicleList($fromDate,$project,$reoprtType,$shift_code)
    {
      $data=[];

      $where = array(
                      'lead_against_vehicle.shift_code' => $shift_code,
                      'lead_against_vehicle.project_id' => $project,
                      'DATE_FORMAT(lead_against_vehicle.shift_date,"%Y-%m-%d")' => $fromDate
                      
                     );

      $query=$this->db->select('*')
                        ->from('lead_against_vehicle')
                        ->join('vehicle_master','vehicle_master.vehicle_id=lead_against_vehicle.vehicle_mst_id','INNER')
                        ->where($where)
                       // ->where('DATE_FORMAT(`lead_against_vehicle`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                       // ->where('DATE_FORMAT(`lead_against_vehicle`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->group_by('vehicle_master.vehicle_id') /* added on 08.06.2019*/
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
              $data[]=[
                        "excavator"=>$rows,
                        "LeadLiftColumn"=>$this->getLeadLiftColumn($fromDate,$project,$reoprtType,$shift_code,$rows->equipment_id)
                      ];

        
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }


    public function getLeadLiftColumn($fromDate,$project,$reoprtType,$shift_code,$equipment_id)
    {
      $data=[];


      $query=$this->db->select('*')
                        ->from('lead_lift_report')
                        ->get();
                        #q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
           
              $data[]=[
                        "LeadLiftColumnData"=>$rows,
                        "materialType"=>$this->getMererialByProject($fromDate,$project,$reoprtType,$shift_code,$equipment_id,$rows->column_type)
                      ];

        
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }



        public function getMererialByProject($fromDate,$project,$reoprtType,$shift_code,$equipment_id,$column_type)
    {
      $data=[];

      $where = array(
                      'project_material_details.project_id' => $project,
                      
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
                  "project_material_id"=>$rows->project_material_id,
                  "material_type_id"=>$rows->material_type_id,
                  "material"=>$rows->material,
                  "LeadData"=>$this->getLeadExcavatorAssign($fromDate,$project,$reoprtType,$shift_code,$equipment_id,$rows->project_material_id,$column_type)
                ]; 
           
        }
        return $data;
      }
      else
      {
        return $data;
      }
    }


    // get shiftwise trip count 
public function getLeadExcavatorAssign($fromDate,$project,$reoprtType,$shift_code,$equipment_id,$project_material_id,$column_type){

 
       $count=0;

      $where = array(
                        'vehicle_master.equipment_id' => $equipment_id,
                        'lead_against_vehicle.shift_code' => $shift_code,
                        'lead_against_vehicle.project_material_id' => $project_material_id,
                        'DATE_FORMAT(lead_against_vehicle.shift_date,"%Y-%m-%d")' => $fromDate
                       

       );
      if ($column_type=='Lead') {

                  $query=$this->db->select('
                         IFNULL(SUM(lead_against_vehicle.lead),0) AS lead 
                          ')
                        ->from('lead_against_vehicle')
                        ->join('vehicle_master','vehicle_master.vehicle_id=lead_against_vehicle.vehicle_mst_id','INNER')
                        ->where($where)
                       // ->where('DATE_FORMAT(`lead_against_vehicle`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                       // ->where('DATE_FORMAT(`lead_against_vehicle`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->get();

       
      }else{

             $query=$this->db->select('
                         IFNULL((SUM(lead_against_vehicle.rl_in_dump)- SUM(lead_against_vehicle.rl_in_face)),0) AS lift
                          ')
                        ->from('lead_against_vehicle')
                        ->join('vehicle_master','vehicle_master.vehicle_id=lead_against_vehicle.vehicle_mst_id','INNER')
                        ->where($where)
                       // ->where('DATE_FORMAT(`lead_against_vehicle`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                       // ->where('DATE_FORMAT(`lead_against_vehicle`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->get();

      }


                      
                        #q();

      if($query->num_rows()>0){
       
        $row = $query->row();
             if ($column_type=='Lead') {
               return $count = $row->lead;
             }else{
               return $count = $row->lift;
             }
       
      }
      else
      {
        return $count;
      }

}


}// end of class
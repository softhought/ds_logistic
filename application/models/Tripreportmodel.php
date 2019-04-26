<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tripreportmodel extends CI_Model
{


    public function getRowCountByWhere($material_type_id,$Shift,$fromDate,$toDate,$projectid=null)
    {
      $count=0;
      
      if ($projectid!="0" || $projectid!=0 ) {
        $project="AND project_material_details.`project_id`='$projectid'";
      }else{
        $project="";
      }
      $ShiftCount="SELECT COUNT(*) AS $Shift FROM project_material_details 
      INNER JOIN driver_tracking_history ON project_material_details.`project_material_id`=driver_tracking_history.`project_material_id`
      WHERE project_material_details.`material_type_id`=$material_type_id AND driver_tracking_history.`shift_code`='$Shift' 
      AND driver_tracking_history.`shift_date` BETWEEN '$fromDate' AND '$toDate' ".$project;
      $query=$this->db->query($ShiftCount);	
     // echo $this->db->last_query();exit;
      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
          $count=$rows->$Shift;
        }
        return $count;
      }
      else
      {
        return $count;
      }
    }


    public function getTripReport($fromDate,$toDate,$projectid=null)
    {
      $data=[];
      $materialSql="SELECT * FROM project_material_details 
      INNER JOIN material_type ON project_material_details.`material_type_id`=material_type.`material_type_id` 
      GROUP BY material_type.`material_type_id` ";
      $query=$this->db->query($materialSql);
      if($query->num_rows()> 0)
      {
          foreach ($query->result() as $rows)
          {
            $A=$this->getRowCountByWhere($rows->material_type_id,"A",$fromDate,$toDate,$projectid);
            $B=$this->getRowCountByWhere($rows->material_type_id,"B",$fromDate,$toDate,$projectid);
            $C=$this->getRowCountByWhere($rows->material_type_id,"C",$fromDate,$toDate,$projectid);
            $data[]=[
              "materialType"=>$rows->material,
              "A"=>$A,
              "B"=>$B,
              "C"=>$C,
              "Total"=>$A+$B+$C
            ];
            
          }
          return $data ;
      }
      else{
          return $data ;
       }

      
    }



}/* end of class */
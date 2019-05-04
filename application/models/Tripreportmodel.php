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



    /* get quantity report */


    public function getQuantityTripReport($fromDate,$toDate,$projectid=null)
    {
      $data=[];
  
      $where_project = array('project_material_details.project_id' => $projectid );
      $query=$this->db->select('*')
                        ->from('project_material_details')
                        ->join('material_type','material_type.material_type_id=project_material_details.material_type_id','INNER')
                        ->where($where_project)
                        ->get();

      if($query->num_rows()> 0)
      {
          foreach ($query->result() as $rows)
          {
           // $ATrip=$this->getTripCount($rows->project_material_id,"A",$fromDate,$toDate,$projectid);
           // $BTrip=$this->getTripCount($rows->project_material_id,"B",$fromDate,$toDate,$projectid);
           // $CTrip=$this->getTripCount($rows->project_material_id,"C",$fromDate,$toDate,$projectid);

            $AQty=$this->getTripQuantity($rows->project_material_id,"A",$fromDate,$toDate,$projectid);
            $BQty=$this->getTripQuantity($rows->project_material_id,"B",$fromDate,$toDate,$projectid);
            $CQty=$this->getTripQuantity($rows->project_material_id,"C",$fromDate,$toDate,$projectid);

            $A=$AQty;
            $B=$BQty;
            $C=$CQty;
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


    public function getTripCount($project_material_id,$Shift,$fromDate,$toDate,$projectid=null)
    {
      $count=0;

      $where = array(
                        'driver_tracking_history.project_material_id' => $project_material_id,
                        'driver_tracking_history.shift_code' => $Shift,
                        'project_material_details.project_id' => $projectid
       );

      $query=$this->db->select('
                          COUNT(*) AS '.$Shift.'
                          ')
                        ->from('driver_tracking_history')
                        ->join('project_material_details','project_material_details.project_material_id=driver_tracking_history.project_material_id','INNER')
                        ->where($where)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->get();
                        #q();

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



    public function getTripQuantity($project_material_id,$Shift,$fromDate,$toDate,$projectid=null)
    {
      $count=0;

      $where = array(
                        'driver_tracking_history.project_material_id' => $project_material_id,
                        'driver_tracking_history.shift_code' => $Shift,
                        'project_material_details.project_id' => $projectid
       );

      $query=$this->db->select('
                         SUM(IFNULL(vehicle_master.capacity, 0)*IFNULL(project_material_details.conversation_factor, 0)) AS qty
                          ')
                        ->from('driver_tracking_history')
                        ->join('project_material_details','project_material_details.project_material_id=driver_tracking_history.project_material_id','INNER')
                         ->join('vehicle_master','driver_tracking_history.mobile_id=vehicle_master.mobile_uniq_id','INNER')
                        ->where($where)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") >= ', $fromDate)
                        ->where('DATE_FORMAT(`driver_tracking_history`.`shift_date`,"%Y-%m-%d") <= ', $toDate)
                        ->get();
                       # q();

      if($query->num_rows()>0){
        foreach ($query->result() as $rows)
        {
          $count=$rows->qty;
        }
        return $count;
      }
      else
      {
        return $count;
      }
    }



}/* end of class */
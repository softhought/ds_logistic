<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mastermodel extends CI_Model{

    public function getDriverList()
    {
        $data = array();
        $query=$this->db->select('*')
                        ->from('driver_master')
                        ->join('vehicle_type','driver_master.vehicle_type_id=vehicle_type.vehicle_type_id','INNER')
                        ->order_by('driver_master.driver_name')
                        ->get();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = $rows;
            }
            return $data;
        }else{
            return $data;
         }
    }

    public function getVehicleList()
    {
        $data = array();
        $query=$this->db->select('*')
                        ->from('vehicle_master')
                        ->join('vehicle_type','vehicle_master.vehicle_type_id=vehicle_type.vehicle_type_id','INNER')
                        ->join('mobile_master','vehicle_master.mobile_uniq_id=mobile_master.mobile_id','LEFT')
                        ->get();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = $rows;
            }
            return $data;
        }else{
            return $data;
         }
    }

    public function getListofVehicleHavingMobileId()
    {
        $data = array();
        $query=$this->db->select('*')
                        ->from('vehicle_master')
                        ->join('mobile_master','vehicle_master.mobile_uniq_id=mobile_master.mobile_id','INNER')
                        ->where('vehicle_master.is_active','Y')
                        ->get();
                        #   echo $this->db->last_query();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = $rows;
            }
            return $data;
        }else{
            return $data;
         }
    }

    // get unassign mobile list of vehicle

    public function getUnassignMobileList()
    {
        $data = array();
        $query=$this->db->select('mobile_master.*')
                        ->from('mobile_master')
                        ->join('vehicle_master','vehicle_master.mobile_uniq_id=mobile_master.mobile_id','LEFT')
                        ->where('vehicle_master.mobile_uniq_id IS NULL')
                        ->where('mobile_master.is_active','Y')
                        ->get();
                          # echo $this->db->last_query();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = $rows;
            }
            return $data;
        }else{
            return $data;
         }
    }


        // get unassign vehicle list of mobile

        public function getUnassignVehicleList()
        {
            $data = array();
            $query=$this->db->select('*')
                            ->from('vehicle_master')
                            ->where('vehicle_master.mobile_uniq_id IS NULL')
                            ->where('vehicle_master.is_active','Y')
                            ->get();
                              # echo $this->db->last_query();
            if($query->num_rows()> 0)
            {
                foreach ($query->result() as $rows)
                {
                    $data[] = $rows;
                }
                return $data;
            }else{
                return $data;
             }
        }


/* ----------------- get supervisor ---------------*/

    public function getSupervisorList()
    {
        $data = array();
        $query=$this->db->select('supervisor_master.*,project_master.project_nickname,project_master.project_name')
                        ->from('supervisor_master')
                        ->join('project_master','project_master.project_id=supervisor_master.project_id','INNER')
                        ->order_by('project_master.project_name')
                        ->get();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
            {
                $data[] = $rows;
            }
            return $data;
        }else{
            return $data;
         }
    }

}/* end of class */
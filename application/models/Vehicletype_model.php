<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vehicletype_model extends CI_Model{
	
	
	
	


	public function insertIntoVehicletype($data,$session) {
		try {
            $this->db->trans_begin();
			
			$vehicletype_data = [];
			$vehicletype_data = [
				"vehicle_type" => trim(htmlspecialchars($data['vehicletype'])),
				"is_new" => 'Y'
			];
			
			$this->db->insert('vehicle_type', $vehicletype_data);
			if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
	}



	public function updateVehicletype($data,$session){
		try {
            $this->db->trans_begin();
			
			$vehicletype_data = [];
			$vehicletypeID = trim(htmlspecialchars($data['vehicletypeID']));
			$vehicletype_data = [
				"vehicle_type" => trim(htmlspecialchars($data['vehicletype'])),
				"is_new" => 'Y'
			];
                        
            $this->db->where('vehicle_type.vehicle_type_id', $vehicletypeID);
			$this->db->update('vehicle_type', $vehicletype_data); 
			
			if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
	}

	
	
    
	
}
<?php
class  globalModel{
	
	var $table='';
	
	function __construct(){
		$this->CI =getCI();
	}
	
	function _add($data){
		if($this->CI->db->field_exists('user_add',$this->CI->DATA->table)){			
			$data['user_add'] = $this->CI->jCfg['user']['id'];
		}
		if($this->CI->db->field_exists('time_add',$this->CI->DATA->table)){	
			$data['time_add'] = date("Y-m-d H:i:s");
		}
		if($this->CI->db->field_exists('app_id',$this->CI->DATA->table)){	
			$data['app_id'] = $this->CI->jCfg['app_id'];
		}

		if($this->CI->db->field_exists('user_update',$this->CI->DATA->table)){			
				$data['user_update'] = $this->CI->jCfg['user']['id'];
			}
			if($this->CI->db->field_exists('time_update',$this->CI->DATA->table)){	
				$data['time_update'] = date("Y-m-d H:i:s");
			}
			
		return $this->CI->db->insert(
			$this->table,
			$data
		);
	}
	
	function _update($par=array(), $data=array()){
		if(count($par) > 0 && count($data) > 0){
			
			if($this->CI->db->field_exists('user_update',$this->CI->DATA->table)){			
				$data['user_update'] = $this->CI->jCfg['user']['id'];
			}
			if($this->CI->db->field_exists('time_update',$this->CI->DATA->table)){	
				$data['time_update'] = date("Y-m-d H:i:s");
			}
			
			return $this->CI->db->update(
				$this->table,
				$data, 
				$par
			);
		}else
			return false;
	}

	function _delete($par=array(),$remove=FALSE){
		if(count($par) > 0 ){
			
			if($remove == TRUE){
				if(count($par) > 0){
					return $this->CI->db->delete($this->table,$par); 
				}else
					return false;
					
			}else{

				$data = array();
				$data['is_trash'] = 1;
				
				if($this->CI->db->field_exists('user_delete',$this->CI->DATA->table)){			
					$data['user_delete'] = $this->CI->jCfg['user']['id'];
				}
				if($this->CI->db->field_exists('time_delete',$this->CI->DATA->table)){	
					$data['time_delete'] = date("Y-m-d H:i:s");
				}
				
				return $this->CI->db->update(
					$this->table,
					$data, 
					$par
				);

			}

		}else
			return false;
	}
	
	function _cek($par=array()){
		if(count($par) > 0){
			$m = $this->CI->db->get_where($this->table,$par);
			return $m->num_rows();
		}else
			return false;		
	}
	
	function _getall($par=array()){
		return  $this->CI->db->get_where($this->table,$par)->result();
	}
	
	function data_id($par=array()){
		if(count($par) > 0){
			return $this->CI->db->get_where(
				$this->table, 
				$par
			)->row();
		}else
			return false; 
	}
	
}
	
?>
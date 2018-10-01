<?php
class mdl_global_master extends CI_Model{ 
	
	var $table = '';
	var $field_search = array();
	var $field_join = array();
	var $order_by = "city_title ASC";
	
	function __construct(){
		parent::__construct();
	} 

	function data($p=array()){
	
		$where = '';
		
		if( isset($p['keyword']) && trim($p['keyword']) != '' ){
			$str_where = array();
			if( count($this->field_search) > 0 ){
				foreach ($this->field_search as $value) {
					$str_where[] = " ".$value." like '%".pTxt($p['keyword'])."%' ";
				}
				$where = " AND ( ".implode(" OR ", $str_where)." )";
			}			

		}
		
		$sql = "
		 	select 
				SQL_CALC_FOUND_ROWS a.*,b.province_title,c.city_title,c.city_id
			FROM ".$this->table." a
			LEFT JOIN iapi_province b ON a.".$this->field_join['province']." = b.province_id
			LEFT JOIN iapi_city c ON a.".$this->field_join['city']." = c.city_id
			WHERE 
				a.is_trash != 1
			".$where."
			ORDER BY ".$this->order_by." 
		";	
		
		if( isset($p['limit']) && isset($p['offset']) ){
			$offset = empty($p['offset'])?0:$p['offset'];				
			$sql .= " LIMIT ".$offset.",".$p['limit']." ";
		}
		$query = $this->db->query($sql);
		
		$found_rows = $this->db->query('SELECT FOUND_ROWS() as found_rows');

		return array(
			"data" 	=> $query->result(),
			"count"	=> $found_rows->row()
		);
	}	
	
}
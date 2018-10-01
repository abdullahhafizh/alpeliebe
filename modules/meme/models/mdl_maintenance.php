<?php
class mdl_maintenance extends CI_Model{ 
	function __construct(){
		parent::__construct();
	} 

	function maintenance($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_maintenance.*');
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_maintenance.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_maintenance.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

		}

		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$this->jCfg['search']['keyword']."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}
		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$this->db->like($this->jCfg['search']['colum'],$this->jCfg['search']['keyword']);
		}
		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}
		if(trim($this->jCfg['search']['order_by'])!="")
			//$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
			$this->db->order_by('id_maintenance','DESC');
		$qry = $this->db->get('app_maintenance');
		if($count==FALSE){
			$total = $this->maintenance($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}

}
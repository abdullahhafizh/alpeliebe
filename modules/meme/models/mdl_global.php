<?php
class mdl_global extends CI_Model{ 
	function __construct(){
		parent::__construct();
	} 
	
	function data_dashboard($p=array()){
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
		if(isset($p['island_id']) && trim($p['island_id']) != ""){
			$where .= "AND a.media_island_id = '".$p['island_id']."' ";
		}
		if(isset($p['city_island_id']) && trim($p['city_island_id']) != ""){
			$where .= "AND a.media_city_island_id = '".$p['city_island_id']."' ";
		}
		if(isset($p['year']) && trim($p['year']) != ""){
			$where .= "AND a.media_year = '".$p['year']."' ";
		}
		if(isset($p['month']) && trim($p['month']) != ""){
			$where .= "AND a.media_month = '".$p['month']."' ";
		}
		if(isset($p['type']) && trim($p['type']) != ""){
			$where .= "AND a.media_type = '".$p['type']."' ";
		}
		
		$sql = "
			select 
				SQL_CALC_FOUND_ROWS a.*, b.*, c.*
			FROM app_media a, app_island b, app_island_city c
				WHERE a.is_trash = 0
				AND a.media_status = 1
				AND a.media_island_id = b.island_id
				AND a.media_city_island_id = c.city_island_id
				".$where."
			ORDER BY media_id DESC		
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

	function island($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_island.*');
		$this->db->where('app_island.is_trash', 0); 
		
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_island.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_island.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			// $this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
			$this->db->order_by('island_id','DESC');
		$qry = $this->db->get('app_island');
		if($count==FALSE){
			$total = $this->island($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}
	
	function city($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_island_city.*,pbsi_propinsi.propinsi_nama,pbsi_kabupaten.kab_nama,app_island.island_name');
		$this->db->join('pbsi_propinsi','app_island_city.city_island_province_id = pbsi_propinsi.propinsi_id','left');
		$this->db->join('pbsi_kabupaten','app_island_city.city_island_city_id = pbsi_kabupaten.kab_id','left');
		$this->db->join('app_island','app_island_city.city_island_island_id = app_island.island_id','left');
		$this->db->where('app_island_city.is_trash', 0); 
		
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_island_city.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_island_city.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			// $this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
			$this->db->order_by('city_island_id','DESC');
		$qry = $this->db->get('app_island_city');
		if($count==FALSE){
			$total = $this->city($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}

	function photo($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_media.*,pbsi_propinsi.propinsi_nama,pbsi_kabupaten.kab_nama,app_island.island_name');
		$this->db->where('app_island_city.is_trash', 0); 
		
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_island_city.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_island_city.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			// $this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
			$this->db->order_by('city_island_id','DESC');
		$qry = $this->db->get('app_island_city');
		if($count==FALSE){
			$total = $this->city($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}

	function media($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_media.*','app_island.*','app_island_city.*');
		$this->db->join('app_island','app_media.media_island_id = app_island.island_id','left');
		$this->db->join('app_island_city','app_media.media_city_island_id = app_island_city.city_island_id','left');
		$this->db->where('app_media.is_trash', 0);


		if( isset($p['type']) && trim($p['type']) != "" ){
			$this->db->where('app_media.media_type', $p['type']); 
		} 
		
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_media.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_media.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			// $this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
			$this->db->order_by('media_id','DESC');
		$qry = $this->db->get('app_media');
		if($count==FALSE){
			$total = $this->media($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}
}
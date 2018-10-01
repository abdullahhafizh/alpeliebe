<?php
class mdl_report extends CI_Model{ 
		
	function __construct(){
		parent::__construct();
	} 
	
	function kta($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select('DISTINCT(kta_id) as id, app_kta.*,app_agama.agama_nama,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama,app_pengguna.nama_pengguna, app_pekerjaan.pekerjaan_nama, app_user.user_fullname');		
		$this->db->join('app_agama','app_agama.agama_id=app_kta.kta_agama','LEFT');
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$this->db->join('app_kecamatan','app_kecamatan.kec_kode=app_kta.kta_kecamatan','LEFT');
		$this->db->join('app_kelurahan','app_kelurahan.kel_kode=app_kta.kta_kelurahan','LEFT');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_kta.kta_pemesan','LEFT');
		$this->db->join('app_pekerjaan','app_pekerjaan.pekerjaan_id=app_kta.kta_pekerjaan','LEFT');
		$this->db->join('app_user','app_user.user_id=app_kta.col10','LEFT');
		$this->db->where("kta_status_data",1);
		$this->db->where("is_cetak",0);
		if(isset($p['pengusul']) ){
			if($p['pengusul'] != ""){
			$this->db->where("kta_pemesan",$p['pengusul']);
			}
		}
		if(isset($p['propinsi']) ){
			if($p['propinsi'] != ""){
			$this->db->where("kta_propinsi",$p['propinsi']);
			}
		}

		if(isset($p['kabupaten']) ){
			if($p['kabupaten'] != ""){
			$this->db->where("kta_kabupaten",$p['kabupaten']);
			}
		}
		
		if(isset($p['kecamatan']) ){
			if($p['kecamatan'] != ""){
			$this->db->where("kta_kecamatan",$p['kecamatan']);
			}
		}
		if(isset($p['kelurahan']) ){
			if($p['kelurahan'] != ""){
			$this->db->where("kta_kelurahan",$p['kelurahan']);
			}
		}

		/* where or like conditions */
		$start_time = $this->jCfg['search']['date_start']." 01:00:00";
		$end_time = $this->jCfg['search']['date_end']." 23:59:00";

		if( trim($this->jCfg['search']['date_start'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_kta.time_add >= '".$start_time."' AND app_kta.time_add <= '".$start_time."' )");
		}
//		if( isset($p['id']) && trim($p['id'])==3 ){
//				$this->db->where("kta_id =",$p['id']);
//		}

		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$vm = $this->jCfg['search']['keyword'];
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$vm."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$vm = $this->jCfg['search']['keyword'];
			if($this->jCfg['search']['colum']=="kta_jenkel"){
				$vm = $this->jCfg['search']['keyword']=='Pria'?1:0;
			}
			$this->db->like($this->jCfg['search']['colum'],$vm);
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}
		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==3 ){
			$this->db->order_by('time_add','DESC');
		}

		if( isset($p['order_by']) ){
			$this->db->order_by($p['order_by'],'ASC');
		}
		if( isset($p['type_data']) && trim($p['type_data']) != "" ){
			if( trim($p['type_data'])==1 ){
				$this->db->order_by('kta_approval_date','DESC');
			}
			if( trim($p['type_data'])==2 ){
				$this->db->order_by('kta_approval_date','DESC');
			}
			if( trim($p['type_data'])==3 ){
				$this->db->order_by('time_add','DESC');
			}
		}
		$this->db->order_by('time_add','DESC');
		//if(trim($this->jCfg['search']['order_by'])!="" && !isset($p['id']) )
			//$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get('app_kta');
		if($count==FALSE){
			$total = $this->kta($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}
	
	function report_letter($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select('DISTINCT(kta_id) as id, app_kta.*,app_agama.agama_nama,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama, app_negara.negara_nama');		
		$this->db->join('app_agama','app_agama.agama_id=app_kta.kta_agama','LEFT');
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$this->db->join('app_kecamatan','app_kecamatan.kec_kode=app_kta.kta_kecamatan','LEFT');
		$this->db->join('app_kelurahan','app_kelurahan.kel_kode=app_kta.kta_kelurahan','LEFT');
		$this->db->join('app_negara','app_negara.negara_kode=app_propinsi.negara_kode','LEFT');
		if(isset($p['propinsi']) ){
			if($p['propinsi'] != ""){
			$this->db->where("kta_propinsi",$p['propinsi']);
			}
		}

		if(isset($p['kabupaten']) ){
			if($p['kabupaten'] != ""){
			$this->db->where("kta_kabupaten",$p['kabupaten']);
			}
		}
		
		if(isset($p['kecamatan']) ){
			if($p['kecamatan'] != ""){
			$this->db->where("kta_kecamatan",$p['kecamatan']);
			}
		}
		if(isset($p['kelurahan']) ){
			if($p['kelurahan'] != ""){
			$this->db->where("kta_kelurahan",$p['kelurahan']);
			}
		}

		/* where or like conditions */
		if(isset($p['date_from']) || isset($p['date_to']) ){
		$start_time = $p['date_from']." 00:00:00";
		$end_time = $p['date_to']." 23:59:00";		
		if( trim($p['date_from'])!="" && trim($p['date_to']) != "" ){
			$this->db->where("( app_kta.time_add >= '".$start_time."' AND app_kta.time_add <= '".$end_time."' )");
		}
		}
//		if( isset($p['id']) && trim($p['id'])==3 ){
//				$this->db->where("kta_id =",$p['id']);
//		}

		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$vm = $this->jCfg['search']['keyword'];
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$vm."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$vm = $this->jCfg['search']['keyword'];
			if($this->jCfg['search']['colum']=="kta_jenkel"){
				$vm = $this->jCfg['search']['keyword']=='Pria'?1:0;
			}
			$this->db->like($this->jCfg['search']['colum'],$vm);
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}
		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==3 ){
			$this->db->order_by('time_add','DESC');
		}

		if( isset($p['order_by']) ){
			$this->db->order_by($p['order_by'],'ASC');
		}
		if( isset($p['type_data']) && trim($p['type_data']) != "" ){
			if( trim($p['type_data'])==1 ){
				$this->db->order_by('kta_approval_date','DESC');
			}
			if( trim($p['type_data'])==2 ){
				$this->db->order_by('kta_approval_date','DESC');
			}
			if( trim($p['type_data'])==3 ){
				$this->db->order_by('time_add','DESC');
			}
		}
		$this->db->order_by('time_add','DESC');
		//if(trim($this->jCfg['search']['order_by'])!="" && !isset($p['id']) )
			//$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get('app_kta');
		if($count==FALSE){
			$total = $this->report_letter($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}

	function report_kta($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select('DISTINCT(kta_id) as id, app_kta.*,app_agama.agama_nama,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama,app_pengguna.nama_pengguna, app_pekerjaan.pekerjaan_nama');		
		$this->db->join('app_agama','app_agama.agama_id=app_kta.kta_agama','LEFT');
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$this->db->join('app_kecamatan','app_kecamatan.kec_kode=app_kta.kta_kecamatan','LEFT');
		$this->db->join('app_kelurahan','app_kelurahan.kel_kode=app_kta.kta_kelurahan','LEFT');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_kta.kta_pemesan','LEFT');
		$this->db->join('app_pekerjaan','app_pekerjaan.pekerjaan_id=app_kta.kta_pekerjaan','LEFT');

		if(isset($p['koordinator']) ){
			if($p['koordinator'] != ""){
			$this->db->where("col9 = ".$p['koordinator']."");
			}
		}
		if(isset($p['operator']) ){
			if($p['operator'] != ""){
			$this->db->where("app_kta.col5",$p['operator']);
			}
		}
		/* where or like conditions */
		$start_time = $p['date_from']." 01:00:00";
		$end_time = $p['date_to']." 23:59:00";

		if( trim($p['date_from'])!="" && trim($p['date_to']) != "" ){
			$this->db->where("( app_kta.time_entry >= '".$start_time."' AND app_kta.time_entry <= '".$end_time."' )");
		}

		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$vm = $this->jCfg['search']['keyword'];
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$vm."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$vm = $this->jCfg['search']['keyword'];
			if($this->jCfg['search']['colum']=="kta_jenkel"){
				$vm = $this->jCfg['search']['keyword']=='Pria'?1:0;
			}
			$this->db->like($this->jCfg['search']['colum'],$vm);
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}
		if( isset($p['order_by']) ){
			$this->db->order_by($p['order_by'],'ASC');
		}
		$this->db->order_by('time_entry','DESC');
		//if(trim($this->jCfg['search']['order_by'])!="" && !isset($p['id']) )
			//$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get('app_kta');
		if($count==FALSE){
			$total = $this->report_kta($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}
	
	function report_upload($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select('DISTINCT(kta_id) as id, app_kta.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_pengguna.nama_pengguna');		
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_kta.kta_pemesan','LEFT');

		if(isset($p['koordinator']) ){
			if($p['koordinator'] != ""){
			$this->db->where("col10 = ".$p['koordinator']."");
			}
		}

		if($this->jCfg['user']['userrole'] == 35){
			if(isset($p['operator']) ){
				if($p['operator'] != ""){
				$this->db->where("app_kta.col4",$p['operator']);
				}
			}
		}
		/* where or like conditions */
		if(isset($p['date_from']) || isset($p['date_to']) ){
		$start_time = $p['date_from']." 00:00:00";
		$end_time = $p['date_to']." 23:59:00";		
		if( trim($p['date_from'])!="" && trim($p['date_to']) != "" ){
			$this->db->where("( app_kta.time_scan >= '".$start_time."' AND app_kta.time_scan <= '".$end_time."' )");
		}
		}
		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$vm = $this->jCfg['search']['keyword'];
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$vm."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$vm = $this->jCfg['search']['keyword'];
			if($this->jCfg['search']['colum']=="kta_jenkel"){
				$vm = $this->jCfg['search']['keyword']=='Pria'?1:0;
			}
			$this->db->like($this->jCfg['search']['colum'],$vm);
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}
		if( isset($p['order_by']) ){
			$this->db->order_by($p['order_by'],'ASC');
		}
		$this->db->order_by('time_scan','DESC');
		$this->db->order_by('kta_status_data','DESC');
		//if(trim($this->jCfg['search']['order_by'])!="" && !isset($p['id']) )
			//$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get('app_kta');
		if($count==FALSE){
			$total = $this->report_upload($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}
	
	function report_entry($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select('DISTINCT(kta_id) as id, app_kta.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_pengguna.nama_pengguna');		
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_kta.kta_pemesan','LEFT');

		if(isset($p['koordinator']) ){
			if($p['koordinator'] != ""){
			$this->db->where("col10 = ".$p['koordinator']."");
			}
		}

		if($this->jCfg['user']['userrole'] == 34){
			if(isset($p['operator']) ){
				if($p['operator'] != ""){
				$this->db->where("app_kta.col5",$p['operator']);
				}
			}
		}
		/* where or like conditions */
		if(isset($p['date_from']) || isset($p['date_to']) ){
		$start_time = $p['date_from']." 00:00:00";
		$end_time = $p['date_to']." 23:59:00";		
		if( trim($p['date_from'])!="" && trim($p['date_to']) != "" ){
			$this->db->where("( app_kta.time_entry >= '".$start_time."' AND app_kta.time_entry <= '".$end_time."' )");
		}
		}
		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$vm = $this->jCfg['search']['keyword'];
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$vm."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$vm = $this->jCfg['search']['keyword'];
			if($this->jCfg['search']['colum']=="kta_jenkel"){
				$vm = $this->jCfg['search']['keyword']=='Pria'?1:0;
			}
			$this->db->like($this->jCfg['search']['colum'],$vm);
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}
		if( isset($p['order_by']) ){
			$this->db->order_by($p['order_by'],'ASC');
		}
		$this->db->order_by('time_scan','DESC');
		$this->db->order_by('kta_status_data','DESC');
		//if(trim($this->jCfg['search']['order_by'])!="" && !isset($p['id']) )
			//$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get('app_kta');
		if($count==FALSE){
			$total = $this->report_entry($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}

function get_member($p=array()){
		
		$total = 0;
				
		if(isset($p['proposer']) && !empty($p['proposer'])) {
			$proposer = $this->db->get_where('app_pengguna',array('nama_pengguna' => $p['proposer']))->row();
			$this->db->where(array('kta_pemesan' => $proposer->penggunaID));
		}
			
		if(isset($p['province']) && !empty($p['province']))
			$this->db->where(array('kta_propinsi' => $p['province']));
			
		if(isset($p['city']) && !empty($p['city']))
			$this->db->where(array('kta_kabupaten' => $p['city']));
		
		if(isset($p['district']) && !empty($p['district']))
			$this->db->where(array('kta_kecamatan' => $p['district']));
			
		if(isset($p['area']) && !empty($p['area']))
			$this->db->where(array('kta_kelurahan' => $p['area']));
						
		$this->db->where('kta_foto_wajah is not null AND kta_foto_ktp is not null');
		$this->db->where('kta_status_data',1);
		$this->db->limit(20,0);
		$this->db->order_by('kta_nama_lengkap','ASC');
				
		$this->db->select('app_kta.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama, app_pekerjaan.pekerjaan_nama');		
		$this->db->join('app_propinsi','app_propinsi.propinsi_id=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$this->db->join('app_kecamatan','app_kecamatan.kec_kode=app_kta.kta_kecamatan','LEFT');
		$this->db->join('app_kelurahan','app_kelurahan.kel_kode=app_kta.kta_kelurahan','LEFT');
		$this->db->join('app_pekerjaan','app_pekerjaan.pekerjaan_id=app_kta.kta_pekerjaan','LEFT');
		$qry = $this->db->get('app_kta');
		
		return $qry->result();

	}
function get_data($p=array()){
		
		$total = 0;				
		
		if(isset($p['proposer']) && !empty($p['proposer'])) {
			$proposer = $this->db->get_where('app_pengguna',array('nama_pengguna' => $p['proposer']))->row();
			$this->db->where(array('kta_pemesan' => $proposer->penggunaID));
		}
		
		if(isset($p['province']) && !empty($p['province']))
			$this->db->where(array('kta_propinsi' => $p['province']));
			
		if(isset($p['city']) && !empty($p['city']))
			$this->db->where(array('kta_kabupaten' => $p['city']));
		
		$this->db->where('kta_foto_wajah is not null AND kta_foto_ktp is not null');
		$this->db->where('kta_status_data',1);
		$this->db->where('is_cetak',0);
						
		$this->db->limit($p['limit'],$p['offset']);
		$this->db->order_by('kab_nama','ASC');
				
		$this->db->select('app_kta.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama');		
		$this->db->join('app_propinsi','app_propinsi.propinsi_id=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$qry = $this->db->get('app_kta');
		
		return $qry->result();
		
	} 
	
	function get_data_cetak($p=array()){
		
		$total = 0;				
	
		if(isset($p['proposer']) && !empty($p['proposer'])) {
			$proposer = $this->db->get_where('app_pengguna',array('nama_pengguna' => $p['proposer']))->row();
			$this->db->where(array('cetak_pengusul' => $proposer->penggunaID));
		}
		
		if(isset($p['idc']) && !empty($p['idc'])) {
			$this->db->where('cetak_id in ('.$p['idc'].')');
		}
		
		$this->db->where('cetak_invoice',0);						
		$this->db->order_by('cetak_tanggal','ASC');
				
		$this->db->select('app_data_cetak.*,app_pengguna.nama_pengguna');		
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_data_cetak.cetak_pengusul','INNER');
		$qry = $this->db->get('app_data_cetak');
		
		return $qry->result();
		
	}
}
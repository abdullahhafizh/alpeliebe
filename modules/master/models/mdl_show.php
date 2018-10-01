<?php
class mdl_master extends CI_Model{ 

	var $table = 'app_kta';
	var $column_order = array(null, 'kta_nama_lengkap','kta_propinsi','kta_kabupaten','kta_kecamatan','kta_kelurahan','kta_status_data'); //set column field database for datatable orderable
	var $column_search = array('kta_nama_lengkap','kta_propinsi','kta_kabupaten','kta_kecamatan','kta_kelurahan','kta_status_data'); //set column field database for datatable searchable 
	var $order = array('kta_id' => 'asc'); // default order 
		
	function __construct(){
		parent::__construct();
	} 

	function kta($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select('DISTINCT(kta_id) as id, app_kta.*,app_agama.agama_nama,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama,app_pengguna.nama_pengguna, app_pekerjaan.pekerjaan_nama, app_user.user_fullname');		
		
/*		if( isset($p['perpanjangan']) ){
			$this->db->join('app_kta_perpanjangan','app_kta_perpanjangan.ktap_id=app_kta.kta_ktap_id');
		}
*/
		$this->db->join('app_agama','app_agama.agama_id=app_kta.kta_agama','LEFT');
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$this->db->join('app_kecamatan','app_kecamatan.kec_kode=app_kta.kta_kecamatan','LEFT');
		$this->db->join('app_kelurahan','app_kelurahan.kel_kode=app_kta.kta_kelurahan','LEFT');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_kta.kta_pemesan','LEFT');
		$this->db->join('app_pekerjaan','app_pekerjaan.pekerjaan_id=app_kta.kta_pekerjaan','LEFT');
		$this->db->join('app_user','app_user.user_id=app_kta.col10','LEFT');
/*		
		if($this->jCfg['user']['userrole'] == 30){
			$this->db->where("kta_pemesan",$this->jCfg['user']['penggunaid']);			
			$this->db->where("kta_propinsi",$this->jCfg['user']['propinsi']);
		}

		if($this->jCfg['user']['userrole'] == 35){
//			$this->db->where("app_kta.col4",$this->jCfg['user']['id']);			
//			$this->db->where("app_kta.col5",$this->jCfg['user']['id']);			
//			$this->db->where("col3",$this->jCfg['user']['id']);			
		}
		if($this->jCfg['user']['userrole'] == 34){
	//		$this->db->where("app_kta.col4",$this->jCfg['user']['id']);			
		//	$this->db->where("app_kta.col5",$this->jCfg['user']['id']);			
//			$this->db->where("col3",$this->jCfg['user']['id']);			
		}
*/
		if(isset($p['pengusul']) ){
			if($p['pengusul'] != ""){
			$this->db->where("kta_pemesan",$p['pengusul']);
			}
		}

		if(isset($p['nama']) ){
			if($p['nama'] != ""){
			$this->db->where("kta_nama_lengkap LIKE '%".$p['nama']."%'");
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
		if($this->jCfg['user']['userrole'] == 33){
			$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
		}

		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==1 ){
			$this->db->where("is_cetak","0");			
		}
		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==2 ){
			$this->db->where("is_cetak","0");
		}
		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==3 ){
			$this->db->where("kta_status_data","0");
		}
		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==10 ){
			$this->db->where("kta_status_data","1");
			$this->db->where("is_cetak","0");
//			$this->db->where("kta_pemesan",$this->jCfg['user']['penggunaid']);			
		}

		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==4 ){
		}
		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==5 ){
		}
		if( isset($p['id'])){
			$this->db->where("kta_id",$p['id']);
		}
		if( isset($p['status'])){
			$this->db->where("kta_status_data",$p['status']);
		}

		if( isset($p['in_id'])){
			$this->db->where_in("kta_id",$p['in_id']);
		}

		if( isset($p['type_data']) && trim($p['type_data']) != "" ){
			if( trim($p['type_data'])==1 ){
				$this->db->where("kta_status_data != 2 AND kta_status_data != 3");
			}
			if( trim($p['type_data'])==2 ){
				$this->db->where("kta_status_data",1);
			}
			if( trim($p['type_data'])==3 ){
	//			$this->db->where("kta_status_data",0);
			}
			if( trim($p['type_data'])==4 ){
//				$this->db->where("kta_status_asuransi",4);
			}
			if( trim($p['type_data'])==6 ){
//				$this->db->where("kta_status =",1);
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
	function propinsi($p=array(),$count=FALSE){
		
		$total = 0;

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
			$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get("app_propinsi");
		if($count==FALSE){
			$total = $this->propinsi($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}

	function kabupaten($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select("app_kabupaten.*,app_propinsi.propinsi_nama");
		$this->db->join("app_propinsi","app_propinsi.propinsi_kode = app_kabupaten.kab_propinsi_id");
		// dont modified....
		if(trim(isset($p['propinsi']))){
			if($p['propinsi'] != ""){
			$this->db->where("kab_propinsi_id",$p['propinsi']);
			}
		}
		
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

		$this->db->order_by("app_kabupaten.kab_propinsi_id","ASC");
		if(trim($this->jCfg['search']['order_by'])!="")
			$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get("app_kabupaten");
		if($count==FALSE){
			$total = $this->kabupaten($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}

	function kecamatan($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select("app_kecamatan.*,app_kabupaten.kab_nama,app_kabupaten.kab_propinsi_id,app_propinsi.propinsi_nama");
		$this->db->join("app_kabupaten","app_kabupaten.kab_kode = app_kecamatan.kec_kab_id");
		$this->db->join("app_propinsi","app_propinsi.propinsi_kode = app_kabupaten.kab_propinsi_id");
		// dont modified....
		if(isset($p['propinsi']) ){
			if($p['propinsi'] != ""){
			$this->db->where("kab_propinsi_id",$p['propinsi']);
			}
		}

		if(isset($p['kabupaten']) ){
			if($p['kabupaten'] != ""){
			$this->db->where("kec_kab_id",$p['kabupaten']);
			}
		}
		
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

		$this->db->order_by("app_kecamatan.kec_kab_id","ASC");
		if(trim($this->jCfg['search']['order_by'])!="")
			$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get("app_kecamatan");
		if($count==FALSE){
			$total = $this->kecamatan($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}
	function kelurahan($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->select("app_kelurahan.*,app_kabupaten.kab_kode,app_kabupaten.kab_nama,app_kabupaten.kab_propinsi_id,app_propinsi.propinsi_nama,app_kecamatan.kec_kode,app_kecamatan.kec_nama");
		$this->db->join("app_kecamatan","app_kecamatan.kec_kode = app_kelurahan.kel_kec_id");
		$this->db->join("app_kabupaten","app_kabupaten.kab_kode = app_kecamatan.kec_kab_id");
		$this->db->join("app_propinsi","app_propinsi.propinsi_kode = app_kabupaten.kab_propinsi_id");
		// dont modified....
		if(isset($p['propinsi']) ){
			if($p['propinsi'] != ""){
			$this->db->where("kab_propinsi_id",$p['propinsi']);
			}
		}

		if(isset($p['kabupaten']) ){
			if($p['kabupaten'] != ""){
			$this->db->where("kec_kab_id",$p['kabupaten']);
			}
		}
		
		if(isset($p['kecamatan']) ){
			if($p['kecamatan'] != ""){
			$this->db->where("kel_kec_id",$p['kecamatan']);
			}
		}
		
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

		$this->db->order_by("app_kelurahan.kel_kec_id","ASC");
		if(trim($this->jCfg['search']['order_by'])!="")
			$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get("app_kelurahan");
		if($count==FALSE){
			$total = $this->kelurahan($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}

	function agama($p=array(),$count=FALSE){
		
		$total = 0;

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
			$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get("app_agama");
		if($count==FALSE){
			$total = $this->agama($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}

	function pengguna($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_pengguna.*, app_propinsi.propinsi_nama');
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_pengguna.propinsi_id','LEFT');
		$this->db->where('app_pengguna.is_trash', 0);
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
	//		$this->db->where("( app_user.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_user.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			$this->db->order_by('penggunaID','DESC');
		$qry = $this->db->get('app_pengguna');
		if($count==FALSE){
			$total = $this->pengguna($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}
	
	function topup($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_topup.*, app_pengguna.nama_pengguna, app_propinsi.propinsi_nama');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_topup.penggunaID','LEFT');
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_pengguna.propinsi_id','LEFT');
//		$this->db->where('app_topup.penggunaID', $this->jCfg['user']['penggunaid']);
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
	//		$this->db->where("( app_user.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_user.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			$this->db->order_by('topup_id','DESC');
		$qry = $this->db->get('app_topup');
		if($count==FALSE){
			$total = $this->topup($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}
	function konfirm_topup($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_topup.*, app_pengguna.nama_pengguna, app_pengguna.propinsi_id, app_propinsi.propinsi_nama');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_topup.penggunaID','LEFT');
		$this->db->join('app_propinsi','app_pengguna.propinsi_id=app_propinsi.propinsi_kode','LEFT');
		$this->db->where('app_topup.topup_status',0);
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
	//		$this->db->where("( app_user.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_user.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			$this->db->order_by('topup_id','DESC');
		$qry = $this->db->get('app_topup');
		if($count==FALSE){
			$total = $this->topup($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}

	function daftar_order($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_order.*, app_pengguna.nama_pengguna,app_pengguna.email_pengguna,app_pengguna.notelp_pengguna,app_pengguna.alamat_pengguna,app_pengguna.saldo_pengguna, app_propinsi.propinsi_nama');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_order.order_pengguna','LEFT');
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_pengguna.propinsi_id','LEFT');
		/* where or like conditions */

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
	//		$this->db->where("( app_user.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_user.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			$this->db->order_by('order_id','DESC');
		$qry = $this->db->get('app_order');
		if($count==FALSE){
			$total = $this->daftar_order($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}
	function approve_order($p=array(),$count=FALSE){
		$total = 0;
		/* table conditions */
		$this->db->select('app_order.*, app_pengguna.nama_pengguna,app_pengguna.email_pengguna,app_pengguna.notelp_pengguna,app_pengguna.alamat_pengguna,app_pengguna.saldo_pengguna, app_propinsi.propinsi_nama');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_order.order_pengguna','LEFT');
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_pengguna.propinsi_id','LEFT');
//		$this->db->where('app_topup.penggunaID', $this->jCfg['user']['penggunaid']);
		/* where or like conditions */

		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==3 ){
			$this->db->where("order_status","0");			
		}
		if( isset($p['tab_lunas']) && trim($p['tab_lunas'])==4 ){
			$this->db->where("order_status","1");			
		}

		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
	//		$this->db->where("( app_user.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_user.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

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
			$this->db->order_by('order_id','DESC');
		$qry = $this->db->get('app_order');
		if($count==FALSE){
			$total = $this->daftar_order($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}
	function upload_kta($p=array(),$count=FALSE){
		
		$total = 0;
		$column_order = array(null,'kta_nama_lengkap','kta_tipe_kta','time_scan','kta_no_id','time_entry','col3','col4'); //set column field database for datatable orderable
		$column_search = array('kta_nama_lengkap','kta_tipe_kta','time_scan','kta_no_id','time_entry','col3','col4');
		
		$this->db->select('app_kta.kta_id, app_kta.kta_tipe_kta,app_kta.time_scan,app_kta.time_entry, app_kta.kta_no_id, app_kta.col3, app_kta.col4, app_kta.col6, app_kta.kta_status_data
		,app_pengguna.nama_pengguna, app_user.col1');		
		$this->db->join('app_user','app_user.user_id=app_kta.col4','LEFT');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_kta.kta_pemesan','LEFT');

		if($this->jCfg['user']['userrole'] == 35){
			$this->db->where("app_kta.col4",$this->jCfg['user']['id']);
		}

		if($this->jCfg['user']['userrole'] == 34){
//			$this->db->where("app_kta.col10",$this->jCfg['user']['managerid']);
		}
		if($this->jCfg['user']['userrole'] == 33){
			if( trim($p['type_data']) != 5){
			$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
			}
		}
		if( isset($p['type_data']) && trim($p['type_data']) != "" ){
			if( trim($p['type_data'])==1 ){
				$this->db->where("kta_status_data !=",2);
			}
			if( trim($p['type_data'])==2 ){
					if($this->jCfg['user']['userrole'] == 33){
						$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
						$this->db->where("(kta_status_data = 2 OR kta_status_data = 4 OR kta_status_data = 0)");
					}elseif($this->jCfg['user']['userrole'] == 1 || $this->jCfg['user']['userrole'] == 32){
						$this->db->where("kta_status_data = 2 OR kta_status_data = 4 OR kta_status_data = 0");
					}else{
						$this->db->where("kta_status_assign",1);
//						$this->db->where("col5",$this->jCfg['user']['id']);						
						$this->db->where("col8",$this->jCfg['user']['id']);						
//						$this->db->where("app_kta.col10",$this->jCfg['user']['managerid']);			
						$this->db->where("(kta_status_data = 2 OR kta_status_data = 4 OR kta_status_data = 0)");
					}
			}
			if( trim($p['type_data'])==3 ){
				if($this->jCfg['user']['userrole'] == 32 || $this->jCfg['user']['userrole'] == 1){
					$this->db->where("kta_status_data = 2 OR kta_status_data = 3");
				}else{
					$this->db->where("(kta_status_data = 2 OR kta_status_data = 3 OR kta_status_data = 0)");					
				}
				if($this->jCfg['user']['userrole'] == 34){
					$this->db->where("app_kta.col4",$this->jCfg['user']['id']);						
					$this->db->where("app_kta.col10",$this->jCfg['user']['managerid']);			
				}elseif($this->jCfg['user']['userrole'] == 33){
					$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
				}
			}
			if( trim($p['type_data'])==4 ){
				if($this->jCfg['user']['userrole'] == 33){
					$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
					$this->db->where("kta_status_data",2);
					$this->db->where("kta_status_assign",0);
				}else{
					$this->db->where("app_kta.col8",$this->jCfg['user']['id']);								
				}				
			}
			if( trim($p['type_data'])==6 ){
				if($this->jCfg['user']['userrole'] == 33){
				if(isset($p['koordata']) ){
					if($p['koordata'] != ""){
					$this->db->where("app_kta.col10",$p['koordata']);
					}else{
					$this->db->where("app_kta.col10",$this->jCfg['user']['id']);									
					}
				}
//					$this->db->where("app_kta.col14",$this->jCfg['user']['id']);			
					$this->db->where("kta_status_data",2);
					$this->db->where("kta_status_assign",1);
				}else{
					$this->db->where("app_kta.col8",$this->jCfg['user']['id']);								
				}				
			}
			if( trim($p['type_data'])==5 ){
				if($this->jCfg['user']['userrole'] == 33){
					$this->db->where("app_kta.col8",$this->jCfg['user']['id']);			
					$this->db->where("kta_status_data",2);
					$this->db->where("kta_status_assign",1);
				}else{
					$this->db->where("app_kta.col8",$this->jCfg['user']['id']);								
				}				
			}
		}

		/* where or like conditions 
		$start_time = $this->jCfg['search']['date_start'];
		$end_time = $this->jCfg['search']['date_end'];

		if( trim($this->jCfg['search']['date_start'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( DATE_FORMAT(app_kta.time_add,'%Y-%m-%d') >= '".$start_time."' AND DATE_FORMAT(app_kta.time_add,'%Y-%m-%d') <= '".$end_time."' )");
		}
		*/
		
//		if( isset($p['id']) && trim($p['id'])==3 ){
//				$this->db->where("kta_id =",$p['id']);
//		}
		// dont modified....
//		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
		foreach($column_search as $item){
			if($_POST['search']['value']) // if datatable send POST for search
			{
					if($i === 0){
						$str_like = "( ";
						$vm = $_POST['search']['value'];
						$str_like .= $i!=0?"OR":"";
						$str_like .=" ".$item." LIKE '%".$vm."%' ";			
					}
				$str_like .= " ) ";
				$this->db->where($str_like);
			}
			$i++;
		}
		
		/*
		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$vm = $this->jCfg['search']['keyword'];
			if($this->jCfg['search']['colum']=="kta_jenkel"){
				$vm = $this->jCfg['search']['keyword']=='Pria'?1:0;
			}
			$this->db->like($this->jCfg['search']['colum'],$vm);
		}
		*/

		/*if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}*/
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$qry = $this->db->get('app_kta');
		if($count==FALSE){
			$total = $this->upload_kta($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}

//		$this->db->order_by('kta_status_data','DESC');
//		$this->db->order_by('time_scan','DESC');
		//if(trim($this->jCfg['search']['order_by'])!="" && !isset($p['id']) )
			//$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
/*		if($count==FALSE){
			$total = $this->upload_kta($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
*/		

	}
	
	function get_upload()
	{
		$this->upload_kta($p=array(),$count=FALSE);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$qry = $this->db->get('app_kta');
		return $qry->result();
	}

	function count_filtered()
	{
		
		$total = 0;
		$column_order = array(null,'kta_nama_lengkap','kta_tipe_kta','time_scan','kta_no_id','time_entry','col3','col4'); //set column field database for datatable orderable
		$column_search = array('kta_nama_lengkap','kta_tipe_kta','time_scan','kta_no_id','time_entry','col3','col4');
		
		$this->db->select('app_kta.kta_id, app_kta.kta_tipe_kta,app_kta.time_scan,app_kta.time_entry, app_kta.kta_no_id, app_kta.col3, app_kta.col4, app_kta.col6, app_kta.kta_status_data
		,app_pengguna.nama_pengguna, app_user.col1');		
		$this->db->join('app_user','app_user.user_id=app_kta.col4','LEFT');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_kta.kta_pemesan','LEFT');

		if($this->jCfg['user']['userrole'] == 35){
			$this->db->where("app_kta.col4",$this->jCfg['user']['id']);
		}

		if($this->jCfg['user']['userrole'] == 34){
//			$this->db->where("app_kta.col10",$this->jCfg['user']['managerid']);
		}
		if($this->jCfg['user']['userrole'] == 33){
			if( trim($p['type_data']) != 5){
			$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
			}
		}
		if( isset($p['type_data']) && trim($p['type_data']) != "" ){
			if( trim($p['type_data'])==1 ){
				$this->db->where("kta_status_data !=",2);
			}
			if( trim($p['type_data'])==2 ){
					if($this->jCfg['user']['userrole'] == 33){
						$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
						$this->db->where("(kta_status_data = 2 OR kta_status_data = 4 OR kta_status_data = 0)");
					}elseif($this->jCfg['user']['userrole'] == 1 || $this->jCfg['user']['userrole'] == 32){
						$this->db->where("kta_status_data = 2 OR kta_status_data = 4 OR kta_status_data = 0");
					}else{
						$this->db->where("kta_status_assign",1);
//						$this->db->where("col5",$this->jCfg['user']['id']);						
						$this->db->where("col8",$this->jCfg['user']['id']);						
//						$this->db->where("app_kta.col10",$this->jCfg['user']['managerid']);			
						$this->db->where("(kta_status_data = 2 OR kta_status_data = 4 OR kta_status_data = 0)");
					}
			}
			if( trim($p['type_data'])==3 ){
				if($this->jCfg['user']['userrole'] == 32 || $this->jCfg['user']['userrole'] == 1){
					$this->db->where("(kta_status_data = 2 OR kta_status_data = 3)");
				}else{
					$this->db->where("(kta_status_data = 2 OR kta_status_data = 3 OR kta_status_data = 0)");					
				}
				if($this->jCfg['user']['userrole'] == 34){
					$this->db->where("app_kta.col4",$this->jCfg['user']['id']);						
					$this->db->where("app_kta.col10",$this->jCfg['user']['managerid']);			
				}elseif($this->jCfg['user']['userrole'] == 33){
					$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
				}
			}
			if( trim($p['type_data'])==4 ){
				if($this->jCfg['user']['userrole'] == 33){
					$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
					$this->db->where("kta_status_data",2);
					$this->db->where("kta_status_assign",0);
				}else{
					$this->db->where("app_kta.col8",$this->jCfg['user']['id']);								
				}				
			}
			if( trim($p['type_data'])==6 ){
				if($this->jCfg['user']['userrole'] == 33){
				if(isset($p['koordata']) ){
					if($p['koordata'] != ""){
					$this->db->where("app_kta.col10",$p['koordata']);
					}else{
					$this->db->where("app_kta.col10",$this->jCfg['user']['id']);									
					}
				}
//					$this->db->where("app_kta.col14",$this->jCfg['user']['id']);			
					$this->db->where("kta_status_data",2);
					$this->db->where("kta_status_assign",1);
				}else{
					$this->db->where("app_kta.col8",$this->jCfg['user']['id']);								
				}				
			}
			if( trim($p['type_data'])==5 ){
				if($this->jCfg['user']['userrole'] == 33){
					$this->db->where("app_kta.col8",$this->jCfg['user']['id']);			
					$this->db->where("kta_status_data",2);
					$this->db->where("kta_status_assign",1);
				}else{
					$this->db->where("app_kta.col8",$this->jCfg['user']['id']);								
				}				
			}
		}

		/* where or like conditions 
		$start_time = $this->jCfg['search']['date_start'];
		$end_time = $this->jCfg['search']['date_end'];

		if( trim($this->jCfg['search']['date_start'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( DATE_FORMAT(app_kta.time_add,'%Y-%m-%d') >= '".$start_time."' AND DATE_FORMAT(app_kta.time_add,'%Y-%m-%d') <= '".$end_time."' )");
		}
		*/
		
//		if( isset($p['id']) && trim($p['id'])==3 ){
//				$this->db->where("kta_id =",$p['id']);
//		}
		// dont modified....
//		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
		foreach($column_search as $item){
			if($_POST['search']['value']) // if datatable send POST for search
			{
					if($i === 0){
						$str_like = "( ";
						$vm = $_POST['search']['value'];
						$str_like .= $i!=0?"OR":"";
						$str_like .=" ".$item." LIKE '%".$vm."%' ";			
					}
				$str_like .= " ) ";
				$this->db->where($str_like);
			}
			$i++;
		}
		
		/*
		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$vm = $this->jCfg['search']['keyword'];
			if($this->jCfg['search']['colum']=="kta_jenkel"){
				$vm = $this->jCfg['search']['keyword']=='Pria'?1:0;
			}
			$this->db->like($this->jCfg['search']['colum'],$vm);
		}
		*/

		/*if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}*/
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

		$qry = $this->db->get('app_kta');
		return $qry->result();
	}

	public function count_all()
	{
		$this->db->from('app_kta');
		return $this->db->count_all_results();
	}

	function kta_list($p=array(),$count=FALSE){		
		$total = 0;

		$this->db->select('DISTINCT(kta_id) as id, app_kta.kta_nomor_kartu, app_kta.kta_id, app_kta.kta_nama_lengkap, app_kta.kta_alamat, app_kta.kta_foto_wajah, app_kta.kta_status_data, app_kta.is_cetak, app_kta.kta_tipe_kta,
		app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_pengguna.nama_pengguna, app_user.user_fullname');		
		$this->db->join('app_propinsi','app_propinsi.propinsi_kode=app_kta.kta_propinsi','LEFT');
		$this->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
		$this->db->join('app_pengguna','app_pengguna.penggunaID=app_kta.kta_pemesan','LEFT');
		$this->db->join('app_user','app_user.user_id=app_kta.col10','LEFT');
		$this->db->where("kta_status_data != 2 AND kta_status_data != 3");

		if(isset($p['pengusul']) ){
			if($p['pengusul'] != ""){
			$this->db->where("kta_pemesan",$p['pengusul']);
			}
		}

		if(isset($p['nama']) ){
			if($p['nama'] != ""){
			$this->db->where("kta_nama_lengkap LIKE '%".$p['nama']."%'");
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
		if($this->jCfg['user']['userrole'] == 33){
			$this->db->where("app_kta.col10",$this->jCfg['user']['id']);			
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}
		$this->db->order_by('kta_status_data','DESC');
		$this->db->order_by('time_scan','DESC');
		$qry = $this->db->get('app_kta');
		if($count==FALSE){
			$total = $this->upload_kta($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}	

}
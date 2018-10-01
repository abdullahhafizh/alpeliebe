<?php
function get_propinsi(){
	$CI = getCI();

	$CI->db->order_by("propinsi_nama");
	$m = $CI->db->get_where("app_propinsi",array(
		"propinsi_status"	=> 0
	))->result();

	return $m;
}
function get_jabatan(){
	$CI = getCI();

	$CI->db->order_by("jabatan_nama");
	$m = $CI->db->get_where("app_jabatan",array(
		"jabatan_status"	=> 0
	))->result();

	return $m;
}
function get_changelog(){
	$CI = getCI();
	$CI->db->order_by("changelog_date","DESC");
	$m = $CI->db->get_where("app_changelog",array(
		"changelog_status"	=> 0
	))->result();

	return $m;
}

function max_kta(){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT COUNT(kta_id) as max,
		app_propinsi.propinsi_nama as propinsi
		FROM app_kta
		INNER JOIN app_propinsi ON app_kta.kta_propinsi = app_propinsi.propinsi_kode
		GROUP BY kta_propinsi
		ORDER BY max DESC
		LIMIT 1
		")->result();
	return $m;
}
function min_kta(){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT COUNT(kta_id) as min,
		app_propinsi.propinsi_nama as propinsi
		FROM app_kta
		INNER JOIN app_propinsi ON app_kta.kta_propinsi = app_propinsi.propinsi_kode
		GROUP BY kta_propinsi
		ORDER BY min ASC
		LIMIT 1
		")->result();
	return $m;
}

function get_version(){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT *
		FROM app_changelog 
		ORDER BY DATE_FORMAT(changelog_date,'%Y-%m-%d %h:%i:%s') DESC
		LIMIT 1
		")->result();
	return $m;
}

function get_maintenance(){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT *
		FROM app_maintenance
		WHERE maintenance_status = '1'
		")->result();
	return $m;
}


function get_user_role($st=""){
	$CI = getCI();
	$m = $CI->db->get_where("app_acl_group",array(
		"level"	=> $st
	))->result();
	return $m;
}
function get_role_list($st=""){
	$CI = getCI();
	$m = $CI->db->get_where("app_acl_group",array(
		"ag_id"	=> $st
	))->result();
	return $m;
}

function get_manager(){
	$CI = getCI();
	$CI->db->select("app_user.*,app_user_group.ug_group_id");
	$CI->db->join("app_user_group","app_user.user_id = app_user_group.ug_user_id");
	$m = $CI->db->get_where("app_user",array(
		"app_user_group.ug_group_id"	=> 33
	))->result();

	return $m;
}

function get_user($st=""){
	$CI = getCI();
	$CI->db->select("app_user.*,app_user_group.ug_group_id");
	$CI->db->join("app_user_group","app_user.user_id = app_user_group.ug_user_id");
	$m = $CI->db->get_where("app_user",array(
		"app_user.user_id"				=> $st
	))->result();

	return $m;
}

function get_user_all(){
	$CI = getCI();
	$CI->db->select("app_user.*,app_user_group.ug_group_id");
	$CI->db->order_by("col2", "DESC");
	$CI->db->join("app_user_group","app_user.user_id = app_user_group.ug_user_id");
	$m = $CI->db->get_where("app_user",array(
		"app_user.user_status"			=> 1
	))->result();

	return $m;
}
function get_user_list($st=""){
	$CI = getCI();
	$CI->db->select("app_user.*,app_user_group.ug_group_id");
	$CI->db->join("app_user_group","app_user.user_id = app_user_group.ug_user_id");
	$m = $CI->db->get_where("app_user",array(
		"app_user.col1"				=> $st
	))->result();

	return $m;
}

function get_data_entry($st=""){
	$CI = getCI();
	$CI->db->select("app_user.*,app_user_group.ug_group_id");
	$CI->db->join("app_user_group","app_user.user_id = app_user_group.ug_user_id");
	$m = $CI->db->get_where("app_user",array(
		"app_user_group.ug_group_id"	=> 34,
		"app_user.col1"					=> $st
	))->result();
	return $m;
}

function get_card_admin(){
	$CI = getCI();
	$CI->db->select("app_user.*,app_user_group.ug_group_id");
	$CI->db->join("app_user_group","app_user.user_id = app_user_group.ug_user_id");
	$m = $CI->db->get_where("app_user",array(
		"app_user_group.ug_group_id"	=> 32
	))->result();
	return $m;
}

function get_hc_key(){
	$CI = getCI();
	$m = $CI->db->get_where("app_propinsi",array(
		"propinsi_status"	=> 0
	))->result();

	return $m;
}

function get_news(){
	$CI = getCI();
	$CI->db->order_by("time_add", "DESC");
	$m = $CI->db->get_where("app_news",array(
		"news_status"	=> 0
	))->result();

	return $m;
}

function get_path($st=""){
	$CI = getCI();
	$m = $CI->db->get_where("app_kabupaten",array(
		"kab_propinsi_id"	=> $st
	))->result();

	return $m;
}
function get_path_value($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_kabupaten',$st);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}
function get_pengusul_value($st="",$mt=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_kabupaten',$st);
		$CI->db->where('kta_pemesan',$mt);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}
function get_kec($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kec_kab_id',$st);
	}
	$m = $CI->db->get("app_kecamatan")->num_rows();
	return $m;
}
function get_kel($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kel_kab_id',$st);
	}
	$m = $CI->db->get("app_kelurahan")->num_rows();
	return $m;
}



function get_prov_detail($st=""){
	$CI = getCI();
	$m = $CI->db->get_where("app_propinsi",array(
		"hc_key"	=> $st
	))->result();

	return $m;
}

function get_pekerjaan(){
	$CI = getCI();
	$CI->db->order_by("pekerjaan_id","ASC");
	$m = $CI->db->get_where("app_pekerjaan",array(
		"pekerjaan_status"	=> 0
	))->result();

	return $m;
}
function get_pemesan($st=""){
	$CI = getCI();
	$CI->db->order_by("nama_pengguna");
	$m = $CI->db->get_where("app_pengguna",array(
		"status_pengguna"	=> 1,
		"tingkat_pengguna"	=> $st,
		"is_trash"			=> 0
	))->result();

	return $m;
}
function get_pengusul($st=""){
	$CI = getCI();
	$CI->db->order_by("nama_pengguna");
	$m = $CI->db->get_where("app_pengguna",array(
		"status_pengguna"	=> 1,
		"is_trash"			=> 0
	))->result();

	return $m;
}

function get_kta_expired(){
	$CI = getCI();
	$CI->load->model("master/mdl_master","M");
	$data = $CI->M->kta(array(
		"offset"    => 0,
		"limit"     => 6,
		"type_data" => 3,
		"param"     => array(
			"" => "all"
		)
	));

	return $data['data'];
}

function get_agama(){
	$CI = getCI();

	$CI->db->order_by("agama_id");
	$m = $CI->db->get_where("app_agama",array(
		"agama_status"	=> 0
	))->result();

	return $m;
}

function agama($st=""){
	$CI = getCI();

	$CI->db->order_by("agama_nama");
	$m = $CI->db->get_where("app_agama",array(
		"agama_id"	=> $st
	))->result();

	return $m;
}

function pekerjaan($st=""){
	$CI = getCI();

	$CI->db->order_by("pekerjaan_nama");
	$m = $CI->db->get_where("app_pekerjaan",array(
		"pekerjaan_id"	=> $st
	))->result();

	return $m;
}

function get_max_kel_kode(){
	$CI = getCI();

	$CI->db->select("MAX(kel_kode) as kel");
	$m = $CI->db->get("app_kelurahan")->result();
	return $m;
}

function get_rincian_pembayaran($tgl=""){
	$CI = getCI();

	$CI->db->select("app_kta.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama");
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_kta.kta_propinsi','LEFT');
	$CI->db->join('app_kabupaten','app_kabupaten.kab_id=app_kta.kta_kabupaten','LEFT');


	if( trim($CI->jCfg['search']['colum'])!="" ){
		$CI->db->where("app_propinsi.propinsi_id",$CI->jCfg['search']['colum']);
	}


	if( trim($CI->jCfg['search']['keyword']) != "" ){
		$CI->db->where("app_kabupaten.kab_id",$CI->jCfg['search']['keyword']);
	}

	$start_time = $CI->jCfg['search']['date_start']."";
	$end_time = $CI->jCfg['search']['date_end']."";

	if( trim($CI->jCfg['search']['date_start'])!="" && trim($CI->jCfg['search']['date_end']) != "" ){
		$CI->db->where("( app_kta.kta_tgl_bayar_2 >= '".$start_time."' AND app_kta.kta_tgl_bayar_2 <= '".$end_time."' )");
	}

	$CI->db->order_by("kta_tgl_bayar_2","DESC");
	$m = $CI->db->get_where("app_kta",array(
		"kta_lunas"			=> 1,
		"kta_tgl_bayar_2"	=> $tgl
	))->result();

	return $m;
}

function get_rincian_kta_by_prov($prov=""){
	$CI = getCI();

	$CI->db->select('count(app_kabupaten.kab_nama) as jumlah,app_kabupaten.kab_nama as nama');
	$CI->db->join('app_kabupaten','app_kabupaten.kab_id=app_kta.kta_kabupaten');
	$CI->db->where("app_kabupaten.kab_nama !=","");
	$CI->db->where("app_kta.kta_propinsi",$prov);

	if( trim($CI->jCfg['search']['keyword']) != "" ){
		$CI->db->where("app_kabupaten.kab_id",$CI->jCfg['search']['keyword']);
	}

	$start_time = $CI->jCfg['search']['date_start']." 01:00:00";
	$end_time = $CI->jCfg['search']['date_end']." 23:59:00";
	if( trim($CI->jCfg['search']['date_start'])!="" && trim($CI->jCfg['search']['date_end']) != "" ){
		$CI->db->where("( app_kta.time_add >= '".$start_time."' AND app_kta.time_add <= '".$start_time."' )");
	}


	$CI->db->order_by("count(app_kabupaten.kab_nama)","DESC");
	$CI->db->group_by('app_propinsi.kta_propinsi');
	$m = $CI->db->get("app_kta")->result();
	return $m;
}

function get_rincian_kta_by_kab($prov=""){
	$CI = getCI();

	$CI->db->select('count(app_kecamatan.kec_nama) as jumlah,app_kecamatan.kec_nama as nama');
	$CI->db->join('app_kecamatan','app_kecamatan.kec_id=app_kta.kta_kecamatan');
	$CI->db->where("app_kecamatan.kec_nama !=","");
	$CI->db->where("app_kta.kta_kabupaten",$prov);

	if( trim($CI->jCfg['search']['keyword']) != "" ){
		$CI->db->where("app_kecamatan.kec_id",$CI->jCfg['search']['keyword']);
	}

	$start_time = $CI->jCfg['search']['date_start']." 01:00:00";
	$end_time = $CI->jCfg['search']['date_end']." 23:59:00";
	if( trim($CI->jCfg['search']['date_start'])!="" && trim($CI->jCfg['search']['date_end']) != "" ){
		$CI->db->where("( app_kta.time_add >= '".$start_time."' AND app_kta.time_add <= '".$start_time."' )");
	}


	$CI->db->order_by("count(app_kecamatan.kec_nama)","DESC");
	$CI->db->group_by('app_kta.kta_kecamatan');
	$m = $CI->db->get("app_kta")->result();
	return $m;
}

function get_undian(){
	$CI = getCI();

	$CI->db->select("undian_id,undian_name");
	$CI->db->order_by("undian_name");
	$m = $CI->db->get_where("app_undian",array(
		"undian_status"	=> 0
	))->result();

	return $m;
}

function get_event(){
	$CI = getCI();

	$CI->db->order_by("event_name");
	$m = $CI->db->get_where("app_event",array(
		"event_status"	=> 0
	))->result();

	return $m;
}

function get_detail_pemenang($kd_id=""){
	$CI = getCI();
	$CI->db->select("app_kta.*,(TIMESTAMPDIFF(YEAR, app_kta.kta_tgl_lahir, CURDATE())) as umur");
	$CI->db->join("app_kocok_undian_pemenang","app_kocok_undian_pemenang.kp_kta_id = app_kta.kta_id");
	$CI->db->where("app_kocok_undian_pemenang.kp_kd_id",$kd_id);
	$m = $CI->db->get_where("app_kta",array(
		"kta_status"	=> 1
	))->result();

	return $m;
}

function get_evant_name($id){
	$CI = getCI();
	$m = $CI->db->get_where("app_event",array(
		"event_status"	=> 0,
		"event_id"		=> $id
	))->row();

	return isset($m->event_name)?$m->event_name:'-';
}

//dashbiard helder

function get_user_online($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('col2',$st);
	}
	$m = $CI->db->get("app_user")->num_rows();
	return $m;
}

function get_user_online_koor($st="",$mt=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('col1',$st);
		$CI->db->where('col2',$st);
	}
	$m = $CI->db->get("app_user")->num_rows();
	return $m;
}

function get_user_koor($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('col1',$st);
	}
	$m = $CI->db->get("app_user")->num_rows();
	return $m;
}

function get_kta_aktif($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_status',$st);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_total_province(){
	$CI = getCI();
	$m = $CI->db->get("app_propinsi")->num_rows();
	return $m;
}

function get_total_kabupaten($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kab_propinsi_id',$st);
	}
	$m = $CI->db->get("app_kabupaten")->num_rows();
	return $m;
}

function get_total_kecamatan($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kec_prop_id',$st);
	}
	$m = $CI->db->get("app_kecamatan")->num_rows();
	return $m;
}

function get_total_kelurahan($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kel_prop_id',$st);
	}
	$m = $CI->db->get("app_kelurahan")->num_rows();
	return $m;
}

function get_ktp($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_no_id',$st);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_sum_kab($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kab_propinsi_id',$st);
	}
	$m = $CI->db->get("app_kabupaten")->num_rows();
	return $m;
}

function get_sum_pengusul($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('propinsi_id',$st);
	}
	$m = $CI->db->get("app_pengguna")->num_rows();
	return $m;
}

function get_kta_prov_aktif($st="",$prov=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_status_data',$st);
		$CI->db->where('kta_pemesan',$prov);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_kta_data($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_status_data',$st);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_total_pengusul($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_pemesan',$st);
//		$CI->db->where('tingkat_pengguna','DPD');
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_kta_jk($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_jenkel',$st);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_kta_prov_jk($st="",$prov=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_jenkel',$st);
		$CI->db->where('kta_pemesan',$prov);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_kta_kartu($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('is_cetak',$st);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_kta_prov_kartu($st="",$prov=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('is_cetak',$st);
		$CI->db->where('kta_pemesan',$prov);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_kta_order($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_order_id',$st);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_total_by_prop($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_propinsi',$st);
		$CI->db->where('kta_status_data',1);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_pengusul_prop($st=""){
	$CI = getCI();

	$CI->db->order_by("nama_pengguna");
	$m = $CI->db->get_where("app_pengguna",array(
		"propinsi_id"	=> $st,
		"tingkat_pengguna"	=> 'DPD'
	))->result();

	return $m;
}

function get_r_by_prop(){
	$CI = getCI();
	$CI->db->select('count(kta_id) as jumlah, app_propinsi.propinsi_nama as nama');
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_kta.kta_propinsi','RIGHT');
	$CI->db->group_by('app_propinsi.kta_propinsi');
	$m = $CI->db->get("app_kta")->result();
	return $m;
}

function get_total_kop_by_prop($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('koperasi_prop',$st);
	}
	$m = $CI->db->get("app_koperasi_cabang")->num_rows();
	return $m;
}

function get_total_asuransi($st=""){
	$CI = getCI();
	if(trim($st)!=""){
		$CI->db->where('kta_status_asuransi',$st);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_total_gender($st="",$pt=""){
	$CI = getCI();
	if(trim($st)!="" || trim($pt)!=""){
		$CI->db->where('kta_jenkel',$st);
		$CI->db->where('kta_propinsi',$pt);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_total_pekerjaan($st="",$pt=""){
	$CI = getCI();
	if(trim($st)!="" || trim($pt)!=""){
		$CI->db->where('kta_pekerjaan',$st);
		$CI->db->where('kta_propinsi',$pt);
	}
	$m = $CI->db->get("app_kta")->num_rows();
	return $m;
}

function get_total_umur($st="",$mt="",$pt=""){
	$CI = getCI();
	if(trim($st)!="" || trim($pt)!=""){
		$m = $CI->db->get_where("app_kta",array(
			"kta_umur >"	=> $st,
			"kta_umur <"	=> $mt,
			"kta_propinsi ="  => $pt
		))->num_rows();
	}
	return $m;
}

function get_pie_status(){
	$CI = getCI();
	$CI->db->select('kta_status as nama, count(kta_id) as jumlah');
	$CI->db->group_by('kta_status');
	$m = $CI->db->get_where("app_kta",array(
		"kta_id !="	=> ''
	))->result();
	return $m;
}

function get_detail_pengusul($st=""){
	$CI = getCI();
	$CI->db->select('nama_pengguna as nama');
	$m = $CI->db->get_where("app_pengguna",array(
		"penggunaID"	=> $st
	))->result();
	return $m;
}

function get_detail_koor($st=""){
	$CI = getCI();
	$CI->db->select('user_fullname as nama');
	$m = $CI->db->get_where("app_user",array(
		"user_id"	=> $st
	))->result();
	return $m;
}

function get_anggota_baru($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_scan,'%Y-%m-%d') as tgl, count(kta_id) as jumlah 
		FROM app_kta 
		WHERE kta_propinsi = ".$st."
		AND time_scan between (DATE_FORMAT(CURDATE(),'%Y-%m-%d') - INTERVAL 31 DAY ) and DATE_FORMAT(CURDATE(),'%Y-%m-%d')
		GROUP BY DATE_FORMAT(time_scan,'%Y-%m-%d')
		ORDER BY DATE_FORMAT(time_scan,'%Y-%m-%d') ASC
		")->result();
	return $m;
}

function get_anggota_pengusul($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_scan,'%Y-%m-%d') as tgl, count(kta_id) as jumlah 
		FROM app_kta 
		WHERE kta_pemesan = ".$st."
		AND time_scan between (DATE_FORMAT(CURDATE(),'%Y-%m-%d') - INTERVAL 31 DAY ) and DATE_FORMAT(CURDATE(),'%Y-%m-%d')
		GROUP BY DATE_FORMAT(time_scan,'%Y-%m-%d')
		ORDER BY DATE_FORMAT(time_scan,'%Y-%m-%d') ASC
		")->result();
	return $m;
}

function get_anggota_koor($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_add,'%Y-%m-%d') as tgl, count(kta_id) as jumlah 
		FROM app_kta 
		WHERE col10 = '".$st."' AND kta_status_data = '1'
		GROUP BY DATE_FORMAT(time_add,'%Y-%m-%d')
		LIMIT 30
		")->result();
//		ORDER BY DATE_FORMAT(time_add,'%Y-%m-%d') ASC
	return $m;
}

function get_topup_baru($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(topup_date,'%Y-%m-%d') as tgl, count(topup_id) as jumlah 
		FROM app_topup 
		GROUP BY DATE_FORMAT(topup_date,'%Y-%m-%d') DESC
		ORDER BY DATE_FORMAT(topup_date,'%Y-%m-%d') ASC
		LIMIT 30
		")->result();
	return $m;
}

function get_grafik_upload($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_scan,'%Y-%m-%d') as tgl, count(kta_id) as jumlah, count(kta_status_data) as total 
		FROM app_kta 
		WHERE col4 = '".$st."'
		AND time_scan between (DATE_FORMAT(CURDATE(),'%Y-%m-%d') - INTERVAL 31 DAY ) and DATE_FORMAT(CURDATE(),'%Y-%m-%d')
		GROUP BY DATE_FORMAT(time_scan,'%Y-%m-%d')
		ORDER BY DATE_FORMAT(time_scan,'%Y-%m-%d') ASC
		")->result();
	return $m;
}

function get_grafik_entry($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_entry,'%Y-%m-%d') as tgl, count(kta_id) as jumlah, count(kta_status_data) as total 
		FROM app_kta 
		WHERE col5 = '".$st."'
		GROUP BY DATE_FORMAT(time_entry,'%Y-%m-%d') DESC
		ORDER BY DATE_FORMAT(time_entry,'%Y-%m-%d') ASC
		LIMIT 30
		")->result();
	return $m;
}

function get_grafik_koor($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		select
		DATE_FORMAT(app_kta.time_add, '%d-%m-%Y') as tgl, user_fullname,
		COUNT(if(time_approve, kta_id, NULL)) as approve,
		COUNT(if(time_entry, kta_id, NULL)) as entry,
		COUNT(if(time_scan, kta_id, NULL)) as upload
		FROM
		app_kta
		INNER JOIN app_user ON app_kta.col10 = app_user.user_id
		WHERE app_kta.col10 = '$st'
		AND app_kta.time_add BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() + 1				
		GROUP BY
		DATE_FORMAT(app_kta.time_add, '%d-%m-%Y')
		ORDER BY DATE_FORMAT(app_kta.time_add, '%Y-%m-%d') ASC

		")->result();
	return $m;
}

function get_list_data($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_scan,'%Y-%m-%d') as tgl, 
		(SELECT count(kta_status_data) FROM app_kta WHERE
		DATE_FORMAT(time_scan,'%Y-%m-%d') = tgl
		AND col4= '".$st."') as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '0' AND 
		DATE_FORMAT(time_scan,'%Y-%m-%d') = tgl
		AND col4 = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3' AND 
		DATE_FORMAT(time_scan,'%Y-%m-%d') = tgl
		AND col4 = '".$st."') as data_reject
		FROM app_kta 
		WHERE col4 = '".$st."'
		GROUP BY DATE_FORMAT(time_scan,'%Y-%m-%d') DESC
		ORDER BY DATE_FORMAT(time_scan,'%Y-%m-%d') ASC
		LIMIT 30
		")->result();
	return $m;
}

function get_list_koor($mt=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_scan,'%Y-%m-%d') as tgl, 
		(SELECT count(kta_status_data) FROM app_kta WHERE
		DATE_FORMAT(time_scan,'%Y-%m-%d') = tgl
		AND col10= '".$mt."') as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '0' AND 
		DATE_FORMAT(time_scan,'%Y-%m-%d') = tgl
		AND col10= '".$mt."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3' AND 
		DATE_FORMAT(time_scan,'%Y-%m-%d') = tgl
		AND col10= '".$mt."') as data_reject
		FROM app_kta 
		WHERE col10 = '".$mt."'
		GROUP BY DATE_FORMAT(time_scan,'%Y-%m-%d') DESC
		ORDER BY DATE_FORMAT(time_scan,'%Y-%m-%d') ASC
		LIMIT 30
		")->result();
	return $m;
}


function get_total_data($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT
		(SELECT count(kta_status_data) FROM app_kta WHERE
		col4= '".$st."') as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE
		col5 = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3' AND 
		col4 = '".$st."') as data_reject,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4' AND 
		col4 = '".$st."') as data_reject_entry
		FROM app_kta 
		WHERE col4 = '".$st."'
		LIMIT 1
		")->result();
	return $m;
}

function get_total_koor_data($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT
		(SELECT count(kta_status_data) FROM app_kta WHERE
		col4= '".$st."') as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE
		col5 = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3' AND 
		col4 = '".$st."') as data_reject,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4' AND 
		col5 = '".$st."') as data_reject_entry
		FROM app_kta 
		WHERE col10 = '".$st."'
		LIMIT 1
		")->result();
	return $m;
}

function get_total_entry_data($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT
		(SELECT count(kta_status_data) FROM app_kta WHERE
		col4= '".$st."') as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE 
		col5 = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3' AND 
		col4 = '".$st."') as data_reject,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4' AND 
		col5 = '".$st."') as data_reject_entry
		FROM app_kta 
		WHERE col5 = '".$st."'
		LIMIT 1
		")->result();
	return $m;
}

function get_total_koor($mt=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '2' AND
		col10= '".$mt."') as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '0' AND 
		col10= '".$mt."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3' AND 
		col10= '".$mt."') as data_reject_scan,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4' AND 
		col10= '".$mt."') as data_reject_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '1' AND 
		col10= '".$mt."') as data_approve,
		(SELECT count(kta_status_data) FROM app_kta WHERE col10= '".$mt."') as data_total		
		FROM app_kta 
		WHERE col10 = '".$mt."'
		LIMIT 1
		")->result();
	return $m;
}
function get_total_admin(){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '2') as registrasi,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '1') as terdaftar,
		(SELECT count(is_cetak) FROM app_kta WHERE is_cetak = '0' ) as belum_cetak,
		(SELECT count(is_cetak) FROM app_kta WHERE is_cetak = '1' ) as tercetak,
		(SELECT count(kta_id) FROM app_kta ) as data_total		
		FROM app_kta 
		LIMIT 1
		")->result();
	return $m;
}

function get_total_propinsi($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '2' AND kta_propinsi = '".$st."')   as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '0'  AND kta_propinsi = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3'  AND kta_propinsi = '".$st."') as data_reject_scan,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4'  AND kta_propinsi = '".$st."') as data_reject_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '1'  AND kta_propinsi = '".$st."') as data_approve,
		(SELECT count(is_cetak) FROM app_kta WHERE is_cetak = '0'  AND kta_propinsi = '".$st."') as belum_cetak,
		(SELECT count(is_cetak) FROM app_kta WHERE is_cetak = '1'  AND kta_propinsi = '".$st."') as tercetak,
		(SELECT count(kta_id) FROM app_kta WHERE kta_propinsi = '".$st."') as data_total		
		FROM app_kta 
		WHERE app_kta.kta_propinsi = '".$st."'
		LIMIT 1
		")->result();
	return $m;
}

function get_total_peng($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '2' AND kta_pemesan = '".$st."')   as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '0'  AND kta_pemesan = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3'  AND kta_pemesan = '".$st."') as data_reject_scan,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4'  AND kta_pemesan = '".$st."') as data_reject_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '1'  AND kta_pemesan = '".$st."') as data_approve,
		(SELECT count(is_cetak) FROM app_kta WHERE is_cetak = '0'  AND kta_pemesan = '".$st."') as belum_cetak,
		(SELECT count(is_cetak) FROM app_kta WHERE is_cetak = '1'  AND kta_pemesan = '".$st."') as tercetak,
		(SELECT count(kta_id) FROM app_kta WHERE kta_pemesan = '".$st."') as data_total		
		FROM app_kta 
		WHERE app_kta.kta_pemesan = '".$st."'
		LIMIT 1
		")->result();
	return $m;
}

function get_total_koordata($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '2' AND col10 = '".$st."')   as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '0'  AND col10 = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '3'  AND col10 = '".$st."') as data_reject_scan,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4'  AND col10 = '".$st."') as data_reject_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '1'  AND col10 = '".$st."') as data_approve,
		(SELECT count(is_cetak) FROM app_kta WHERE is_cetak = '0'  AND col10 = '".$st."') as belum_cetak,
		(SELECT count(is_cetak) FROM app_kta WHERE is_cetak = '1'  AND col10 = '".$st."') as tercetak,
		(SELECT count(kta_id) FROM app_kta WHERE col10 = '".$st."') as data_total		
		FROM app_kta 
		WHERE app_kta.col10 = '".$st."'
		LIMIT 1
		")->result();
	return $m;
}

function get_total_entry($st="",$mt=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_scan,'%m-%d') as tgl, 
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '2' AND
		col10= '".$mt."') as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '0' AND 
		col5 = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4' AND 
		col5 = '".$st."') as data_reject
		FROM app_kta 
		WHERE col5 = '".$st."'
		LIMIT 1
		")->result();
	return $m;
}

function get_list_entry($st="",$mt=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_entry,'%Y-%m-%d') as tgl, 
		(SELECT count(kta_status_data) FROM app_kta WHERE 
		DATE_FORMAT(time_scan,'%Y-%m-%d') = tgl
		AND col10= '".$mt."') as data_upload,
		(SELECT count(kta_status_data) FROM app_kta WHERE 
		DATE_FORMAT(time_entry,'%Y-%m-%d') = tgl
		AND col5 = '".$st."') as data_entry,
		(SELECT count(kta_status_data) FROM app_kta WHERE kta_status_data = '4' AND 
		DATE_FORMAT(time_entry,'%Y-%m-%d') = tgl
		AND col5 = '".$st."') as data_reject
		FROM app_kta 
		WHERE col5 = '".$st."'
		GROUP BY DATE_FORMAT(time_entry,'%Y-%m-%d') DESC
		ORDER BY DATE_FORMAT(time_entry,'%Y-%m-%d') ASC
		LIMIT 30
		")->result();
	return $m;
}

function get_list_anggota($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT kta_nama_lengkap, kta_nomor_kartu, app_kta.time_add, app_kabupaten.kab_nama
		FROM app_kta 
		INNER JOIN app_kabupaten ON app_kabupaten.kab_kode = app_kta.kta_kabupaten
		WHERE kta_propinsi = ".$st."
		ORDER BY DATE_FORMAT(app_kta.time_add,'%Y-%m-%d') DESC
		LIMIT 30
		")->result();
	return $m;
}

function get_rekap_entry($st="",$datefrom="",$dateto=""){	
	$CI = getCI();
	$m = $CI->db->query("
		select DATE_FORMAT(time_entry, '%d %M %Y') as tgl, COUNT(kta_id) as jumlah_entry, col5
		FROM app_kta
		WHERE
		(DATE_FORMAT(time_entry, '%Y-%m-%d') >= '".$datefrom."' AND DATE_FORMAT(time_entry, '%Y-%m-%d') <= '".$dateto."')
		AND col5 = '".$st."'
		GROUP BY DATE_FORMAT(app_kta.time_entry,'%Y-%m-%d') DESC
		ORDER BY DATE_FORMAT(app_kta.time_entry,'%Y-%m-%d') ASC
		")->result();
	return $m;
}

function get_rekap_dashboard($st="",$mt="",$pt="",$qt=""){	
	$CI = getCI();
	$m = $CI->db->query("
		select DATE_FORMAT(".$mt.", '%d %M %Y') as tgl, COUNT(kta_id) as jumlah, ".$pt."
		FROM app_kta
		WHERE ".$pt." = '".$st."'
		AND $mt BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() + 1		
		GROUP BY DATE_FORMAT(app_kta.".$mt.",'%Y-%m-%d')
		ORDER BY DATE_FORMAT(app_kta.".$mt.",'%Y-%m-%d') $qt
		")->result();
	return $m;
}

function get_list_pengusul(){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT * , app_propinsi.propinsi_nama
		FROM app_pengguna 
		INNER JOIN app_propinsi ON app_propinsi.propinsi_id = app_pengguna.propinsi_id
		ORDER BY DATE_FORMAT(app_pengguna.time_add,'%Y-%m-%d') DESC
		LIMIT 30
		")->result();
	return $m;
}

function get_list_data_reject($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT *
		FROM app_kta 
		WHERE kta_status_data = '".$st."'
		ORDER BY DATE_FORMAT(app_kta.time_add,'%Y-%m-%d') DESC
		LIMIT 30
		")->result();
	return $m;
}

function get_list_data_entry($st=""){
	$tdy = date("Y-m-d");
	$CI = getCI();
	$m = $CI->db->query("
		SELECT *
		FROM app_kta 
		WHERE kta_status_data = '2'
		AND col10 = '".$st."'
		AND DATE_FORMAT(time_add,'%Y-%m-%d') = '".$tdy."'
		ORDER BY DATE_FORMAT(app_kta.time_add,'%Y-%m-%d') DESC
		LIMIT 30
		")->result();
	return $m;
}

function get_order_baru($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(order_date,'%Y-%m-%d') as tgl, count(order_id) as jumlah 
		FROM app_order 		
		WHERE order_propinsi = ".$st."
		GROUP BY DATE_FORMAT(order_date,'%Y-%m-%d')
		ORDER BY DATE_FORMAT(order_date,'%Y-%m-%d') DESC
		LIMIT 30
		")->result();
	return $m;
}

function get_batch($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT app_data_cetak.*, app_pengguna.nama_pengguna, app_propinsi.nama_propinsi, app_kabupaten.nama_kabupaten 
		FROM app_data_cetak
		INNER JOIN app_pengguna ON app_pengguna.penggunaID = app_data_cetak.cetak_pengusul
		INNER JOIN app_propinsi ON app_propinsi.propinsi_kode = app_data_cetak.cetak_propinsi
		INNER JOIN app_kabupaten ON app_kabupaten.kab_kode = app_data_cetak.cetak_kabupaten
		WHERE cetak_kode = ".$st."
		")->result();
	return $m;
}

function get_list_order($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT app_order.*, app_pengguna.nama_pengguna
		FROM app_order 		
		INNER JOIN app_pengguna ON app_pengguna.penggunaID = app_order.order_pengguna
		WHERE order_propinsi = ".$st."
		GROUP BY DATE_FORMAT(order_date,'%Y-%m-%d')
		ORDER BY DATE_FORMAT(order_date,'%Y-%m-%d') DESC
		LIMIT 30
		")->result();
	return $m;
}

function get_list_topup(){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT app_topup.*, app_pengguna.nama_pengguna, app_propinsi.propinsi_nama
		FROM app_topup 		
		INNER JOIN app_pengguna ON app_pengguna.penggunaID = app_topup.penggunaID
		INNER JOIN app_propinsi ON app_pengguna.propinsi_id = app_propinsi.propinsi_id
		GROUP BY DATE_FORMAT(topup_date,'%Y-%m-%d')
		ORDER BY DATE_FORMAT(topup_date,'%Y-%m-%d') DESC
		LIMIT 30
		")->result();
	return $m;
}


function get_pie_pekerjaan(){
	$CI = getCI();
	$CI->db->select('kta_pekerjaan as nama, count(kta_id) as jumlah');
	$CI->db->group_by('kta_pekerjaan');
	$m = $CI->db->get_where("app_kta",array(
		"kta_id !="	=> ''
	))->result();
	return $m;
}

function get_pie_umur($st="",$mt=""){
	$CI = getCI();
	if(trim($st)!="" || trim($pt)!=""){
		$m = $CI->db->get_where("app_kta",array(
			"kta_umur >"	=> $st,
			"kta_umur <"	=> $mt
		))->num_rows();
	}
	return $m;
}

function get_kab_list($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		select app_kecamatan.kec_kode, app_kecamatan.kec_nama, app_kabupaten.kab_nama, app_kabupaten.kab_kode,
		(select count(kta_id) as jumlah FROM app_kta WHERE 
		app_kta.kta_jenkel = 1 AND app_kta.kta_kecamatan = kec_kode) as laki,
		(select count(kta_id) as jumlah FROM app_kta WHERE 
		app_kta.kta_jenkel = 0 AND app_kta.kta_kecamatan = kec_kode) as perempuan  
		FROM app_kecamatan
		LEFT JOIN app_kta ON app_kecamatan.kec_kode = app_kta.kta_kecamatan
		LEFT JOIN app_kabupaten ON app_kabupaten.kab_kode = app_kecamatan.kec_kab_id
		WHERE kec_kode LIKE '".$st."%'
		GROUP BY kec_nama
		ORDER BY kab_nama ASC
		")->result();
	return $m;
}

function get_kec_list($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		select app_kelurahan.kel_kode, app_kecamatan.kec_nama, app_kelurahan.kel_nama,  app_kecamatan.kec_kode,
		(select count(kta_id) as jumlah FROM app_kta WHERE 
		app_kta.kta_jenkel = 1 AND app_kta.kta_kelurahan = kel_kode) as laki,
		(select count(kta_id) as jumlah FROM app_kta WHERE 
		app_kta.kta_jenkel = 0 AND app_kta.kta_kelurahan = kel_kode) as perempuan  
		FROM app_kelurahan
		LEFT JOIN app_kta ON app_kelurahan.kel_kode = app_kta.kta_kelurahan
		LEFT JOIN app_kecamatan ON app_kecamatan.kec_kode = app_kelurahan.kel_kec_id
		WHERE kel_kode LIKE '".$st."%'
		GROUP BY kel_nama
		ORDER BY kec_nama ASC
		")->result();
	return $m;
}

function get_pie_gender($st=""){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT count(kta_id) as jumlah , kta_jenkel as nama
		FROM app_kta
		WHERE app_kta.kta_status_data = '1' 
		OR app_kta.kta_status_data = '0' 
		OR app_kta.kta_status_data = '3' 
		OR app_kta.kta_status_data = '4'
		AND kta_jenkel = '".$st."'
		")->result();
	return $m;
}

function get_domisili($st=""){
	$CI = getCI();
	$CI->db->select('propinsi_nama as nama');
	$CI->db->group_by('propinsi_nama');
	$m = $CI->db->get_where("app_propinsi",array(
		"propinsi_id"	=> $st
	))->result();
	return $m;
}

function get_saldo($st=""){
	$CI = getCI();
	$CI->db->select('saldo_pengguna as saldo');
	$CI->db->group_by('penggunaID');
	$m = $CI->db->get_where("app_pengguna",array(
		"penggunaID"	=> $st
	))->result();
	return $m;
}

function get_domisili_kta($st=""){
	$CI = getCI();
	$CI->db->select('app_kta.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama, app_negara.negara_nama');		
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_kta.kta_propinsi','LEFT');
	$CI->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
	$CI->db->join('app_kecamatan','app_kecamatan.kec_kode=app_kta.kta_kecamatan','LEFT');
	$CI->db->join('app_kelurahan','app_kelurahan.kel_kode=app_kta.kta_kelurahan','LEFT');
	$CI->db->join('app_negara','app_negara.negara_kode=app_propinsi.negara_kode','LEFT');
//	$CI->db->group_by('propinsi_nama');
	$m = $CI->db->get_where("app_kta",array(
		"kta_id"	=> $st
	))->result();
	return $m;
}

function get_kab($st=""){
	$CI = getCI();
	$CI->db->select('app_propinsi.propinsi_nama,app_kabupaten.kab_nama');		
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_kabupaten.kab_propinsi_id','LEFT');
//	$CI->db->group_by('propinsi_nama');
	$m = $CI->db->get_where("app_kabupaten",array(
		"kab_kode"	=> $st
	))->result();
	return $m;
}

function get_dpp_kta($st=""){
	$CI = getCI();
	$CI->db->select('app_kta.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama');		
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_kta.kta_tingkatan_provinsi','LEFT');
	$CI->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_tingkatan_kabkota','LEFT');
	$CI->db->join('app_kecamatan','app_kecamatan.kec_kode=app_kta.kta_tingkatan_kecamatan','LEFT');
	$CI->db->join('app_kelurahan','app_kelurahan.kel_kode=app_kta.kta_tingkatan_desa','LEFT');
//	$CI->db->group_by('propinsi_nama');
	$m = $CI->db->get_where("app_kta",array(
		"kta_id"	=> $st
	))->result();
	return $m;
}

function get_order($st=""){
	$CI = getCI();
	$CI->db->select('app_kta.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama');		
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_kta.kta_propinsi','LEFT');
	$CI->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten','LEFT');
	$CI->db->join('app_kecamatan','app_kecamatan.kec_kode=app_kta.kta_kecamatan','LEFT');
	$CI->db->join('app_kelurahan','app_kelurahan.kel_kode=app_kta.kta_kelurahan','LEFT');
//	$CI->db->group_by('propinsi_nama');
	$m = $CI->db->get_where("app_kta",array(
		"kta_order_id"	=> $st
	))->result();
	return $m;
}

function get_detail_pemesan($st=""){
	$CI = getCI();
	$CI->db->select('app_pengguna.*,app_propinsi.propinsi_nama');		
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_pengguna.propinsi_id','LEFT');
//	$CI->db->group_by('propinsi_nama');
	$m = $CI->db->get_where("app_pengguna",array(
		"app_pengguna.propinsi_id"	=> $st
	))->result();
	return $m;
}


function get_topup($st=""){
	$CI = getCI();
	$CI->db->select('app_topup.*, app_pengguna.nama_pengguna,app_pengguna.propinsi_id, app_propinsi.propinsi_nama');
	$CI->db->join('app_pengguna','app_pengguna.penggunaID=app_topup.penggunaID','LEFT');	
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_pengguna.propinsi_id','LEFT');	
	$m = $CI->db->get_where("app_topup",array(
		"app_topup.penggunaID"	=> $st
	))->result();
	return $m;
}

function get_topup_all(){
	$CI = getCI();
	$CI->db->select('app_topup.*, app_pengguna.nama_pengguna,app_pengguna.propinsi_id, app_propinsi.propinsi_nama');
	$CI->db->join('app_pengguna','app_pengguna.penggunaID=app_topup.penggunaID','LEFT');	
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_pengguna.propinsi_id','LEFT');	
	$m = $CI->db->get_where("app_topup",array(
		"app_topup.topup_status"	=> 1
	))->result();
	return $m;
}

function get_pie_omzet(){
	$CI = getCI();
	$CI->db->select('kta_omzet as nama, count(kta_id) as jumlah');
	$CI->db->group_by('kta_omzet');
	$m = $CI->db->get_where("app_kta",array(
		"kta_id !="	=> ''
	))->result();
	return $m;
}


function get_line_byday($day=30){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT DATE_FORMAT(time_add,'%Y-%m-%d') as tgl, count(kta_id) as jumlah 
		FROM app_kta 
		GROUP BY DATE_FORMAT(time_add,'%Y-%m-%d')
		ORDER BY DATE_FORMAT(time_add,'%Y-%m-%d') DESC
		LIMIT ".$day."
		")->result();
	return $m;
}

function get_cart_badko($st=""){
	$CI = getCI();
	$CI->db->select('app_propinsi.propinsi_nama as nama, count(app_kta.kta_id) as jumlah');
	$CI->db->join('app_propinsi','app_propinsi.propinsi_kode=app_kta.kta_propinsi');
	$CI->db->group_by('app_kta.kta_propinsi');
	$m = $CI->db->get_where("app_kta",array(
		"app_kta.kta_status_data"	=> $st
	))->result();
	return $m;
}

function get_cart_kab($prov=""){
	$CI = getCI();
	$m = $CI->db->query("
		select
		kab_nama, 
		COUNT(if(kta_jenkel = '1', kta_id, NULL)) as laki,
		COUNT(if(kta_jenkel = '2', kta_id, NULL)) as perempuan
		FROM
		app_kabupaten
		INNER JOIN app_kta ON app_kta.kta_kabupaten = app_kabupaten.kab_kode
		WHERE
		kab_propinsi_id = '".$prov."'
		GROUP BY
		kab_kode
		ORDER BY kab_nama ASC
		")->result();
	return $m;
}

function get_cart_dpd(){
	$CI = getCI();
	$m = $CI->db->query("
		select
		kta_propinsi, propinsi_nama,
		COUNT(if(kta_status_data = '1', kta_id, NULL)) as terdaftar,
		COUNT(if(kta_status_data = '2', kta_id, NULL)) as registrasi
		FROM
		app_kta
		INNER JOIN app_propinsi ON app_kta.kta_propinsi = app_propinsi.propinsi_kode
		GROUP BY
		kta_propinsi
		ORDER BY kta_propinsi ASC
		")->result();
	return $m;
}

function get_cart_pengusul($st="",$prov=""){
	$CI = getCI();
	$CI->db->select('app_kabupaten.kab_nama as nama, count(app_kta.kta_id) as jumlah');
	$CI->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten');
	$CI->db->group_by('app_kta.kta_kabupaten');
	$m = $CI->db->get_where("app_kta",array(
		"app_kta.kta_jenkel"	=> $st,
		"app_kta.kta_pemesan"	=> $prov			
	))->result();
	return $m;
}

function get_kec_chart($prov=""){
	$CI = getCI();
	$CI->db->select('app_kabupaten.kab_nama as nama, count(app_kecamatan.kec_id) as jumlah');
	$CI->db->join('app_kecamatan','app_kecamatan.kec_kab_id=app_kabupaten.kab_kode');
	$CI->db->group_by('app_kabupaten.kab_nama');
	$m = $CI->db->get_where("app_kabupaten",array(
		"app_kabupaten.kab_propinsi_id"	=> $prov			
	))->result();
	return $m;
}
function get_kel_chart($prov=""){
	$CI = getCI();
	$CI->db->select('app_kabupaten.kab_nama as nama, count(app_kelurahan.kel_id) as jumlah');
	$CI->db->join('app_kelurahan','app_kelurahan.kel_kab_id=app_kabupaten.kab_kode');
	$CI->db->group_by('app_kabupaten.kab_nama');
	$m = $CI->db->get_where("app_kabupaten",array(
		"app_kabupaten.kab_propinsi_id"	=> $prov			
	))->result();
	return $m;
}

function get_ver_kab($st="",$prov=""){
	$CI = getCI();
	$CI->db->select('app_kabupaten.kab_nama as nama, count(app_kta.kta_id) as jumlah');
	$CI->db->join('app_kabupaten','app_kabupaten.kab_kode=app_kta.kta_kabupaten');
	$CI->db->group_by('app_kta.kta_kabupaten');
	$m = $CI->db->get_where("app_kta",array(
		"app_kta.kta_status_data"	=> $st,
		"app_kta.kta_propinsi"	=> $prov			
	))->result();
	return $m;
}

function get_cart_bisnis(){
	$CI = getCI();
	$CI->db->select('app_bidang_usaha.bidang_usaha as nama, count(app_kta.kta_id) as jumlah');
	$CI->db->join('app_bidang_usaha','app_bidang_usaha.bu_id=app_kta.kta_bidang_usaha');
	$CI->db->group_by('app_kta.kta_bidang_usaha');
	$m = $CI->db->get_where("app_kta",array(
		"app_kta.kta_id !="	=> ''
	))->result();
	return $m;
}

function get_cart_koperasi(){
	$CI = getCI();
	$CI->db->select('app_propinsi.propinsi_nama as nama, count(app_koperasi_cabang.cab_id) as jumlah');
	$CI->db->join('app_propinsi','app_propinsi.propinsi_id=app_koperasi_cabang.koperasi_prop');
	$CI->db->group_by('app_koperasi_cabang.koperasi_prop');
	$m = $CI->db->get_where("app_koperasi_cabang",array(
		"app_koperasi_cabang.cab_id !="	=> ''
	))->result();
	return $m;
}
function generate_qr_code($data='empty') {
	$CI = getCI();
	
	$CI->load->library('ci_qr_code');
	$CI->config->load('qr_code');
	
	$qr_code_config = array(); 
	$qr_code_config['cacheable'] 	= cfg('cacheable');
	$qr_code_config['cachedir'] 	= cfg('cachedir');
	$qr_code_config['imagedir'] 	= cfg('imagedir');
	$qr_code_config['errorlog'] 	= cfg('errorlog');
	$qr_code_config['ciqrcodelib'] 	= cfg('ciqrcodelib');
	$qr_code_config['quality'] 		= cfg('quality');
	$qr_code_config['size'] 		= cfg('size');
	$qr_code_config['black'] 		= cfg('black');
	$qr_code_config['white'] 		= cfg('white');

	$CI->ci_qr_code->initialize($qr_code_config);

	$image_name = str_replace(' ','',$data).'.png';

	$params['data'] = $data; 
	$params['level'] = 'H';
	$params['size'] = 10;
	$params['savename'] = FCPATH.$qr_code_config['imagedir'].$image_name;
	
	$CI->ci_qr_code->generate($params);
	// Display the QR Code here on browser uncomment the below line
	
	return base_url().$qr_code_config['imagedir'].$image_name;
//	echo '<img src="'.base_url().$qr_code_config['imagedir'].$image_name.'" style="height:38px; width:38px;" />';
}
function save_base64_image($base64_image_string, $output_file_without_extentnion, $path_with_end_slash="" ) {
	    //usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }      
	    //
	    //data is like:    data:image/png;base64,asdfasdfasdf
	$splited = explode(',', substr( $base64_image_string , 5 ) , 2);
	$mime=$splited[0];
	$data=$splited[1];

	$mime_split_without_base64=explode(';', $mime,2);
	$mime_split=explode('/', $mime_split_without_base64[0],2);
	if(count($mime_split)==2) {

		$extension=$mime_split[1];
		if($extension=='jpeg')$extension='jpg';
			//if($extension=='javascript')$extension='js';
			//if($extension=='text')$extension='txt';
		$output_file_with_extentnion=$output_file_without_extentnion.'.'.$extension;

	}

	file_put_contents( $path_with_end_slash . $output_file_with_extentnion, base64_decode($data) );
	return $output_file_with_extentnion;
}
function create_image(){ 
		//Let's generate a totally random string using md5 
	$md5_hash = md5(rand(0,999)); 
		//We don't need a 32 character long string so we trim it down to 5 
	$security_code = substr($md5_hash, 15, 5); 

		//Set the session to store the security code
	$_SESSION["security_code"] = $security_code;

		//Set the image width and height 
	$width = 100; 
	$height = 20;  

		//Create the image resource 
	$image = ImageCreate($width, $height);  

		//We are making three colors, white, black and gray 
	$white = ImageColorAllocate($image, 255, 255, 255); 
	$black = ImageColorAllocate($image, 0, 0, 0); 
	$grey = ImageColorAllocate($image, 204, 204, 204); 

		//Make the background black 
	ImageFill($image, 0, 0, $black); 

		//Add randomly generated string in white to the image
	ImageString($image, 3, 30, 3, $security_code, $white); 

		//Throw in some lines to make it a little bit harder for any bots to break 
	ImageRectangle($image,0,0,$width-1,$height-1,$grey); 
	imageline($image, 0, $height/2, $width, $height/2, $grey); 
	imageline($image, $width/2, 0, $width/2, $height, $grey); 

		//Tell the browser what kind of file is come in 
	header("Content-Type: image/jpeg"); 

		//Output the newly created image in jpeg format 
	ImageJpeg($image); 

		//Free up resources
	ImageDestroy($image); 
}

function create_zip($files=array(), $file_name="", $download=FALSE) {		

		# create new zip object
	$zip = new ZipArchive();

		# create a temp file & open it
	if($download) {
		$tmp_file = tempnam('.', '');
		$zip->open($tmp_file, ZipArchive::CREATE);
	} else
	$zip->open('assets/report/zip/'.$file_name.'.zip', ZipArchive::CREATE);

		# loop through each file
	foreach ($files as $file) {
		    # download file
		$download_file = file_get_contents($file);
		
		    #add it to the zip
		$zip->addFromString(basename($file), $download_file);
	}

		# close zip
	$zip->close();

		# send the file to the browser as a download
	if($download) {
		header('Content-disposition: attachment; filename="'.$file_name.'.zip"');
		header('Content-type: application/zip');
		readfile($tmp_file);
		unlink($tmp_file);
	} else return array("status" => 1, "msg" => "Pembuatan file zip berhasil");

}	
function getArticle($request="") {
	$ch = curl_init("http://116.90.165.246:2212/kj_article/get");
	$data = json_decode($request,TRUE);
	$id 	= $data['group'];
	$ses 	= $data['sessionid'];
//		debugCode($ses);
	curl_setopt_array($ch, array(
		CURLOPT_PORT => "2212",
		CURLOPT_POST => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"key\":\"all\",\"group\":\"$id\",\"group_role\":\"admin\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: f7f5ec59-27ee-4d6a-87e4-3130c43d7718",
			"SessionId: $ses",			
			"versioncode: ".cfg('version_code')."",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	)
);
	$response = curl_exec($ch);
	if($response === FALSE)die(curl_error($ch));
	$response_data = json_decode($response, TRUE);
	return $response_data;
}		
function addArticle($request="") {
	$ch = curl_init("http://116.90.165.246:2212/kj_article/add");
	$data = json_decode($request,TRUE);
	$id 	= $data['group'];
	$ses 	= $data['sessionid'];
	$isi	= $data['isi'];
	$img	= $data['img'];
	$imgL	= $data['imgL'];
	$shortDesc	= $data['shortDesc'];
	$imgCover	= $data['imgCover'];
	$title		= $data['title'];
	$imgCoverL	= $data['imgCoverL'];
	curl_setopt_array($ch, array(
		CURLOPT_PORT => "2212",
		CURLOPT_POST => TRUE,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_CUSTOMREQUEST => "POST",
//									CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"img_count\":\"1\",\"content_text\":\"$isi\",\"img_names\":[\"$img\"],\"creator\":\"Member|9A2DCBE6-2916-3BFC-AC61-B60F1F800CC0\",\"group\":\"Group|A157742F-77DE-F5A4-4E44-EC109EA70F06\",\"short_desc\":\"$shortDesc\",\"image_cover\":\"$imgCover\",\"name\":\"$title\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"image_cover\"; filename=\"$imgCoverL\"\r\nContent-Type: image/jpeg\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"$imgL\"\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",									
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"img_count\":\"1\",\"content_text\":\"$isi\",\"img_names\":[\"$img\"],\"creator\":\"Member|9A2DCBE6-2916-3BFC-AC61-B60F1F800CC0\",\"group\":\"Group|A157742F-77DE-F5A4-4E44-EC109EA70F06\",\"short_desc\":\"$shortDesc\",\"image_cover\":\"$imgCover\",\"name\":\"$title\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"image_cover\"; filename=\"$imgCoverL\"\r\nContent-Type: image/png\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"img1\"; filename=\"$imgL\"\r\nContent-Type: image/png\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: f7f5ec59-27ee-4d6a-87e4-3130c43d7718",
			"SessionId: $ses",			
			"versioncode: ".cfg('version_code')."",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	)
);
	$response = curl_exec($ch);
	if($response === FALSE)die(curl_error($ch));
	$response_data = json_decode($response, TRUE);
	return $response_data;
}	
function getEvent($request="") {
	$ch = curl_init("http://116.90.165.246:2205/kj_event/get");
	$data = json_decode($request,TRUE);
	$id 	= $data['group'];
	$ses 	= $data['sessionid'];
//		debugCode($ses);
	$sessionLogin = $_SESSION['sesiLogin'];
	curl_setopt_array($ch, array(
		CURLOPT_PORT => "2212",
		CURLOPT_POST => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"key\":\"upcoming\",\"group\":\"Group|A157742F-77DE-F5A4-4E44-EC109EA70F06\",\"group_role\":\"member\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: f7f5ec59-27ee-4d6a-87e4-3130c43d7718",
			"SessionId: $ses",			
			"versioncode: ".cfg('version_code')."",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	)
);
	$response = curl_exec($ch);
	if($response === FALSE)die(curl_error($ch));
	$response_data = json_decode($response, TRUE);
	return $response_data;
}	
function getTotalData($request="") {
	$ch = curl_init("http://116.90.165.246:2295/kj_report/hnsi/tot_per_province");
	$data = json_decode($request,TRUE);
	$ses 	= $data['sessionid'];
	curl_setopt_array($ch, array(
		CURLOPT_PORT => "2295",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: 07deb308-396a-4aeb-8732-ada75d1bf654",
			"SessionId: $ses",
			"versioncode: ".cfg('version_code').""
		),
	)
);
	$response = curl_exec($ch);
	if($response === FALSE)die(curl_error($ch));
	$response_data = json_decode($response, TRUE);
	return $response_data;
}	
function getTotalPrint($request="") {
	$ch = curl_init("http://116.90.165.246:2295/kj_report/hnsi/tot_print_per_province");
	$data = json_decode($request,TRUE);
	$ses 	= $data['sessionid'];
	curl_setopt_array($ch, array(
		CURLOPT_PORT => "2295",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: 07deb308-396a-4aeb-8732-ada75d1bf654",
			"SessionId: $ses",
			"versioncode: ".cfg('version_code').""
		),
	)
);
	$response = curl_exec($ch);
	if($response === FALSE)die(curl_error($ch));
	$response_data = json_decode($response, TRUE);
	return $response_data;
}

function getTotalPrintPerDPD($request="") {
	$ch = curl_init("http://116.90.165.246:2295/kj_report/hnsi/tot_print_per_dpd");
	$data = json_decode($request,TRUE);
	$ses 	= $data['sessionid'];
	curl_setopt_array($ch, array(
		CURLOPT_PORT => "2295",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: 07deb308-396a-4aeb-8732-ada75d1bf654",
			"SessionId: $ses",
			"versioncode: ".cfg('version_code').""
		),
	)
);
	$response = curl_exec($ch);
	if($response === FALSE)die(curl_error($ch));
	$response_data = json_decode($response, TRUE);
	return $response_data;
}		

function getAllMember() {

	$ch = curl_init("http://116.90.165.246:2206/kj_member/hnsi/getall");
	$data = json_decode($request,TRUE);
	$ses 	= $data['sessionid'];
	curl_setopt_array($ch, array(
		CURLOPT_PORT => "2206",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"key\":\"\",\"page\":\"0\",\"dpd_id\":\"Dpd|00\",\"dpc_id\":\"\",\"group_role\":\"member\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: 07deb308-396a-4aeb-8732-ada75d1bf654",
			"SessionId: $ses",			
			"versioncode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($ch);
	if($response === FALSE)die(curl_error($ch));
	$response_data = json_decode($response, TRUE);
	return $response_data;
}

function diffUntukManusia($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'tahun',
		'm' => 'bulan',
		'w' => 'minggu',
		'd' => 'hari',
		'h' => 'jam',
		'i' => 'menit',
		's' => 'detik',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
}
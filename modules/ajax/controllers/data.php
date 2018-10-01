<?php
include_once(APPPATH."libraries/FrontController.php");
class Data extends FrontController {

	function __construct()
	{
		parent::__construct();
	}

	function index() {}

	function kabupaten(){

		$prov = $this->input->post('prov');
		$kab = $this->input->post('kab');

		$this->db->order_by("kab_nama");
		$m = $this->db->get_where("app_kabupaten",array(
			"kab_propinsi_id"	=> $prov,
			"kab_status"		=> 0
		))->result();

		$html = "<option value=''> - pilih kabupaten - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->kab_kode==$kab?'selected="selected"':'';
			$html .= "<option value='".$v->kab_kode."' $s >".$v->kab_nama."</option>";
		}

		die($html);
	}

	function ktp(){

		$ktp = $this->input->post('ktp');
		$this->db->order_by("kta_no_id");
		$m = $this->db->get_where("app_kta", array(
			"kta_no_id" => $ktp
		))->result();
		if(count($m) == 0){
			echo "1";
		}else{
			echo '<font color="red">No. <strong>'.$ktp.'</strong>'.' telah didaftarkan.</font>';
		}
	}

	function npapg(){

		$npapg = $this->input->post('npapg');

		$get_max = $this->db->query("
			select max(SUBSTRING(kta_nomor,-5)) as nomor
			from app_kta where kta_nomor !='' AND kta_kelurahan = '".$npapg."'
			")->row();

		$get_kec = $this->db->query("
			select kel_kec_id
			from app_kelurahan where kel_id = '".$npapg."'
			")->row();

		$idx 				= isset($get_max->nomor)&&trim($get_max->nomor)!=0?(int)$get_max->nomor+1:1;
		$nomor_kta 			= str_repeat("0", 6-strlen($idx)).$idx;
		$nk					= substr($nomor_kta,2,4);
		$nomor_kartu 		= $get_kec->kel_kec_id.$npapg.$nk;

		$this->db->order_by("kta_nomor_kartu");
		$m = $this->db->get_where("app_kta", array(
			"kta_nomor_kartu" => $nomor_kartu
		))->result();
		if(count($m) == 0){
			echo $get_kec->kel_kec_id.$npapg.$nk;
		}else{
			echo '<font color="red">No. <strong>'.$nomor_kartu.'</strong>'.' telah didaftarkan.</font>';
		}
	}

	function username(){

		$ktp = $this->input->post('ktp');
		$this->db->order_by("user_name");
		$m = $this->db->get_where("app_user", array(
			"user_name" => $ktp
		))->result();
		if(count($m) == 0){
			echo "1";
		}else{
			echo '<font color="red">Username <strong>'.$ktp.'</strong>'.' telah didaftarkan.</font>';
		}
	}

	function card_print(){
		$npapg 	= $this->input->post('npapg');
		$status = $this->input->post('status');
/*		$this->db->order_by("kta_nomor_kartu");
		$m = $this->db->get_where("app_kta", array(
			"kta_nomor_kartu" => $npapg
		))->result();
*/		$data = array(
		'is_cetak' => 1,
		'time_print_card' => date('Y-m-d H:i:s')
	);
$this->db->set($data);
$sql = $this->db->update("app_kta",$data,"'kta_nomor_kartu' = '".$npapg."'");
//		debugCode($this->db->update());
echo "1";
}

function user_koordinator(){
	$prov = $this->input->post('prov');
	$kab = $this->input->post('kab');

	$this->db->order_by("user_name");
	$m = $this->db->get_where("app_user",array(
		"col1"	=> $prov,
	))->result();

	$html = "<option value=''> - pilih operator data - </option>";
	foreach ((array)$m as $k => $v) {
		$s = $v->user_id==$kab?'selected="selected"':'';
		$html .= "<option value='".$v->user_id."' $s >".$v->user_fullname."</option>";
	}

	die($html);
}

function suket(){

	$ktp = $this->input->post('ktp');
	$this->db->order_by("kta_no_suket");
	$m = $this->db->get_where("app_kta", array(
		"kta_no_suket" => $ktp
	))->result();
	if(count($m) == 0){
		echo "1";
//			echo '&nbsp;<img src="'.base_url().'assets/images/tick.gif" align="absmiddle"> Data KTP dapat digunakan';
	}else{
		echo '<font color="red">No. <strong>'.$ktp.'</strong>'.' telah didaftarkan.</font>';
	}
//		$html = "<option value=''> - pilih kabupaten - </option>";
//		die($html);
}

public function getDPC()
{
	$dpd = $this->input->post('dpd');
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2201",
		CURLOPT_URL => "http://116.90.165.246:2201/kj_registration/get_dpc",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"parent\":\"".$dpd."\",\"key\":\"\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			"postman-token: 74f52627-fabf-889b-58e3-d125812123c1",
			"sessionid: REGISTER_LOGIN",
			"versioncode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
		tester();
	} else {
      //echo $response;
	}
	if (isset($_SESSION['dpc_id'])) {
		$old_dpc = $_SESSION['dpc_id'];
	}	

	$dpc_decoded = json_decode($response, true);
	if (count($dpc_decoded['data'])>=1) {
		$select = '';
		$select .= '<option selected disabled> - DPC HNSI - </option>';
		foreach ($dpc_decoded['data'] as $dpc) {
			if (isset($old_dpc)) {
				if ($old_dpc == $dpc['dpc_id']) {
					$selected = "selected";
				}
				else {
					$selected = "";
				}
			}
			else {
				$selected = "";
			}				
			$select .= '<option value="'.$dpc['dpc_id'].'" '.$selected.'>'.$dpc['name'].'</option>';
		}
		echo json_encode($select);
	}
}

public function get_group_per_tingkat()
{
	$tingkat = $this->input->post('tingkat');
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2401",
		CURLOPT_URL => "http://".cfg('api_ip').":2401/sk_registration/get_reference",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"reference\":\"School\",\"parent\":\"".$tingkat."\",\"key\":\"\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"SessionId: REGISTER_LOGIN",
			"VersionCode: 20",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$group_decoded = json_decode($response, true);
	}
	if (isset($_SESSION['nama_kta'])) {
		$old_group = $_SESSION['nama_kta'];
	}

	$group_decoded = json_decode($response, true);
	if (count($group_decoded['data'])>=1) {
		$select = '';
		$select .= '<option selected disabled> - Nama Sekolah - </option>';
		foreach ($group_decoded['data'] as $group) {
			if (isset($old_group)) {
				if ($old_group == $group['code']) {
					$selected = "selected";
				}
				else {
					$selected = "";
				}
			}
			else {
				$selected = "";
			}				
			$select .= '<option value="'.$group['code'].'" '.$selected.'>'.$group['name'].'</option>';
		}
		echo json_encode($select);
	}
}

function kecamatan(){

	$prov = $this->input->post('prov');
	$kab = $this->input->post('kab');
	
	$this->db->order_by("kec_nama");
	$m = $this->db->get_where("app_kecamatan",array(
		"kec_kab_id"	=> $prov
	))->result();

				//CONNECT API HNSI GET_DPC
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2201",
		CURLOPT_URL => "http://116.90.165.246:2201/kj_registration/get_dpc",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"parent\":\"$kab\",\"key\":\"\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			"postman-token: b29dd7bd-3241-d891-36b7-787d226006b6",
			"sessionid: REGISTER_LOGIN",
			"versioncode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
				  //echo $response;
	}
	$json_decoded5 = json_decode($response, true);
/*
		$html = "<option value=''> - pilih kecamatan - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->kec_kode==$kab?'selected="selected"':'';
			$html .= "<option value='".$v->kec_kode."' $s >".$v->kec_nama."</option>";
		}
*/		
		$html = "<option value=''> - pilih kecamatan - </option>";
		foreach ($json_decoded5['data'] as $value) {
			$dpc_id = $value['dpc_id'];			
			if ($kecamatan == $dpc_id) {
				$s = "selected";
			}			
			$html .= "<option value='".$value['dpc_id']."' ".$s.">".$value['name']."</option>";
		}

		die($html);
	}

	function kelurahan(){

		$prov = $this->input->post('prov');
		$kab = $this->input->post('kab');

		$this->db->order_by("kel_nama");
		$m = $this->db->get_where("app_kelurahan",array(
			"kel_kec_id"	=> $prov
		))->result();

		$html = "<option value=''> - pilih kelurahan/desa - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->kel_kode==$kab?'selected="selected"':'';
			$html .= "<option value='".$v->kel_kode."' $s >".$v->kel_nama."</option>";
		}

		die($html);
	}

	function pengusul(){

		$pengusul 	= $this->input->post('pengusul');
		$tingkat 	= $this->input->post('tingkat');

		$this->db->order_by("nama_pengguna");
		$m = $this->db->get_where("app_pengguna",array(
			"tingkat_pengguna"	=> $tingkat
		))->result();

		if($tingkat == "DPP"){
			$html = "<option value=''> - pilih CQ - </option>";
		}else{
			$html = "<option value=''> - pilih Pengusul - </option>";
		}

		foreach ((array)$m as $k => $v) {
			$s = $v->penggunaID==$pengusul?'selected="selected"':'';
			$html .= "<option value='".$v->penggunaID."' $s >".$v->nama_pengguna."</option>";
		}

		die($html);
	}

	function dataBaru() {
		$pageAPIHnsi = $_SESSION['pageAPIHnsi'];
		$pageAPIHnsi++;
		$key = $_SESSION['key'];
		$sessionLogin = $_SESSION['sesiLogin'];

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "2206",
			CURLOPT_URL => "http://116.90.165.246:2206/kj_member/hnsi/getall",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"key\":\"$key\",\"page\":$pageAPIHnsi,\"dpd_id\":\"Dpd|00\",\"dpc_id\":\"\",\"group_role\":\"member\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Postman-Token: 3ee607a3-55d3-492a-93d5-8ef19d3cf1c3",
				"SessionId: $sessionLogin"/*5395F8E9-D94B-D6E9-D7F5-425B620B906E"/*.$_POST['SessionId'] */,
				"versioncode: ".cfg('version_code')."",
				"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
			),
		));

		$curl_response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
					/*
						if ($err) {
						  echo "cURL Error #:" . $err;
						} else {
						  echo $response;
							echo "</br></br></br>";
						}
						*/

						$json_decoded = json_decode($curl_response, true);
						$no = $_SESSION['no'];
						$html = "";

						foreach ($json_decoded['data'] as $value) {
				/* foreach($data as $r){ bintang-koma
					?> */
				//<!-- DISPLAY DATA di Dashboard dari API JSON HNSI -->
					echo "<tr>";
					echo "<td>".$no."</td>";
					echo "<td>".$value['full_name']."</td>";
					echo "<td>".$value['birth_date']."</td>";
					echo "<td>".$value['birth_place']."</td>";
					echo "<td>".$value['address']."</td>";
					echo "<td>".$value['province']['province_name']."</td>";
					echo "<td>".$value['kabupaten']['kabupaten_name']."</td>";
					echo "<td>".$value['dpd']['dpd_name']."</td>";
					echo "<td>".$value['dpc']['dpc_name']."</td>";
					echo "<td>".$value['card_no']."</td>";
					echo "<td><img src='".$value['profile_pic']."' height='100'></td>";
					echo "<td>".$value['status']."</td>";
					echo "<td>".$value['blood_type']."</td>";
					echo "<td>".$value['card_printed']."</td>";
					echo "<td align='center'></td>";
					echo "<td>";
					?>
					<!-- TOMBOL CETAK, mengambil isi data JSON dari API untuk dimasukkan ke dalam variable -->"
					<!--<a href="<?php /* echo $own_links."/edit/?_id="._encrypt(); */?><!--"><span class="label label-default label-form" data-toggle="tooltip" data-placement="top" title data-original-title="See Detail"><li class="fa fa-list-alt"></li></span></a> -->
					<?php
						//$html .="<button type='button' onclick='print_card('".echo $value['full_name']."','".echo $value['card_no']."','".echo $value['birth_place']."','".echo $value['birth_date']."','".echo $value['address']."','".echo $value['dpd']['dpd_name']."','".echo $value['dpc']['dpc_name']."','".echo $value['profile_pic']."','".echo $value['blood_type']."')" class="btn btn-info pull-right"> Cetak Kartu </button>";
					echo "</td></tr>";
					$no++;
				}
			}
		}

		/* End of file welcome.php */
		/* Location: ./system/application/controllers/welcome.php */

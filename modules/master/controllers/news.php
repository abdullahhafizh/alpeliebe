<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class News extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('List Berita ALPENINDO');
		$this->DATA->table="app_kecamatan";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
			"title"		=> "Kecamatan",
			"url"		=> $this->own_link
		);

		$this->is_search_date = false;

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		

		$this->cat_search = array(
			''						=> 'All',
			'kec_nama'				=> 'Nama Kecamatan',
			'kab_nama'				=> 'Nama Kabupaten',
			'propinsi_nama'			=> 'Nama Provinsi'
			
		); 
		$this->load->model("mdl_master","M");

		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/datatables/jquery.dataTables.min.js',
			'plugins/bootstrap/bootstrap-select.js',
			'plugins/summernote/summernote.js'
		);
	}

	
	function _reset(){
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'kec_id',
			'order_dir' => 'DESC',
			'colum'		=> '',
			'keyword'	=> ''
		);
		$this->_releaseSession();
	}

	function index(){

		$this->breadcrumb[] = array(
			"title"		=> "List"
		);
		$data = array();
		$req_get 	= array(
			"group" 		=> 'Group|A157742F-77DE-F5A4-4E44-EC109EA70F06', 
			"sessionid" 	=> $_SESSION['sesiLogin'], 
		);
		$req = getArticle(json_encode($req_get));
//		debugCode($req);
		$data = $this->_data(array(
			"base_url"	=> $this->own_link.'/index'
		));
		$data['article'] = $req['data']['article'];
		debugCode(get_article());
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}
	function search(){

		$this->breadcrumb[] = array(
			"title"		=> "List"
		);

		if($this->input->post('btn_reset')){
			$this->_reset();
		}

		$par_filter = array(
			"offset"	=> $this->uri->segment($this->uri_segment),
			"propinsi"	=> $this->input->post('propinsi'),
			"kabupaten"	=> $this->input->post('kta_kabupaten'),
			"param"		=> $this->cat_search
		);
		$this->data_table = $this->M->kecamatan($par_filter);
		$data = $this->_data(array(
			"base_url"	=> $this->own_link.'/index'
		));
		$data['param'] = array(
			"propinsi" => trim($this->input->post('propinsi')),
			"kabupaten" => trim($this->input->post('kta_kabupaten'))
		);
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	function add(){	
		$this->breadcrumb[] = array(
			"title"		=> "Add"
		);		
		$this->_v($this->folder_view.$this->prefix_view."_form",array());
	}

	function edit(){

		$this->breadcrumb[] = array(
			"title"		=> "Edit"
		);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
				'kec_id'	=> $id
			));			
			$this->_v($this->folder_view.$this->prefix_view."_form",array());
		}else{
			redirect($this->own_link);
		}
	}
	
	function delete(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id) != ''){
			$o = $this->DATA->_delete(
				array("kec_id"	=> idClean($id)),
				TRUE
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data kecamatan succes')."&type_msg=success");
	}

	function save(){
		// $kode_kecamatan = $this->input->post('kab_propinsi_id').substr($this->input->post('kec_kab_id'),2,2).$this->input->post('kec_kode');
		// $data = array(
		// 	'kec_nama'				=> $this->input->post('kec_nama'),
		// 	'kec_kode'				=> $kode_kecamatan,
		// 	'kec_kab_id'			=> $this->input->post('kec_kab_id'),
		// 	'kec_prop_id'			=> $this->input->post('kab_propinsi_id'),
		// 	'kec_status'			=> $this->input->post('kab_status')
		// );		

		// $a = $this->_save_master( 
		// 	$data,
		// 	array(
		// 		'kec_id' => dbClean($_POST['kec_id'])
		// 	),
		// 	dbClean($_POST['kec_id'])			
		// );

		// redirect($this->own_link."?msg=".urldecode('Data Kecamatan '.$this->input->post('kec_nama').' dengan Kecamatan Kode '.$kode_kecamatan.' Berhasil Di Update / Ditambah')."&type_msg=success");
		$curl = curl_init();
		$userName = $this->jCfg['user']['name'];
		$userPass = $this->jCfg['user']['password'];

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "2202",
			CURLOPT_URL => "http://116.90.165.246:2202/kj_login/hnsi",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"id\":\"$userName\",\"password\":\"$userPass\",\"verification_code\":\"\",\"version_code\":10}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
				"postman-token: 0cd0b775-f7e7-d645-4c37-c702ff41713a",
				"sessionid: REGISTER_LOGIN",
				"versioncode: ".cfg('version_code').""
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		}

		$json_decoded2 = json_decode($response, true);		

		$sessionid = $json_decoded2['session'];
		$member_id = $json_decoded2['data']['member']['member_id'];
		$group_id = $json_decoded2['data']['group_member']['0']['group_id'];

		$title = $this->input->post('news_title');
		$body = $this->input->post('news_body');
		$cover = $_FILES["news_cover"]['name'];		
		$short_desc = shorter($body, 100);
		$type = $_FILES["news_cover"]['type'];		
		
		$target_file = basename($_FILES["news_cover"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["news_cover"]["tmp_name"]);
			if($check !== false) {
				// echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				// echo "File is not an image.";
				$uploadOk = 0;
			}
		}

		// if ($_FILES["news_cover"]["size"] > 500000) {
		// 	echo "Sorry, your file is too large.";
		// 	$uploadOk = 0;
		// }

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" )
		{
			echo "Maaf, hanya file bertipe JPG, JPEG, PNG & GIF yang diperbolehkan.";
			$uploadOk = 0;
		}

		if ($uploadOk == 0) {
			echo "Maaf, terjadi kesalahan.";
		}
		else {
			$image_cover = $_FILES["news_cover"]['tmp_name'];
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "2213",
			CURLOPT_URL => "http://116.90.165.246:2213/kj_news/add",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"img_count\":\"\",\"content_text\":\"".$body."\",\"img_names\":[],\"creator\":\"".$member_id."\",\"group\":\"".$group_id."\",\"short_desc\":\"".$short_desc."\",\"image_cover\":\"".$cover."\",\"name\":\"".$title."\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"image_cover\"; filename=\"".$cover."\"\r\nContent-Type: ".$type."\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
				"postman-token: 306b964d-a8a2-2936-e341-b8486889b0b9",
				"sessionid: ".$sessionid."",
				"versioncode: ".cfg('version_code').""
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}

}
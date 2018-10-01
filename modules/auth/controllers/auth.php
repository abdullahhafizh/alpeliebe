<?php
include_once(APPPATH."libraries/FrontController.php");
class auth extends FrontController {

	function __construct()
	{
		parent::__construct();
		$this->jCfg['theme'] = 'admin/'.cfg('template_admin');

	}

	function index()
	{
		//echo date("Y-m-d H:i:s",1422483746);

		if(isset($this->jCfg['is_login'])){
			if($this->jCfg['is_login']==1){
					redirect(site_url("meme/me"));
			}
		}

		$q = $this->db->get_where("app_maintenance",array(
			"id_maintenance" => 1
		))->row();

		if(date("Y-m-d H:i:s") >= $q->maintenance_to){
			$this->db->update("app_maintenance",array(
				'maintenance_status' => 0,
			),array(
				'id_maintenance' => 1
			));
		}else{
			$this->db->update("app_user",array(
				'col2' => 0,
				'col5' => date('Y-m-d H:i:s')
			),array(
				'user_status' => 1
			));
		}
		$browser = cfg('browser');
		$b = getBrowser();
		if(intval(substr($b['version'],0,strpos($b['version'],'.'))) >= intval($browser[$b['name']])) {
			// load codeigniter captcha helper
			$this->load->helper('captcha');

			$vals = array(
				'img_path'	 => './captcha/',
				'img_url'	 => base_url().'captcha/',
				'img_width'	 => '200',
				'img_height' => 30,
				'border' 	 => 0
//				'expiration' => 7200
			);

			// create captcha image
			$cap = create_captcha($vals);

			$data = array(
				'message'	=> '',
				'image'		=> $cap['image']
			);

			// store the captcha word in a session
			if(file_exists(BASEPATH."../captcha/".$this->session->userdata['image']))
				unlink(BASEPATH."../captcha/".$this->session->userdata['image']);

			// store the captcha word in a session
			$this->session->set_userdata(array('mycaptcha'=>$cap['word'], 'image' => $cap['time'].'.jpg'));

			$this->_v('login',$data);
		} else $this->_v('lockscreen',array());
	}

	function reset(){
		if(isset($_POST['reset'])){
			$u = dbClean($this->input->post('uname'));
			$p = dbClean($this->input->post('upassword'));

			$status = array(
					"status"	=> 0,
					"data"		=> array(),
					"message"	=> ''
				);

			$reset = $this->db->update("app_user",array(
					'col2' => 0,
				),array(
					'user_name' => $u,
					'user_password' => $p
				));

			if($reset){
				$status = array(
					"status"	=> 1,
					"data"		=> array( "go_to" => site_url('auth') ),
					"message"	=> 'Please login again'
				);
			}

			die(json_encode($status));
		}
	}

	/* FUNGSI MENERIMA INPUT USERNAME, PASSWORD, dan CAPTCHA */
	function act_auth(){
//		debugCode();
		if(isset($_POST['login'])){
			$u = dbClean($this->input->post('username')); /* mengambil username dari login.meme.js */
			$p = md5(dbClean($this->input->post('password'))); /* mengambil password dari login.meme.js */
			$c = dbClean($this->input->post('captcha')); /* mengambil captcha dari login.meme.js */
			$check = true;
			// debugCode($c != $this->session->userdata('mycaptcha'));
			if( trim($u) == '' || trim($p) == ''  || trim($c) == '' ){
				$check = false;
				$status = array(
						"status"	=> 0,
						"data"		=> array(),
						"message"	=> 'Please input your username, password or captcha'
					);

				die(json_encode($status));
			}else if($c != $this->session->userdata('mycaptcha')){
				$check = false;
				if(file_exists(BASEPATH."../captcha/".$this->session->userdata['image']))
					unlink(BASEPATH."../captcha/".$this->session->userdata['image']);

				$this->session->unset_userdata('mycaptcha');
				$status = array(
						"status"	=> 2,
						"data"		=> array( "go_to" => site_url('auth') ),
						"message"	=> 'Please check Captcha'
					);

				die(json_encode($status));
			}

			if($check){
				$d = $this->db->select("app_user.*");
				$d = $this->db->get_where("app_user",array(
						"user_name"		=> $u,
						"user_password"	=> $p,
						"user_status"	=> 1
					))->row();
/*			if($d->col2 == 1){
				$status = array(
						"status"	=> 3,
						"data"		=> array(
							"uname"		=> $u,
							"upassword"	=> $p,
						),
						"message"	=> 'Akun Anda teridentifikasi sedang login di komputer lain. Apakah anda ingin menutupnya dan login di sini?'
					);
				die(json_encode($status));
			}else{ */
				if(count($d) > 0){
					/*set session*/

					$group = $this->db->get_where("app_user_group",array(
							"ug_user_id" => $d->user_id
						))->result();
					$arr_group = array();

					foreach ((array)$group as $p => $q) {
						$arr_group[] = $q->ug_group_id;
					}

					$role = $this->db->get_where("app_user_group",array(
							"ug_user_id" => $d->user_id
					))->row();

					$hckey = $this->db->get_where("app_propinsi",array(
							"propinsi_id" => $d->user_province
					))->row();

					$this->sCfg['is_login'] 			= 1;
					$this->sCfg['user']['id'] 			= $d->user_id;
					$this->sCfg['user']['name']			= $d->user_name;
					$this->sCfg['user']['password'] = $d->user_password;
					$this->sCfg['user']['image']		= get_image(base_url()."assets/collections/photo/medium/".$d->user_photo);
					$this->sCfg['user']['fullname'] 	= $d->user_fullname;
					$this->sCfg['user']['is_all']		= $d->is_show_all;
					$this->sCfg['user']['bg']			= $d->user_background;
					$this->sCfg['user']['color']		= $d->user_themes;
					$this->sCfg['user']['tingkat']		= $d->user_tingkat;
					$this->sCfg['user']['penggunaid']	= $d->penggunaID;
					$this->sCfg['user']['managerid']	= $d->col1;
					$this->sCfg['user']['propinsi']		= $d->user_province;
					$this->sCfg['user']['userrole'] 	= $role->ug_group_id;
					$this->sCfg['user']['role'] 		= $arr_group;
					$this->_releaseSession();

					$this->db->update("app_user",array(
						'user_logindate' => date("Y-m-d H:i:s"),
						'col2' => 1,
					),array(
						'user_id' => $d->user_id
					));

					$status = array(
						"status"	=> 1,
						"data"		=> array( "go_to" => site_url('meme/me') ),
						"message"	=> 'Login Success, Please Wait.. <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw pull-right"></i>'
					);
					die(json_encode($status));

				}else{
					$status = array(
						"status"	=> 0,
						"data"		=> array(),
						"message"	=> 'Please check Username and password...'
					);
					die(json_encode($status));
				}
//			 }
			}
		}
	}

	function out(){
		$this->db->update("app_user",array(
			'col2' => 0,
			'col5' => date('Y-m-d H:i:s')
		),array(
			'user_id' => $this->jCfg['user']['id']
		));
		if(file_exists(BASEPATH."../captcha/".$this->session->userdata['image']))
        	unlink(BASEPATH."../captcha/".$this->session->userdata['image']);

		$this->session->unset_userdata('mycaptcha');
		$this->sCfg['user']['id'] 		= '';
		$this->sCfg['user']['fullname'] = 'Guest';
		$this->sCfg['user']['name'] 	= 'guest';
		$this->sCfg['user']['level'] 	= '';
		$this->sCfg['user']['user_type'] 	= '';
		$this->sCfg['user']['ujian_type'] = '';
		$this->sCfg['user']['access'] 	= array();
		$this->sCfg['menu'] 			= array();
		$this->sCfg['is_login'] 		= 0;
		$this->sCfg['user']['is_all']	= 0;
		$this->sCfg['user']['role'] 	= array();
		$this->sCfg['user']['bg']		= 0;
		$this->sCfg['referer']			= "";
		$this->_releaseSession();
		redirect(site_url());
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */

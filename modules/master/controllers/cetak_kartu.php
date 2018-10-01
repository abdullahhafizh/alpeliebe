<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Cetak_kartu extends AdminController {  
    function __construct()    
    {
        parent::__construct(); 
        error_reporting(E_ALL);
        $this->_set_action();
        $this->_set_action(array("edit","delete"),"ITEM"); //"view"
        $this->_set_title('Status Data KTA Partai Golkar');
        $this->DATA->table="app_kta";
        $this->folder_view = "master/";
        $this->prefix_view = strtolower($this->_getClass());

        $this->breadcrumb[] = array(
                "title"     => "Master Anggota",
                "url"       => $this->own_link
            );

        $this->upload_path="./assets/collections/salesdraft/";

        if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
            $this->_reset();
            redirect($this->own_link);
        }
        
    
		$this->cat_search = array(
			''					=> 'All',
			'kta_nomor_kartu'	=> 'NPAPG',
			'kta_nama_lengkap'	=> 'Nama Lengkap',
			'kta_tempat_lahir'	=> 'Tempat Lahir',
			'propinsi_nama'		=> 'Propinsi',
			'kab_nama'			=> 'Kabupaten',
			'kec_nama'			=> 'Kecamatan',
			'kel_nama'			=> 'Kelurahan',			
		); 
        $this->load->model("mdl_master","M");

        //load js..
		$this->js_plugins = array(
            'plugins/bootstrap/bootstrap-datepicker.js',
            'plugins/bootstrap/bootstrap-file-input.js',
            'plugins/bootstrap/bootstrap-select.js',
            'plugins/webcamjs/webcam.js',
			'plugins/datatables/jquery.dataTables.min.js',
			'plugins/tableexport/tableExport.js',
            'plugins/tableexport/jquery.base64.js',
			'plugins/tableexport/html2canvas.js',
			'plugins/tableexport/jspdf/libs/sprintf.js',
			'plugins/tableexport/jspdf/jspdf.js',
			'plugins/tableexport/jspdf/libs/base64.js',
			'html2canvas/html2canvas.js',
            'html2canvas/jquery.plugin.html2canvas.js',
            'html2canvas/base64.js',
            'html2canvas/canvas2image.js',
			'plugins/icheck/icheck.min.js',
			'plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'
        ); 
		}

    
    function _reset(){
        $this->sCfg['search'] = array(
            'class'     => $this->_getClass(),
            'date_start'=> '',
            'date_end'  => '',
            'status'    => '',
            'order_by'  => 'kta_id',
            'order_dir' => 'DESC',
            'colum'     => '',
            'keyword'   => ''
        );
        $this->sCfg['page_tab'] = '1';
        $this->sCfg['type_data'] = 1;
        $this->_releaseSession();
    }

    function set_tab(){
        $tab = $this->input->get('tab');
        $this->sCfg['type_data'] = $tab;
        $this->_releaseSession();

        $next = $this->own_link;
        if(isset($_GET['next'])){
            $next = $_GET['next'];
        }

        redirect($next);
    }

    function index(){

        $this->breadcrumb[] = array(
                "title"     => "List"
            );
        if($this->input->post('btn_search')){
            if($this->input->post('date_start') && trim($this->input->post('date_start'))!="")
                $this->jCfg['search']['date_start'] = $this->input->post('date_start');

            if($this->input->post('date_end') && trim($this->input->post('date_end'))!="")
                $this->jCfg['search']['date_end'] = $this->input->post('date_end');

            if($this->input->post('colum') && trim($this->input->post('colum'))!="")
                $this->jCfg['search']['colum'] = $this->input->post('colum');
            else
                $this->jCfg['search']['colum'] = "";    

            if($this->input->post('keyword') && trim($this->input->post('keyword'))!="")
                $this->jCfg['search']['keyword'] = $this->input->post('keyword');
            else
                $this->jCfg['search']['keyword'] = "";

            $this->_releaseSession();
        }

        if($this->input->post('btn_reset')){
            $this->_reset();
        }

        $this->per_page = 50;
        $par_filter = array(
                "offset"    => $this->uri->segment($this->uri_segment),
                "limit"     => $this->per_page,
                "type_data" => 2,
                "param"     => $this->cat_search
            );
        $this->data_table = $this->M->kta($par_filter);
        
        $data = $this->_data(array(
                "base_url"  => $this->own_link.'/index'
            ));

        $this->_v($this->folder_view.$this->prefix_view,$data);
    }

    function export_data(){
        $par_filter = array(
                "type_data" => $this->jCfg['type_data'],
                "order_by" => "kta_nama_lengkap",
                "param"     => $this->cat_search
            );
        $data = $this->M->kta($par_filter);
        $this->_v($this->folder_view.$this->prefix_view."_export",$data,false);
    }


    function edit(){ 

        $this->breadcrumb[] = array(
                "title"     => "Edit"
            );
        $id=_decrypt(dbClean(trim($this->input->get('_id'))));

        if(trim($id)!=''){
            $mo = $this->M->kta(array(
                    'id'    => $id
                ));         
            $this->data_form = $vx = $mo['data'][0];
            $is_expired = $vx->kta_expired_date < date("Y-m-d")?true:false;

/*            $this->db->order_by("ktap_end_date","DESC");
            $data_perpanjang = $this->db->get_where("app_kta_perpanjangan",array(
                    "ktap_kta_id"   => $id
                ))->result();
*/
            $this->_v($this->folder_view.$this->prefix_view."_detail",array(
                    "is_expired" => "",
                    "perpanjang" => ""
                ));
        }else{
            redirect($this->own_link);
        }
    }
    
    function delete(){
        $id=_decrypt(dbClean(trim($this->input->get('_id'))));
        if(trim($id) != ''){
            $o = $this->DATA->_delete(
                array("kta_id"  => idClean($id)),
                TRUE
            );
            
        }
        redirect($this->own_link."?msg=".urldecode('Delete data KTA succes')."&type_msg=success");
    }
	function collective(){
		$get_saldo = $this->db->query("
			select saldo_pengguna
			from app_pengguna where penggunaID = '".$this->jCfg['user']['penggunaid']."'
		")->row();		
		$orderid = date("YmdHis");

		if(isset($_POST['item']) && count($_POST['item'])>0){
			$par_filter = array(
				"tab_lunas"	=> $this->jCfg['page_tab'],
				"in_id"		=> $this->input->post('item')
			);			
			$cetak = $this->M->kta($par_filter);			
			foreach ((array)$_POST['item'] as $k => $v) {
				$saldo = $get_saldo->saldo_pengguna - 1;
				$this->DATA->table = "app_kta";
				$data = array(
					'is_cetak'			=> 2,					
					'kta_order_date'	=> date("Y-m-d H:i:s"),					
					'kta_order_id'		=> $orderid,					
				);	

				$m = $this->db->get_where("app_kta",array(
					"kta_id"	=> $v
				))->row();

				$a = $this->_save_master( 
					$data,
					array( 	
						'kta_id' => $v
					),
					dbClean($v)			
				);
				$id = $a['kta_order_id'];
				$this->db->update("app_pengguna",array(
						'saldo_pengguna' 	=> $saldo,
					),array(
						'penggunaID'		=> $this->jCfg['user']['penggunaid']
					));
			}
				$this->db->insert("app_order",array(
						"order_id"			=> $orderid,
						"order_pengguna"	=> $this->jCfg['user']['penggunaid'],
						"order_date"		=> date("Y-m-d H:i:s"),						
						"order_status"		=> 0
					));
			redirect($this->own_link."?msg=".urldecode('Data Kartu Berhasil dimasukan kedalam Order Cetak Kartu dg nomor order "'.$orderid.'"')."&type_msg=success");
		}else{
			redirect($this->own_link."?msg=".urldecode('Pilih Data KTA yang akan dibayar')."&type_msg=error");
		}
	}

}
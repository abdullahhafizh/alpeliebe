<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Exp_print extends AdminController {  
	function __construct()    
	{
		parent::__construct();    
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title( 'Export Data Cetak' );
		$this->DATA->table="app_kta";
		$this->folder_view = "report/";
		$this->prefix_view = strtolower($this->_getClass());
		
		$this->breadcrumb[] = array(
				"title"		=> "Export Data Cetak",
				"url"		=> $this->own_link
			); 

		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
 		
 		$this->load->model("mdl_report","M");
	}

	function index(){
		
		$this->js_file = array(
                'export-print.js?r='.rand(1,1000)
            );
            
		$this->breadcrumb[] = array(
				"title"		=> "List"
			);
			
		$data = array();

		$this->_v($this->folder_view.$this->prefix_view,$data);
	}
	
	function get_proposer(){
		$data = $this->db->get('app_pengguna')->result();
		if( count($data) > 0 ){	
			$return = array();
			foreach ($data as $k => $v) {
				$return[] = $v->nama_pengguna;
			}
			
			echo json_encode($return);
		} else echo json_encode(array());
	}
	
	function check_proposer(){
		$proposer = $this->input->post('proposer');
		$data = $this->db->get_where('app_pengguna',array('nama_pengguna' => $proposer))->row();
		if( count($data) > 0 ) echo 1;
		else echo 0;
	}
	
	function get_city(){
		$id = $this->input->post('id');
		
		$data = array(
			"city" => array()
		);
		
		if( trim($id)!="" ){
			
			$this->DATA->table="app_kabupaten";
			$this->db->order_by("kab_nama","ASC");
			$city = $this->DATA->_getall(array('kab_propinsi_id' => $id));
			
			$data['city'] = $city;
		}
		
		die(json_encode($data));
	}
	
	function show_data(){		
		$return = array(
				"status" => 0,
				"data"=> ""
			);
			
		$data = array();
		$proposer	= $this->input->post('proposer');
		$prov		= $this->input->post('province');
		$ct			= $this->input->post('city');
				
		$par_filter = array(
				"offset"	=> $this->input->post('offset'),
				"limit"		=> $this->input->post('limit'),
				"proposer"	=> $proposer,
				"province"	=> $prov,
				"city"		=> $ct
			);
			
		$data = $this->M->get_data($par_filter);
		if(count($data) > 0) {
			$return = array(
					"status" => 1,
					"data"=> $data
				);
		}
			
		die(json_encode($return));
	}
	
	function file_archive(){
		
		$data = array();
		$proposer	= $this->input->post('proposer');
		$prov		= $this->input->post('province');
		$ct			= $this->input->post('city');
		$xfile		= $this->input->post('excelfile');
		$zfile		= $this->input->post('zipfile');
		$newdate	= $this->input->post('newdate');
				
		$par_filter = array(
				"offset"	=> $this->input->post('offset'),
				"limit"		=> $this->input->post('limit'),
				"proposer"	=> $proposer,
				"province"	=> $prov,
				"city"		=> $ct
			);
		$data = $this->M->get_data($par_filter);		
		if( count($data) > 0 ){		
			$files = array();
			foreach ((array)$data as $k => $v) {
				rename("assets/collections/kta/photo/".$v->kta_foto_wajah,"assets/collections/kta/photo/".$v->kta_nomor_kartu.".jpg");
				$this->db->set('kta_foto_wajah', $v->kta_nomor_kartu.".jpg");  
				$this->db->where('kta_id in ('.$v->kta_id.')');  
				$p = $this->db->update('app_kta');				
				array_push($files,"assets/collections/kta/photo/".$v->kta_nomor_kartu.".jpg");
			}
			
			$r = create_zip($files, $zfile);
			if($r['status']==1) {
				$files = array('assets/report/excel/'.$xfile,'assets/report/zip/'.$zfile.'.zip');
				create_zip($files, 'DataCetak_'.$newdate);
			}		
		}
		
	}
	
	function export_excel(){	
		$path_file = './assets/report/excel/';
		$return = array(
				"status" 	=> 0,
				"message"	=> "Data tidak ditemukan, generate file gagal",
				"ids"		=> "",
				"count"		=> 0,
				"filezip"	=> ""
			);	
		
		$styleBorder = array();

		$data = array();
		$proposer	= $this->input->post('proposer');
		$prov		= $this->input->post('province');
		$ct			= $this->input->post('city');
		$xfile		= $this->input->post('excelfile');
		$zfile		= $this->input->post('zipfile');
		$newdate	= $this->input->post('newdate');
				
		$par_filter = array(
				"offset"	=> $this->input->post('offset'),
				"limit"		=> $this->input->post('limit'),
				"proposer"	=> $proposer,
				"province"	=> $prov,
				"city"		=> $ct
			);
		$data = $this->M->get_data($par_filter);		
		if( count($data) > 0 ){
			//start..
			error_reporting(E_ALL);
			ini_set('display_errors', TRUE);
			ini_set('display_startup_errors', TRUE);
	
			require_once APPPATH.'libraries/PHPExcel.php';
			require_once APPPATH.'libraries/PHPExcel/IOFactory.php';
			
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator($this->jCfg['user']['fullname'])
										 ->setTitle("Report Data Cetak")
										 ->setSubject("Data Cetak")
										 ->setDescription("DAFTAR NAMA ANGGOTA DAN BIAYA CETAK KARTU")
										 ->setKeywords("MEMBER")
										 ->setCategory("Report Excel");
			$styleMainTitle = array( // set style untuk judul
				'font' => array(
					'bold' => true,
					'size' => '16'
				),
				'alignment' => array(
					'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				)
			);
			$styleTitle = array( // set style untuk judul
				'font' => array(
					'bold' => true,
					'size' => '12'
				)
			);
			$styleBorder = array( // set style untuk membuat border
				'borders'	=> array(
					'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
				),
				'alignment' => array(
					'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			);
			$styleHeader = array( // set style untuk header
				'font' => array(
					'bold' => true,
					'size' => '10'
				),
				'borders' => array(
					'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array(
						'style' => PHPExcel_Style_Border::BORDER_DOUBLE
					)
				),
				'alignment' => array(
					'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				)				
			);
	
			$colums = array('A' => 5, 'B' => 30, 'C' => 40, 'D' => 30, 'E' => 30); // set lebar masing-masing kolom
			$header_first = array('A' => 'NO', 'B' => 'NOMOR KTA-PG', 'C' => 'NAMA ANGGOTA', 'D' => 'PROVINSI', 'E' => 'TANGGAL DISTRIBUSI'); // set nama header
					
			$objPHPExcel->getActiveSheet()->setShowGridlines(false); // menghilangkan grid lines	
			$objPHPExcel->getActiveSheet()->mergeCells('A1:E1'); // menggabungkan kolom untuk penulisan judul utama
				
		    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'DAFTAR NAMA ANGGOTA PARTAI GOLKAR SIAP CETAK'); // mengisi judul utama
		    
			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleMainTitle); // set style untuk judul
			
			$num = 4;
		    foreach ($header_first as $k => $v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k.($num-1), $v);
		    	
				$objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth($colums[$k]); // set width untuk tiap kolom sesuai dengan data pada array $colums
			}
			
			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($styleHeader); // set style untuk area header
			
			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTop(array(1, 3));
			
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); // 
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(45); // set skala untuk menampilkan satu halaman penuh saat di print
	
		    // Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('data-cetak-anggota');
			$objPHPExcel->setActiveSheetIndex(0);
	
			// Miscellaneous glyphs, UTF-8
			$id = ""; $count = 0;
			$start_row = (int)$this->input->post('offset')+4;
			foreach ((array)$data as $k => $v) {			
				$objPHPExcel->setActiveSheetIndex(0)
			            ->setCellValue('A'.$start_row, $start_row-3)
			            ->setCellValue('B'.$start_row, ' '.$v->kta_nomor_kartu.' ')
			            ->setCellValue('C'.$start_row, ' '.$v->kta_nama_lengkap.' ')
			            ->setCellValue('D'.$start_row, ' '.$v->kab_nama.' - '.$v->propinsi_nama.' ')
			            ->setCellValue('E'.$start_row, ' '.date("m/Y").' ');
			            
	        				 
	        	$id .= ($start_row==4)?$v->kta_id:','.$v->kta_id;
			    $start_row++;
			    $count++;
			}
		    $objPHPExcel->getActiveSheet()->getStyle('A4:F'.($start_row-1))->applyFromArray($styleBorder);
	
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($path_file.$xfile);
		    
			if(file_exists($path_file.$xfile)) {
				$return['status'] = 1;
				$return['message'] = 'Generate file berhasil';
				$return['ids'] = str_replace('=','',base64_encode($id));
				$return['count'] = $count;
				$return['filezip'] = 'DataCetak_'.$newdate.'.zip';
						
				$files = array('assets/report/excel/'.$xfile,'assets/report/zip/'.$zfile.'.zip');
				create_zip($files, 'DataCetak_'.$newdate);
				
			}
		}

		die(json_encode($return));
	}
	
	function update_data(){
		$id			= $this->input->post('id');
		$proposer	= $this->input->post('proposer');
		$count		= $this->input->post('count');
		$date		= date('Y-m-d H:i:s');
		$return		= array('status' => 0, 'msg' => 'Update gagal');
		
		if(!empty($id)) {			
			$dp = $this->db->get_where('app_pengguna',array('nama_pengguna' => $proposer))->row();
			
			$this->db->order_by('cetak_id','desc');
			$c = $this->db->get('app_data_cetak')->row();
			$kode = ((intval($c->cetak_kode)+1)<10?'000':(intval($c->cetak_kode)<100?'00':(intval($c->cetak_kode)<1000?'0':''))).(intval($c->cetak_kode)+1);
			
			$data = array(
					'cetak_kode'		=> $kode,
					'cetak_jumlah'		=> $count,  
					'cetak_pengusul'	=> $dp->penggunaID,
					'cetak_tanggal'		=> $date,
					'cetak_user'		=> $this->jCfg['user']['id']
			);			
			
			$i = $this->db->insert('app_data_cetak',$data);			
			if($i) {
				$this->db->set('is_cetak', 1);  
				$this->db->set('time_print_card', $date);  
				$this->db->set('col14', $kode);  
				$this->db->where('kta_id in ('.base64_decode($id).')');  
				$p = $this->db->update('app_kta');				
				$return = array('status' => 1, 'msg' => 'Update berhasil', "go_to" => site_url('report/exp_print'));
			}
		}
		
		die(json_encode($return));
	}

}
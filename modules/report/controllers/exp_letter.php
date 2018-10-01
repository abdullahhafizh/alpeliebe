<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Exp_letter extends AdminController {  
	function __construct()    
	{
		parent::__construct();    
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title( 'Export Tanda Terima' );
		$this->DATA->table="sos_kta";
		$this->folder_view = "report/";
		$this->prefix_view = strtolower($this->_getClass());
		
		$this->breadcrumb[] = array(
				"title"		=> "Export Tanda Terima",
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
                'export-letter.js?r='.rand(1,1000)
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
	
	function get_district(){
		$id = $this->input->post('id');
		
		$data = array(
			"district" => array()
		);
		
		if( trim($id)!="" ){
			
			$this->DATA->table="app_kecamatan";
			$this->db->order_by("kec_nama","ASC");
			$district = $this->DATA->_getall(array('kec_kab_id' => $id));
			
			$data['district'] = $district;
		}
		
		die(json_encode($data));
	}
	
	function get_area(){
		$id = $this->input->post('id');
		
		$data = array(
			"area" => array()
		);
		
		if( trim($id)!="" ){
			
			$this->DATA->table="app_kelurahan";
			$this->db->order_by("kel_nama","ASC");
			$area = $this->DATA->_getall(array('kel_kec_id' => $id));
			
			$data['area'] = $area;
		}
		
		die(json_encode($data));
	}
	
	function export_excel(){	
		$return = array(
				"status" => 0,
				"message"=> "",
				"data" => array(
						"success" => 0,
						"total"	  => 0,
						"offset"  => 0,
						"filename"=> '',
						"proposer"=> '',
						"url_download" => ''
					)
			);	
		$province = "";
		$city = "";
		$district = "";
		$province_number = "";
		$city_number = "";
		$district_number = "";
		$styleBorder = array();

		$data = array();
		$proposer	= $this->input->post('proposer');
		$prov		= $this->input->post('province');
		$ct			= $this->input->post('city');
		$dist		= $this->input->post('district');
		$area		= $this->input->post('area');
				
		$par_filter = array(
				"offset"	=> $this->input->post('offset'),
				"limit"		=> $this->input->post('limit'),
				"proposer"	=> $proposer,
				"province"	=> $prov,
				"city"		=> $ct,
				"district"	=> $dist,
				"area" 		=> $area
			);
		$data = $this->M->get_member($par_filter);		
		$return['data']['total'] = $data['total'];
		
//		debugCode($data['result']);		
		foreach((array)$data['data'] as $k=>$v ){
			$province = $v->propinsi_nama;
			$city = $v->kab_nama;
			$district = $v->kec_nama;
			$narea = $v->kel_nama;
			$province_number = $v->kta_propinsi;
			$city_number = $v->kta_kabupaten;
			$district_number = $v->kta_kecamatan;
			$area_number = $v->kta_kelurahan;
			
			break;
		}

		//start..
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		require_once APPPATH.'libraries/PHPExcel.php';
		require_once APPPATH.'libraries/PHPExcel/IOFactory.php';
		
		$start_row = (int)$this->input->post('offset')+6;
		$path_file = './assets/report/excel/';
		if( $this->input->post('offset') != 0 ){
			$objPHPExcel = PHPExcel_IOFactory::load($path_file.$this->input->post('filename'));
			$file_name = $this->input->post('filename');
		}else{
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator($this->jCfg['user']['fullname'])
										 ->setTitle("Surat Tanda Terima")
										 ->setSubject("Data Anggota")
										 ->setDescription("SURAT TANDA TERIMA")
										 ->setKeywords("SURAT")
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

			$colums = array('A' => 5, 'B' => 20, 'C' => 20, 'D' => 20); // set lebar masing-masing kolom
			$header = array('A' => 'NO', 'B' => 'NAMA', 'C' => '', 'D' => 'NPAPG'); // set nama header
			$merge_hor = array('B');
			$merge_vhor = array('B' => 'C');
					
			$objPHPExcel->getActiveSheet()->setShowGridlines(false); // menghilangkan grid lines	
			$objPHPExcel->getActiveSheet()->mergeCells('A1:D1'); // menggabungkan kolom untuk penulisan judul utama	
			$objPHPExcel->getActiveSheet()->mergeCells('A3:D3'); // menggabungkan kolom untuk penulisan judul pertama
			$objPHPExcel->getActiveSheet()->mergeCells('A4:D4'); // menggabungkan kolom untuk penulisan judul kedua
				
		    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'SURAT TANDA TERIMA'); // mengisi judul utama
		    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'TELAH DITERIMA DARI : DPP PARTAI GOLKAR'); // mengisi judul pertama
		    $objPHPExcel->getActiveSheet()->setCellValue('A4', 'BERUPA : '.strtoupper($proposer)); // mengisi judul kedua
		    
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleMainTitle); // set style untuk judul
			$objPHPExcel->getActiveSheet()->getStyle('A3:D4')->applyFromArray($styleTitle); // set style untuk judul
			
			$num = 6;
		    foreach ($header as $k => $v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k.($num-1), $v);
				
				if(in_array($k,$merge_hor))
					$objPHPExcel->getActiveSheet()->mergeCells($k.($num-1).':'.$merge_vhor[$k].($num-1)); // menggabungkan kolom horizontal
		    	
				$objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth($colums[$k]); // set width untuk tiap kolom sesuai dengan data pada array $colums
			}
			
			$objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($styleHeader); // set style untuk area header
			
			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTop(array(1, 5));
			
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); // 
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(45); // set skala untuk menampilkan satu halaman penuh saat di print

		    // Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('surat-tanda-terima');
			$objPHPExcel->setActiveSheetIndex(0);
			$file_name = 'SuratTandaTerima-'.date('dmy').'.xlsx';
		}
		$return['data']['filename'] = $file_name;
		$return['data']['proposer'] = $proposer;
		$return['data']['province'] = $prov;
		$return['data']['city']		= $ct;
		$return['data']['district'] = $dist;
		$return['data']['area']		= $area;
		$return['data']['offset']	= $this->input->post('offset')+$this->input->post('limit');

		// Miscellaneous glyphs, UTF-8
		$success = 0;
//		debugCode($data);
		foreach ((array)$data['data'] as $k => $v) {
			
			$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A'.$start_row, $start_row-5)
		            ->setCellValue('B'.$start_row, ' '.$v->kta_nama_lengkap.' ')
		            ->setCellValue('D'.$start_row, ' '.substr($v->kta_nomor_kartu,0,6)." ".substr($v->kta_nomor_kartu,6,4)." ".substr($v->kta_nomor_kartu,10,6).' ');
		   	
		    $objPHPExcel->getActiveSheet()->mergeCells('B'.$start_row.':C'.$start_row); // menggabungkan kolom horizontal
		   	
		    $success++;
		    $start_row++;
		    
		}
	    $objPHPExcel->getActiveSheet()->getStyle('A6:D'.($start_row-1))->applyFromArray($styleBorder);
	    
	    
	    $objPHPExcel->getActiveSheet()->setCellValue('A'.($start_row+2), 'YANG DITERIMA OLEH :');
	    $objPHPExcel->getActiveSheet()->setCellValue('A'.($start_row+3), 'BERUPA : '.$success.' KTA');
	    $objPHPExcel->getActiveSheet()->setCellValue('C'.($start_row+5), 'JAKARTA, '.get_date_id());
	    $objPHPExcel->getActiveSheet()->setCellValue('B'.($start_row+6), 'PEMBERI');
	    $objPHPExcel->getActiveSheet()->setCellValue('D'.($start_row+6), 'PENERIMA');
	    $objPHPExcel->getActiveSheet()->setCellValue('B'.($start_row+11), '(..............................)');
	    $objPHPExcel->getActiveSheet()->setCellValue('D'.($start_row+11), '(..............................)');
	    
	    $objPHPExcel->getActiveSheet()->mergeCells('C'.($start_row+5).':D'.($start_row+5));
	    $objPHPExcel->getActiveSheet()->getStyle('C'.($start_row+5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	    $objPHPExcel->getActiveSheet()->getStyle('B'.($start_row+6).':D'.($start_row+11))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    
		$return['data']['success'] = $success;
		$return['status'] = 1;
		if( count($data['data']) == 0 ){
			$return['status'] = 0;
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($path_file.$file_name);

		die(json_encode($return));
	}

}
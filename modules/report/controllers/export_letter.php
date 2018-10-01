<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Export_letter extends AdminController {  
	function __construct()    
	{
		parent::__construct();    
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title( 'Generate Export Data KTA BPPKKSS' );
		$this->DATA->table="sos_ttrans_claim";
		$this->folder_view = "report/";
		$this->prefix_view = strtolower($this->_getClass());
		
		$this->breadcrumb[] = array(
				"title"		=> "Export Data",
				"url"		=> $this->own_link
			); 

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			$this->_reset_advance();
		}

		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
 		
 		$this->load->model("mdl_report","M");
	}

	function _reset(){
		$this->jCfg['search'] = array(
								'class'		=> $this->_getClass(),
								'date_start'=> '',
								'date_end'	=> '',
								'status'	=> '',
								'sla'		=> 'all',
								'per_page'	=> 20,
								'order_by'  => 'date_claim',
								'order_dir' => 'DESC',
								'colum'		=> '',
								'is_done'	=> FALSE,
								'keyword'	=> ''
							);		
		$this->_releaseSession();
	}

	function _reset_advance(){
		$this->jCfg['transraw_search'] = array(
								'providerid'	=> '',
								'serviceid'		=> '',
								'name'			=> '',
								'date_start'	=> '',
								'date_end'		=> '',
								'clientid'		=> '',
								'location'		=> '',
								'cardno'		=> '',
								'relationship'	=> ''
							);
		$this->_releaseSession();
	}

	function index(){
		
		$this->js_file = array(
//                'export-member.js?r='.rand(1,1000)
            );
            
		$this->breadcrumb[] = array(
				"title"		=> "List"
			);
			
		$data = array();

		$this->_v($this->folder_view.$this->prefix_view,$data);
	}
	
	function search(){

		$this->breadcrumb[] = array(
				"title"		=> "List"
			);

		if($this->input->post('btn_reset')){
			$this->_v($this->folder_view.$this->prefix_view);
		}
		
		if($this->input->post('btn_search')){
			$par_filter = array(
					"offset"	=> $this->uri->segment($this->uri_segment),
					"propinsi"	=> $this->input->post('province'),
					"kabupaten"	=> $this->input->post('kabupaten'),
					"kecamatan"	=> $this->input->post('kecamatan'),
					"kelurahan"	=> $this->input->post('kelurahan'),
					"pengusul"	=> $this->input->post('pengusul'),
					"date_from" 	=> trim($this->input->post('date_from')),
					"date_to" 		=> trim($this->input->post('date_to'))
				);
			$this->data_table = $this->M->report_letter($par_filter);
			$data = $this->_data(array(
					"base_url"	=> $this->own_link.'/index'
			));
//			debugCode($data);
			$data['param'] = array(
					"propinsi"	=> $this->input->post('province'),
					"kabupaten"	=> $this->input->post('kabupaten'),
					"kecamatan"	=> $this->input->post('kecamatan'),
					"kelurahan"	=> $this->input->post('kelurahan'),
					"date_from" 	=> trim($this->input->post('date_from')),
					"date_to" 		=> trim($this->input->post('date_to')),
					"pengusul"	=> $this->input->post('pengusul')
			);
			$this->_v($this->folder_view.$this->prefix_view,$data);
		}
		if($this->input->post('print_excel')){
			$par_filter = array(
					"propinsi"	=> $this->input->post('province'),
					"kabupaten"	=> $this->input->post('kabupaten'),
					"kecamatan"	=> $this->input->post('kecamatan'),
					"kelurahan"	=> $this->input->post('kelurahan'),
					"pengusul"	=> $this->input->post('pengusul'),
					"date_from" 	=> trim($this->input->post('date_from')),
					"date_to" 		=> trim($this->input->post('date_to'))
			);
			$cetak = $this->M->report_letter($par_filter);
			$this->_v($this->folder_view.$this->prefix_view."_export",$cetak,false);
		}
	}

	function get_proposer(){
		$data = $this->db->get('app_propinsi')->result();
		if( count($data) > 0 ){	
			$return = array();
			foreach ($data as $k => $v) {
				$return[] = $v->propinsi_nama;
			}
			
			echo json_encode($return);
		} else echo json_encode(array());
	}
	
	function check_proposer(){
		$proposer = $this->input->post('proposer');
		$data = $this->db->get_where('app_propinsi',array('propinsi_nama' => $proposer))->row();
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
	
	function export_pdf(){
		$data = array();
		$proposer	= $this->input->post('proposer');
		$prov		= $this->input->post('province');
		$ct			= $this->input->post('city');
		$dist		= $this->input->post('district');
		$area		= $this->input->post('area');
		
		$file_name = 'DataAnggota-'.date('dmy');
		$par_filter = array("proposer" => $proposer,"province" => $prov,"city" => $ct,"district" => $dist,"area" => $area);
		$dt = $this->M->get_member($par_filter);
//		debugCode($dt['result']);		
		foreach((array)$dt['data'] as $k=>$v ){
			$province = $v->propinsi_nama;
			$city = $v->kab_nama;
			$district = $v->kec_nama;
			$province_number = $v->kta_propinsi;
			$city_number = $v->kta_kabupaten;
			$district_number = $v->kta_kecamatan;
			
			break;
		}
		
		require_once APPPATH.'libraries/mpdf60/mpdf.php';
	
		$html = '<html><head><title>'.str_replace('_', ' ', $file_name).'</title>		
			<style media="print">
				body { font-family: \'Open Sans\', sans-serif; font-size:10px; }
				.backcolor { background-color:#000; }		
				.backcolor th, .backcolor td { background-color:#FFF; padding:3px; }
				
				.canvas-kta {
					border:#000 1px solid;
					background-image: url(\''.base_url()."assets/images/id_card_small.jpg".'\'); 
					background-size: 250px 150px;
					background-repeat: no-repeat;
					height: 150px;
					width: 247px; 
				}
				.canvas-kta td { background-color:transparent; padding:0; }			
				.canvas-kta td.qrcode { padding:2px 6px; }
				.canvas-kta td.foto { padding:5px 16px 0 0; }
				.canvas-kta td.nama,.canvas-kta td.nomor,.canvas-kta td.domisili,.canvas-kta td.masa{
					padding:0 16px 0 0; 
				}
				.canvas-kta td.nama{
					font-size: 11px;
					font-weight: bold;
					line-height: 11px;
				}
				.canvas-kta td.nomor{
					font-size: 9px;
					line-height: 7px;
				}
				.canvas-kta td.domisili{
					font-size: 7px;
					line-height: 10px;
				}
				.canvas-kta td.masa{
					font-size: 5px;
				}
			</style>
		</head><body>';
		
		$html .= '<table width="100%">';
		$html .= '<tr><td align="center"><h3>DAFTAR DAN JUMLAH COPY KTA DAN KTP ANGGOTA PARTAI GOLKAR<h3></td></tr>';
		$html .= '<tr><td>';
			$html .= '<table width="100%">';
			$html .= '<tr><td></td></tr>';
			$html .= '<tr>
						<td width="150">PROVINSI</td><td width="10">:</td><td>'.$province.'</td>
						<td width="200">Kode Angka Propinsi</td><td width="10">:</td><td>'.$province_number.'</td>';
			$html .= '</tr><tr>
						<td>KABUPATEN/KOTA</td><td width="10">:</td><td>'.$city.'</td>
						<td>Kode Angka Kabupaten/Kota</td><td width="10">:</td><td>'.str_replace($province_number,'',$city_number).'</td>';
			$html .= '</tr><tr>
						<td>KECAMATAN</td><td width="10">:</td><td>'.$district.'</td>
						<td>Kode Angka Kecamatan</td><td width="10">:</td><td>'.str_replace($city_number,'',$district_number).'</td>
					  </tr>';
			$html .= '<tr><td></td></tr>';
			$html .= '</table>';
		$html .= '</td></tr>';
		$html .= '</table>';
		
			$x=0; $y=5;
			foreach((array)$dt['data'] as $k=>$v ){
				$content='';
				$qrcode = generate_qr_code(substr($v->kta_nomor_kartu,0,6).substr($v->kta_nomor_kartu,6,4).substr($v->kta_nomor_kartu,10,6));
				
				$content .= '<tr>
							<td valign="top" width="30">'.++$no.'</td>
							<td valign="top">'.++$no.'</td>
							<td valign="top">'.strtoupper($v->kta_nama_lengkap).'</td>
							<td align="center" width="260">';
						$content .= '<table class="canvas-kta">
									<tr>
										<td align="right" class="qrcode"><img src="'.$qrcode.'" style="height:26px; width:26px;" /></td>
									</tr>
									<tr>
										<td align="right" class="foto">';
						
							$content .= '	<img alt="" src="'.(!empty($v->kta_foto_wajah)?$v->kta_foto_wajah:base_url().'assets/images/no_image.jpg').'" style="height:65px; width:50px;"/>';
						$content .= '	</td>
									</tr>
									<tr>
										<td align="right" class="nama">'.strtoupper($v->kta_nama_lengkap).'</td>
									</tr>
									<tr>
										<td align="right" class="nomor">NPAPG '.substr($v->kta_nomor_kartu,0,6)." ".substr($v->kta_nomor_kartu,6,4)." ".substr($v->kta_nomor_kartu,10,6).'</td>
									</tr>
									<tr>
										<td align="right" class="domisili">'.$v->kab_nama." - ".$v->propinsi_nama.'</td>
									</tr>
									<tr>
										<td align="right" class="masa">'.date('m/Y',strtotime($v->time_add)).'</td>
									</tr>
								</table>';
						
					$content .= '</td>
							<td align="center" width="250">';
						$content .= !empty($v->kta_foto_ktp)?'<img alt="" src="'.$v->kta_foto_ktp.'" style="height:160px; width:250px;" />':'';
					$content .= '</td>
						</tr>';
				
				if($x == 0) {
					$html .= '<table class="backcolor" width="100%">';
					if($y == 5) {
						$html .= '	<tr>
										<th>No.</th>
										<th>Nomor Arsip</th>
										<th>Nama Lengkap</th>
										<th>Copy KTA</th>
										<th>Copy KTP</th>
									</tr>';
					} 
				}
				
				$html .= $content;

				$x++;	
				if($x == $y) {
					$html .= '</table><br/>';
					
					$x=0; $y=6;
				}
			}
			
			if($x<5) 
				$html .= '</table>  ';
		
	//	echo $html;
		$mpdf=new mPDF('en-GB-x','A4-P'); 
	
		$mpdf->WriteHTML($html);
		
		$mpdf->Output('assets/report/pdf/'.$file_name.'.pdf', 'F');
		$return['status'] = 1;
		
		die(json_encode($return));		
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
			$province_number = $v->kta_propinsi;
			$city_number = $v->kta_kabupaten;
			$district_number = $v->kta_kecamatan;
			
			break;
		}

		//start..
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		require_once APPPATH.'libraries/PHPExcel.php';
		require_once APPPATH.'libraries/PHPExcel/IOFactory.php';
		
		$start_row = (int)$this->input->post('offset')+10;
		$path_file = './assets/report/excel/';
		if( $this->input->post('offset') != 0 ){
			$objPHPExcel = PHPExcel_IOFactory::load($path_file.$this->input->post('filename'));
			$file_name = $this->input->post('filename');
		}else{
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator($this->jCfg['user']['fullname'])
										 ->setTitle("Report Data Member")
										 ->setSubject("Data Member")
										 ->setDescription("JUMLAH DAN DAFTAR NAMA ANGGOTA PARTAI GOLKAR")
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

			$colums = array('A' => 5, 'B' => 40, 'C' => 2, 'D' => 2, 'E' => 3, 'F' => 2); // set lebar masing-masing kolom
			$header_first = array('A' => 'NO', 'B' => 'NPAPG', 'C' => 'NAMA', 'D' => 'ALAMAT / KOTA', 'E' => 'TANGGAL PENERBITAN', 'F' => 'KET'); // set nama header
/*			$hf_merge_ver = array('A','R','S');
			$hf_merge_hor = array('C','E','L');
			$hf_merge_vhor = array('C' => 'D', 'E' => 'I', 'L' => 'P');
			$header_second = array('B' => 'Sesuai KTP', 'C' => 'L', 'D' => 'P', 'E' => 'Tgl', 'F' => '/', 'G' => 'Bln', 'H' => '/', 'I' => 'Thn', 'J' => 'Tahun', 
					'K' => 'Sesuai KTP', 'L' => '( 16 digit )', 'Q' => '( 16 digit )'); // set nama header
			$hs_merge_ver = array('B','C','D','E','F','G','H','I','J','K');
			$hs_merge_hor = array('L');
			$hs_merge_vhor = array('L' => 'P');
			$header_third = array('L' => 'Prop', 'M' => 'Kab / Kot', 'N' => 'Kec', 'O' => 'Ds/Kel', 'P' => 'Angt', 'Q' => 'Sesuai KTP'); // set nama header
*/					
			$objPHPExcel->getActiveSheet()->setShowGridlines(false); // menghilangkan grid lines	
/*			$objPHPExcel->getActiveSheet()->mergeCells('A1:S1'); // menggabungkan kolom untuk penulisan judul utama	
			$objPHPExcel->getActiveSheet()->mergeCells('A3:D3'); // menggabungkan kolom untuk penulisan judul pertama
			$objPHPExcel->getActiveSheet()->mergeCells('A4:D4'); // menggabungkan kolom untuk penulisan judul kedua
			$objPHPExcel->getActiveSheet()->mergeCells('A5:D5'); // menggabungkan kolom untuk penulisan judul ketiga
			$objPHPExcel->getActiveSheet()->mergeCells('E3:K3'); // menggabungkan kolom untuk penulisan judul pertama
			$objPHPExcel->getActiveSheet()->mergeCells('E4:K4'); // menggabungkan kolom untuk penulisan judul kedua
			$objPHPExcel->getActiveSheet()->mergeCells('E5:K5'); // menggabungkan kolom untuk penulisan judul ketiga	
			$objPHPExcel->getActiveSheet()->mergeCells('L3:P3'); // menggabungkan kolom untuk penulisan judul pertama
			$objPHPExcel->getActiveSheet()->mergeCells('L4:P4'); // menggabungkan kolom untuk penulisan judul kedua
			$objPHPExcel->getActiveSheet()->mergeCells('L5:P5'); // menggabungkan kolom untuk penulisan judul ketiga
*/				
		    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'JUMLAH DAN DAFTAR NAMA ANGGOTA PARTAI GOLKAR'); // mengisi judul utama
//		    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PROVINSI : '.$province.' Kode Angka Provinsi : ( '.$province_number.' )'); // mengisi judul pertama
//		    $objPHPExcel->getActiveSheet()->setCellValue('A4', 'KABUPATEN / KOTA : '.$city.' Kode Angka Kabupaten/Kota : ( '.str_replace($province_number,'',$city_number).' )'); // mengisi judul kedua
//		    $objPHPExcel->getActiveSheet()->setCellValue('A5', 'KECAMATAN : '.$district.' Kode Angka Kecamatan : ( '.str_replace($city_number,'',$district_number).' )'); // mengisi judul kedua
		    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'PROVINSI'); // mengisi judul pertama
		    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'KABUPATEN / KOTA'); // mengisi judul kedua
		    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'KECAMATAN'); // mengisi judul kedua
//		    $objPHPExcel->getActiveSheet()->setCellValue('E1', ': '.strtoupper($province)); // mengisi judul pertama
//		    $objPHPExcel->getActiveSheet()->setCellValue('F1', ': '.strtoupper($city)); // mengisi judul kedua
/*		    $objPHPExcel->getActiveSheet()->setCellValue('E5', ': '.strtoupper($district)); // mengisi judul kedua
		    $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Kode Angka Provinsi'); // mengisi judul pertama
		    $objPHPExcel->getActiveSheet()->setCellValue('L4', 'Kode Angka Kabupaten/Kota'); // mengisi judul kedua
		    $objPHPExcel->getActiveSheet()->setCellValue('L5', 'Kode Angka Kecamatan'); // mengisi judul kedua
		    $objPHPExcel->getActiveSheet()->setCellValue('Q3', ': ( '.$province_number.' )'); // mengisi judul pertama
		    $objPHPExcel->getActiveSheet()->setCellValue('Q4', ': ( '.str_replace($province_number,'',$city_number).' )'); // mengisi judul kedua
		    $objPHPExcel->getActiveSheet()->setCellValue('Q5', ': ( '.str_replace($city_number,'',$district_number).' )'); // mengisi judul kedua
		    
			$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($styleMainTitle); // set style untuk judul
			$objPHPExcel->getActiveSheet()->getStyle('A3:S5')->applyFromArray($styleTitle); // set style untuk judul
*/			
			$num = 10;
/*		    foreach ($header_first as $k => $v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k.($num-3), $v);
				if(in_array($k,$hf_merge_ver))
					$objPHPExcel->getActiveSheet()->mergeCells($k.($num-3).':'.$k.($num-1)); // menggabungkan kolom vertical
					
				if(in_array($k,$hf_merge_hor))
					$objPHPExcel->getActiveSheet()->mergeCells($k.($num-3).':'.$hf_merge_vhor[$k].($num-3)); // menggabungkan kolom horizontal
		    	
				$objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth($colums[$k]); // set width untuk tiap kolom sesuai dengan data pada array $colums
			}
		    foreach ($header_second as $k => $v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k.($num-2), $v);
				if(in_array($k,$hs_merge_ver))
					$objPHPExcel->getActiveSheet()->mergeCells($k.($num-2).':'.$k.($num-1)); // menggabungkan kolom vertical
					
				if(in_array($k,$hs_merge_hor))
					$objPHPExcel->getActiveSheet()->mergeCells($k.($num-2).':'.$hs_merge_vhor[$k].($num-2)); // menggabungkan kolom horizontal
		    	
				$objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth($colums[$k]); // set width untuk tiap kolom sesuai dengan data pada array $colums
			}
		    foreach ($header_third as $k => $v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k.($num-1), $v);
		    	
				$objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth($colums[$k]); // set width untuk tiap kolom sesuai dengan data pada array $colums
				$objPHPExcel->getActiveSheet()->getStyle($colums[$k].'9')->getAlignment()->setWrapText(true);
			}
*/			
//			$objPHPExcel->getActiveSheet()->getStyle('A'.$start.':S'.($num+3))->applyFromArray($styleAll); // set style untuk area A5 sampai M(sebanyak berapa baris datanya)
			$objPHPExcel->getActiveSheet()->getStyle('A7:S9')->applyFromArray($styleHeader); // set style untuk area header
			
			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTop(array(1, 9));
			
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); // 
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(45); // set skala untuk menampilkan satu halaman penuh saat di print

		    // Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('data-anggota');
			$objPHPExcel->setActiveSheetIndex(0);
			$file_name = 'DataAnggota-'.date('dmy').'.xlsx';
		}
		$return['data']['filename'] = $file_name;
		$return['data']['proposer'] = $proposer;
		$return['data']['offset'] = $this->input->post('offset')+$this->input->post('limit');

		// Miscellaneous glyphs, UTF-8
		$success = 0;
		//debugCode($data);
		foreach ((array)$data['data'] as $k => $v) {
			$biday = new DateTime($v->kta_tgl_lahir);
			$today = new DateTime();
			$diff = $today->diff($biday);
			
			$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A'.$start_row, $start_row-9)
		            ->setCellValue('B'.$start_row, $v->kta_nomor_kartu)
		            ->setCellValue('C'.$start_row, strtoupper($v->kta_nama_lengkap))
		            ->setCellValue('D'.$start_row, $v->kab_nama.','.$v->propinsi_nama)
		            ->setCellValue('E'.$start_row, date('j', strtotime($v->kta_tgl_lahir)))
		            ->setCellValue('F'.$start_row, '/');
/*		            ->setCellValue('G'.$start_row, date('n', strtotime($v->kta_tgl_lahir)))
		            ->setCellValue('H'.$start_row, '/')
		            ->setCellValue('I'.$start_row, date('Y', strtotime($v->kta_tgl_lahir)))
		            ->setCellValue('J'.$start_row, $diff->y)
		            ->setCellValue('K'.$start_row, strtoupper($v->kel_nama))
		            ->setCellValue('L'.$start_row, $v->kta_propinsi.' ')
		            ->setCellValue('M'.$start_row, $v->kta_kabupaten.' ')
		            ->setCellValue('N'.$start_row, $v->kta_kecamatan.' ')
		            ->setCellValue('O'.$start_row, $v->kta_kelurahan.' ')
		            ->setCellValue('P'.$start_row, $v->kta_nomor.' ')
		            ->setCellValue('Q'.$start_row, $v->kta_nomor_kartu.' ')
		            ->setCellValue('R'.$start_row, strtoupper($v->kta_alamat))
		            ->setCellValue('S'.$start_row, '');
*/		            
			$objPHPExcel->getActiveSheet()->getStyle('R'.$start_row)->getAlignment()->setWrapText(true);
		    $success++;
		    $start_row++;
		}
	    $objPHPExcel->getActiveSheet()->getStyle('A10:S'.$start_row)->applyFromArray($styleBorder);
	    
		$return['data']['success'] = $success;
		$return['status'] = 1;
		if( count($data['data']) == 0 ){
			$return['status'] = 0;
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($path_file.$file_name);

		die(json_encode($return));
	}
	
	function print_excel(){
			$par_filter = array(
				"propinsi"		=> $this->input->post('province'),
				"pengusul"		=> $this->input->post('pengusul')
			);
			$cetak = $this->M->kta($par_filter);
			$this->_v($this->folder_view.$this->prefix_view."_export",$cetak,false);
	}
	function print_photo(){
//			$this->load->dbutil();
//			$this->load->helper('file');
			$this->load->helper('download');
			$id=_decrypt(dbClean(trim($this->input->get('_id'))));
			$get_foto = $this->db->query("
				select kta_foto_wajah
				from app_kta where kta_id = '".$id."'
			")->row();
//			$file_name = $get_foto->kta_foto_wajah;	
			
			$file_name = '591bf6b7337c41231231231231213_ktp.png';
			$path  = base_url().'/assets/collections/kta/photo/';
			$nama = 'aa.jpg';
			$content = file_get_contents($path, $file_name);
			force_download($nama,$content);
			
	/*		$par_filter = array(
				"propinsi"		=> $this->input->post('province'),
				"pengusul"		=> $this->input->post('pengusul')
			);			
			$cetak = $this->M->kta($par_filter);
			$this->_v($this->folder_view.$this->prefix_view."_zip",$cetak,false);				
	*/
	
	}

}
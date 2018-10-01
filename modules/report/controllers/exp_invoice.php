<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Exp_invoice extends AdminController {  
	function __construct()    
	{
		parent::__construct();    
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title( 'Cetak Invoice' );
		$this->DATA->table="app_data_cetak";
		$this->folder_view = "report/";
		$this->prefix_view = strtolower($this->_getClass());
		
		$this->breadcrumb[] = array(
				"title"		=> "Cetak Invoice",
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
                'export-invoice.js?r='.rand(1,1000)
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
	
	function show_data(){		
		$return = array(
				"status" => 0,
				"data"=> ""
			);
			
		$data = array();
		$proposer	= $this->input->post('proposer');
			
		$tmp_data = $this->M->get_data_cetak(array("proposer"	=> $proposer));
		$new_data = array();
		foreach((array)$tmp_data as $k=>$v ){
			$v->cetak_tanggal = myDate($v->cetak_tanggal,"d M Y H:i:s");
			$new_data[] = $v;
		}
		if(count($new_data) > 0) {
			$return = array(
					"status" => 1,
					"data"=> $new_data
				);
		}
			
		die(json_encode($return));
	}
	
	function gen_invoice(){
		$data		= array();
		$proposer	= $this->input->post('proposer');
		$receiver	= $this->input->post('receiver');
		$idc		= $this->input->post('idc');
		
					  $this->db->order_by('inv_id','desc');
		$c			= $this->db->get('app_data_invoice')->row();
		$invcode	= isset($c->inv_kode)?((intval($c->inv_kode)+1)<10?'000':(intval($c->inv_kode)<100?'00':(intval($c->inv_kode)<1000?'0':''))).(intval($c->inv_kode)+1):'0001';
		$date		= date('Y-m-d H:i:s');
		
		$prop		= $this->db->get_where('app_propinsi',array('propinsi_id' => $receiver))->row();
		$biaya		= $this->db->get_where('app_biaya_kirim',array('bk_tujuan' => $receiver))->row();
		
		$file_name	= 'Invoice-'.$proposer.'-'.date('dmyHis');
		$par_filter	= array("idc" => $idc);
		$dt			= $this->M->get_data_cetak($par_filter);		
		foreach((array)$dt as $k=>$v ){
			$pname = $v->nama_pengguna;						
			break;
		}
		
		require_once APPPATH.'libraries/mpdf60/mpdf.php';
	
		$html = '<html><head><title>'.str_replace('_', ' ', $file_name).'</title>		
			<style media="print">
				body { font-family: \'Open Sans\', sans-serif; font-size:10px; }
				.backcolor { background-color:#000; }		
				.backcolor th, .backcolor td { background-color:#FFF; padding:3px; }
			</style>
		</head><body>';
		
		$html .= '<table width="100%">';
		$html .= '<tr><td align="center"><h2>INVOICE<h2></td></tr>';
		$html .= '<tr><td>';
			$html .= '<table width="100%">';
			$html .= '<tr><td></td></tr><tr><td></td></tr>';
			$html .= '<tr>
						<td width="100">PENERIMA</td><td width="10">:</td><td>'.strtoupper($pname).'</td>
						<td width="100">NO. INVOICE</td><td width="10">:</td><td>'.$invcode.'</td>';
			$html .= '</tr><tr>
						<td>JENIS BARANG</td><td width="10">:</td><td>KARTU TANDA ANGGOTA PARTAI GOLKAR</td>
						<td>DEPARTURE</td><td width="10">:</td><td>JAKARTA</td>';
			$html .= '</tr><tr>
						<td>TANGGAL</td><td width="10">:</td><td>'.myDate($date).'</td>
						<td>ARRIVAL</td><td width="10">:</td><td>'.strtoupper($prop->propinsi_nama).'</td>
					  </tr>';
			$html .= '</tr><tr>
						<td>BRIVA</td><td width="10">:</td><td></td>
					  </tr>';
			$html .= '<tr><td></td></tr>';
			$html .= '</table>';
		$html .= '</td></tr>';
		$html .= '</table>';
		
			$x=0; $y=9; $tberat=0; $tjumlah=0; $tharga=0; $codes='';
//			debugCode($v);
			foreach((array)$dt as $k=>$v ){
				$content='';
				$berat = ceil(intval($v->cetak_jumlah)/100);
				$total = intval($berat)*intval($biaya->bk_biaya)+(intval($v->cetak_jumlah)*intval(cfg('harga_kta')));
				
				$content .= '<tr>
							<td>'.$v->nama_pengguna.'</td>
							<td align="center">'.$v->cetak_kode.'</td>
							<td align="right">'.$berat.' Kg</td>
							<td align="right">Rp. '.number_format($biaya->bk_biaya,0).'</td>
							<td align="center">'.$v->cetak_jumlah.'</td>
							<td align="right">Rp. '.number_format(cfg('harga_kta'),0).'</td>
							<td align="right">Rp. '.number_format($total,0).'</td>
						</tr>';
				
				if($x == 0) {
					$html .= '<table class="backcolor" width="100%">';
					if($y == 9) {
						$html .= '	<tr>
										<th>Pengusul</th>
										<th>Data<br>Export</th>
										<th>Berat<br>(a)</th>
										<th>Biaya Kirim (1 Kg)<br>(b)</th>
										<th>Jumlah KTA<br>(c)</th>
										<th>Harga KTA<br>(d)</th>
										<th>Total<br>(a x b)+(c x d)</th>
									</tr>';
					} 
				}
				
				$html .= $content;

				$x++; 
				$tberat += $berat; 
				$tjumlah += intval($v->cetak_jumlah); 
				$tharga += $total; 
				$codes.=(empty($codes)?'':',').$v->cetak_kode;
				if($x == $y) {
					$html .= '</table><br/>';
					
					$x=0; $y=10;
				}
			}
			$html .= '	<tr>
							<td colspan="2" align="right">Total Berat</td>
							<td align="right">'.$tberat.' Kg</td>
							<td colspan="3" align="right">Total Harga</td>
							<td align="right">Rp. '.number_format($tharga,0).'</td>
						</tr>';
			if($x<9) 
				$html .= '</table>  ';
		
//		echo $html;
		$mpdf=new mPDF('en-GB-x','A4-P'); 
	
		$mpdf->WriteHTML($html);
		
		$mpdf->Output('assets/report/pdf/'.$file_name.'.pdf', 'F');
		$return = array(
				'status'		=> 1,
				'invcode'		=> str_replace('=','',base64_encode($invcode)),
				'proposerid'	=> str_replace('=','',base64_encode($proposer)),
				'printids'		=> str_replace('=','',base64_encode($codes)),
				'qty'			=> str_replace('=','',base64_encode($tjumlah)),
				'weight'		=> str_replace('=','',base64_encode($tberat)),
				'receiver'		=> str_replace('=','',base64_encode($receiver)),
				'cost'			=> str_replace('=','',base64_encode($biaya->bk_biaya)),
				'price'			=> str_replace('=','',base64_encode($tharga)),
				'filepdf'		=> $file_name.'.pdf'
			);
			
		die(json_encode($return));	
	}
	
	function update_data(){
		$invcode	= $this->input->post('invcode');
		$proposerid	= $this->input->post('proposerid');
		$printids	= $this->input->post('printids');
		$qty		= $this->input->post('qty');
		$weight		= $this->input->post('weight');
		$receiver	= $this->input->post('receiver');
		$cost		= $this->input->post('cost');
		$price		= $this->input->post('price');
		$date		= date('Y-m-d H:i:s');
		$return		= array('status' => 0, 'msg' => 'Update gagal');
		
		if(!empty($printids)) {			
			$data = array(
					'inv_kode'			=> base64_decode($invcode),  
					'inv_pengusul'		=> base64_decode($proposerid),
					'inv_kode_cetak'	=> base64_decode($printids),
					'inv_jumlah'		=> base64_decode($qty),
					'inv_harga'			=> base64_decode($cost),
					'inv_berat'			=> base64_decode($weight),
					'inv_tujuan'		=> base64_decode($receiver),
					'inv_biaya'			=> cfg('harga_kta'),
					'inv_total'			=> base64_decode($price),
					'inv_tanggal'		=> $date,
					'inv_user'			=> $this->jCfg['user']['id']
			);			
			
			$i = $this->db->insert('app_data_invoice',$data);			
			if($i) {
				$this->db->set("cetak_invoice", 1);  
				$this->db->where("cetak_kode in ('".str_replace(",","','", base64_decode($printids))."')");
				$p = $this->db->update('app_data_cetak');
				
				$return = array('status' => 1, 'msg' => 'Update berhasil', "go_to" => site_url('report/exp_invoice'));
			}
		}
		
		die(json_encode($return));
	}

}
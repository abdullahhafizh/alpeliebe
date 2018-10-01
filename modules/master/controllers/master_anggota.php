<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");

require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Master_anggota extends AdminController {//
  function __construct()
  {
    parent::__construct();
    error_reporting(E_ALL);
    $this->_set_action();
    $this->_set_action(array("edit","delete"),"ITEM"); //"view"
    $this->_set_title('Daftar Anggota ALPENINDO');
    $this->DATA->table="app_kta";
    $this->folder_view = "master/";
    $this->prefix_view = strtolower($this->_getClass());
    $this->breadcrumb[] = array(
      "title"     => "Master Anggota",
      "url"       => $this->own_link
    );

    $this->upload_path="./assets/collections/kta/photo/";

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

  function _berikut() {
    $counter = $pageAPIHnsi++;
    $_SESSION['konter'] = $counter;
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

  function search(){    
    $this->breadcrumb[] = array(
      "title"		=> "List"
    );

    if($this->input->post('btn_reset')){
     $this->_reset();
   }

   if ($this->input->post('btn_berikut')) {
    $this->_berikut();
  }

  $par_filter = array(
    "offset"	=> $this->uri->segment($this->uri_segment),
    "propinsi"	=> $this->input->post('propinsi'),
    "kabupaten"	=> $this->input->post('kabupaten'),
    "kecamatan"	=> $this->input->post('kecamatan'),
    "kelurahan"	=> $this->input->post('kelurahan'),
    "pengusul"	=> $this->input->post('pengusul'),
    "nama"		=> $this->input->post('nama'),
    "param"		=> $this->cat_search
  );

  $this->data_table = $this->M->kta_list($par_filter);

  $data = $this->_data(array(
    "base_url"	=> $this->own_link.'/index'
  ));

  $data['param'] = array(
    "tingkat" => trim($this->input->post('tingkat')),
    "nama"	=> $this->input->post('nama'),
      // "kecamatan"	=> $this->input->post('kecamatan'),
      // "kelurahan"	=> $this->input->post('kelurahan'),
      // "pengusul"	=> $this->input->post('pengusul'),
      // "nama"		=> $this->input->post('nama'),
    "key"    => $this->input->post('key'),
  );

  $_SESSION['tingkat_kta'] = $this->input->post('tingkat');
  $_SESSION['nama_kta'] = $this->input->post('nama');
  $_SESSION['keyword'] = $this->input->post('keyword');
  $_SESSION['angkatan'] = $this->input->post('angkatan');
  $data['json_decoded'] = getall("Group|".$this->input->post('nama'), $this->input->post('angkatan'), $this->input->post('keyword'), 0);
  $this->_v($this->folder_view.$this->prefix_view,$data);
}

function reset() {  
  unset($_SESSION['tingkat_kta']);
  unset($_SESSION['nama_kta']);
  unset($_SESSION['keyword']);
  unset($_SESSION['angkatan']);
  redirect("/master/master_anggota");
}

function export() {  
  $spreadsheet = new Spreadsheet();

// Set document properties
  $spreadsheet->getProperties()->setCreator('Tester')
  ->setLastModifiedBy('Tester')
  ->setTitle('Judul')
  ->setSubject('Subject')
  ->setDescription('Deskripsi')
  ->setKeywords('keyword')
  ->setCategory('category');

// Add some data
  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A1', 'NO')
  ->setCellValue('B1', 'NAMA LENGKAP')
  ->setCellValue('C1', 'NOMOR KARTU')
  ->setCellValue('D1', 'ALUMNI')
  ->setCellValue('E1', 'TINGKAT')
  ->setCellValue('F1', 'ANGKATAN')
  ->setCellValue('G1', 'NEGARA')
  ->setCellValue('H1', 'PROVINSI')
  ->setCellValue('I1', 'KAB/KOTA')
  ->setCellValue('J1', 'ALAMAT')
  ->setCellValue('K1', 'TTL')
  ->setCellValue('L1', 'STATUS CETAK')
  ;

  $data = getall("Group|".$_SESSION['nama_kta'], $_SESSION['angkatan'], $_SESSION['keyword'], 0);
// debugCode($provinsi);

// Miscellaneous glyphs, UTF-8
  if (isset($_SESSION['tingkat_kta'])) {
    if ($_SESSION['tingkat_kta'] == 1) {
      $tingkat = "sma";
    }
    if ($_SESSION['tingkat_kta'] == 2) {
      $tingkat = "smp";
    }
    if ($_SESSION['tingkat_kta'] == 3) {
      $tingkat = "sd";
    }
    if ($_SESSION['tingkat_kta'] == 4) {
      $tingkat = "tk";
    }
    if ($_SESSION['tingkat_kta'] == 5) {
      $tingkat = "staff";
    }
  }

  $i = 2;
  foreach($data['data'] as $value) {
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, $i-1)
    ->setCellValue('B'.$i, $value['full_name'])
    ->setCellValue('C'.$i, $value['card_no'])
    ->setCellValue('D'.$i, $value['school_and_staff'][''.$tingkat.'']['school']['name'])
    ->setCellValue('E'.$i, strtoupper($tingkat))
    ->setCellValue('F'.$i, $value['school_and_staff'][''.$tingkat.'']['year_in'])
    ->setCellValue('G'.$i, $value['address']['country']['name'])
    ->setCellValue('H'.$i, $value['address']['province']['name'])
    ->setCellValue('I'.$i, $value['address']['kabupaten']['name'])
    ->setCellValue('J'.$i, $value['address']['street']." Rt.".$value['address']['rt']."/".$value['address']['rw'].".".$value['address']['postal_code'])
    ->setCellValue('K'.$i, $value['birth_place'].", ".date("j F Y", strtotime($value['birth_date'])))
    ->setCellValue('L'.$i, $value['card_printed']);
    $i++;
  }

  // Rename worksheet
  $spreadsheet->getActiveSheet()->setTitle('Report Excel '.date('d-m-Y H'));

  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $spreadsheet->setActiveSheetIndex(0);

  // Redirect output to a client’s web browser (Xlsx)
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Report Excel.xlsx"');
  header('Cache-Control: max-age=0');
  // If you're serving to IE 9, then the following may be needed
  header('Cache-Control: max-age=1');

  // If you're serving to IE over SSL, then the following may be needed
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
  header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
  header('Pragma: public'); // HTTP/1.0

  $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
  $writer->save('php://output');
  exit;
}

function index(){
  $this->breadcrumb[] = array(
    "title"     => "List"
  );

  $par_filter = array(
    "offset"    => $this->uri->segment($this->uri_segment),
    "type_data" => 1,
    "param"     => $this->cat_search
  );

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

function save(){
  $get_max = $this->db->query("
    select max(SUBSTRING(kta_nomor,-5)) as nomor
    from app_kta where kta_nomor !='' AND kta_kelurahan = '".$this->input->post('kta_kelurahan')."'
    ")->row();

  $get_npapg = $this->db->query("
    select kta_nomor_kartu
    from app_kta where kta_id = '".$this->input->post('kta_id')."'
    ")->row();

  $get_ktp = $this->db->query("
    select count(kta_no_id) as ktp
    from app_kta where kta_no_id = '".$this->input->post('kta_no_ktp')."'
    ")->row();

  $get_kd_prop = $this->db->query("
    select propinsi_kode
    from app_propinsi where propinsi_kode = '".$this->input->post('kta_propinsi')."'
    ")->row();

  $get_kd_kab = $this->db->query("
    select kab_kode
    from app_kabupaten where kab_kode = '".$this->input->post('kta_kabupaten')."'
    ")->row();

  $get_kd_kec = $this->db->query("
    select kec_kode
    from app_kecamatan where kec_kode = '".$this->input->post('kta_kecamatan')."'
    ")->row();

  $get_kd_kel = $this->db->query("
    select kel_kode
    from app_kelurahan where kel_kode = '".$this->input->post('kta_kelurahan')."'
    ")->row();

  $tgl_lahir = $this->input->post('kta_thn_lahir')."-".$this->input->post('kta_bln_lahir')."-".$this->input->post('kta_tgl_lahir');

  $kta_jenkel 		= !empty($_POST['kta_jenkel'])?$_POST['kta_jenkel']:"";
//			$kta_status_nikah 	= !empty($_POST['kta_status_nikah'])?$_POST['kta_status_nikah']:"";
  $kta_agama 			= !empty($_POST['kta_agama'])?$_POST['kta_agama']:"";
  $kta_pendidikan 	= !empty($_POST['kta_pendidikan'])?$_POST['kta_pendidikan']:"";
  $kta_pekerjaan 		= !empty($_POST['kta_pekerjaan'])?$_POST['kta_pekerjaan']:"";
//			$kta_tingkat 		= !empty($_POST['kta_tingkat'])?$_POST['kta_tingkat']:"";
  $idx 				= isset($get_max->nomor)&&trim($get_max->nomor)!=0?(int)$get_max->nomor+1:1;
  $tanggal_kirim 		= date("Y-m-d h:i:s");
  $nomor_kta 			= empty($_POST['kta_nomor'])?str_repeat("0", 6-strlen($idx)).$idx:$_POST['kta_nomor'];
  $nk					= substr($nomor_kta,2,4);
  $nomor_kartu 		= empty($_POST['npapg_old'])?$get_kd_kec->kec_kode.$get_kd_kel->kel_kode.$nk:$_POST['npapg_old'];

//			if(empty($get_npapg->kta_nomor_kartu)){
//			}else{
//				$nomor_kta 			= "";
//				$nomor_kartu 		= "";
//			}

//			$foto 				= $this->input->post('data_url');
//			$wajah 				= explode(",",$foto[0]);
  $today 				= date("Y-m-d H:i:s");
//		file_put_contents("./assets/collections/kta/".$nomor_kartu, $wajah);

  $data = array(
    'kta_nomor'						=> $nomor_kta,
    'kta_nama_lengkap'				=> $this->input->post('kta_nama_lengkap'),
    'kta_nomor_kartu'				=> $nomor_kartu,
    'kta_nomor_kartu_old'			=> $this->input->post('npapg'),
    'kta_kelurahan'					=> $this->input->post('kta_kelurahan'),
  );

  $a = $this->_save_master(
    $data,
    array(
      'kta_id' => dbClean($_POST['kta_id'])
    ),
    dbClean($_POST['kta_id'])
  );
  $id = $a['id'];

  $p = $this->_uploaded(
    array(
      'id'		=> $id ,
      'input'		=> 'upload_foto',
      'param'		=> array(
        'nama' => "_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_foto",
        'field' => 'kta_foto_wajah',
        'par'	=> array('kta_id' => $id)
      )
    ));
  debugCode($p);
  $m = $this->_uploaded(
    array(
      'id'		=> $id ,
      'input'		=> 'upload_ktp',
      'param'		=> array(
        'nama' => "_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_wajah",
        'field' => 'kta_foto_ktp',
        'par'	=> array('kta_id' => $id)
      )
    ));

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

function update(){
  $id=$this->input->post('id');
  if(trim($id) != ''){
    $o = $this->DATA->_update(
      array("kta_id"  => idClean($id)),
      array("is_cetak"  		 => 1,
        "time_print_card"  => date("Y-m-d H:i:s"),
        "col14"  			 => $this->jCfg['user']['id'],
      )
    );
    echo $o;
  }
}

function detail(){
  $this->breadcrumb[] = array(
    "title"     => "MIGRASI"
  );
  $id=_decrypt(dbClean(trim($this->input->get('_id'))));

  if(trim($id)!=''){
    $mo = $this->M->kta(array(
      'id'    => $id
    ));
    $this->data_form = $vx = $mo['data'][0];
    $is_expired = $vx->kta_expired_date < date("Y-m-d")?true:false;
    $this->_v($this->folder_view.$this->prefix_view."_edit",array(
      "is_expired" => "",
      "perpanjang" => ""
    ));
  }else{
    redirect($this->own_link);
  }
}

function show_table(){
  $draw = intval($this->input->get("draw"));
  $start = intval($this->input->get("start"));
  $length = intval($this->input->get("length"));
  $this->per_page=10;
  $par_filter = array(
//				"offset"	=> $this->uri->segment($this->uri_segment),
    "propinsi"	=> $this->input->post('propinsi'),
    "kabupaten"	=> $this->input->post('kabupaten'),
    "kecamatan"	=> $this->input->post('kecamatan'),
    "kelurahan"	=> $this->input->post('kelurahan'),
    "pengusul"	=> $this->input->post('pengusul'),
    "nama"		=> $this->input->post('nama')
  );
//		debugCode($par_filter);
  $this->data_table = $this->M->kta_list($par_filter);
  $data = $this->data_table;

  foreach($data['data'] as $r){
    if($r->kta_status_data == 0 ){
      $status =  '<span class="label label-warning">Entry</span>';
    }elseif($r->kta_status_data == 1 ){
      $status =  '<span class="label label-success">Approved</span>';
    }elseif($r->kta_status_data == 2 ){
      $status =  '<span class="label label-info">Uploaded</span>';
    }else{
      $status =  '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="'.$r->col6.'">Rejected</span>';
    }
    $id = _encrypt($r->kta_id);
    $url = $this->own_link."/edit/?_id=".$id;
    $edit = "<a href='$url'><span class='label label-default label-form' data-toggle='tooltip' data-placement='top' title data-original-title='Edit'><li class='fa fa-edit'></li></span></a>";
    $upload[] = array(
      ++$no,
      $r->kta_tipe_kta,
      $r->nama_pengguna,
      $r->kta_no_id,
      $r->time_scan,
      $r->col3,
      $status,
      $r->col6,
      "<a href='$url'><span class='label label-default label-form' data-toggle='tooltip' data-placement='top' title data-original-title='Edit'><li class='fa fa-edit'></li></span></a>"
    );
//			debugCode($upload);
  }
  $output = array(
    "draw" => $draw,
    "recordsTotal" => count($data),
    "recordsFiltered" => count($data),
    "data" => $upload
  );
  echo json_encode($output, JSON_UNESCAPED_SLASHES);
  exit();
}
}

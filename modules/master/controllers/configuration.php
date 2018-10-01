	<?php
//test
/* database config */
$cfg['db']['hostname'] = "116.90.165.244";
$cfg['db']['username'] = "admin";
$cfg['db']['password'] = "admin123mysql";
$cfg['db']['database'] = "kakridekopin";
$cfg['db']['dbdriver'] = "mysqli";

/* module location HMVC */
$config['folder_modules']	 = 'modules';
$config['modules_locations'] = array(
    getcwd().'/'.$config['folder_modules'].'/' => '../../'.$config['folder_modules'].'/',
);

$config['template_web'] 	= 'red-box';
$config['template_admin'] 	= 'new';
$config['template_admin'] 	= 'atlant';
$config['key_front_pass'] 	= 'p1351IndoNesiaYysywk';

/* myconfig */
$config['app_name'] 	= "KAKRI";
$config['app_version'] 	= "0.0";


$config['color_theme'] = '#019927';


$config['activeLog'] 		= false;
$config['activeChat'] 		= false;


$config['nominal_bayar'] = 200000;

$config['status_anggota'] = array(
		0	=> 'Non-Aktif',
		1	=> 'Aktif'
	);

$config['jenis_id'] = array(
		"KTP"	=> "KTP",
		"SIM"	=> "SIM",
		"AKTA" 	=> "AKTA"
	);

$config['jenis_diskon'] = array(
		"all"     	=> "Keduanya",
		"tiket"		=> "Tiket",
		"souvenir"	=> "Souvenir"
	);

$config['tipe_kta']	= array(
		0 => 'Non-Koperasi',
		1 => 'Koperasi'
	);

$config['status_asuransi']	= array(
		0 => 'Pending',
		1 => 'Active',
		2 => 'Expired'		
	);

$config['omzet']	= array(
		1 => '< 5.000.000',
		2 => '5.000.000 - 10.000.000',
		3 => '> 10.000.000'		
	);

$config['jenis_koperasi'] = array(
        0 => "Non-Koperasi",
        1 => "Simpan Pinjam",
        2 => "Konsumen",
        3 => "Produsen",
        4 => "Jasa",
        5 => "Pemasaran",
        6 => "Serba Usaha"		
);
$config['pekerjaan'] = array(
        1 => "PNS (Pegawai Negeri Sipil)",
        2 => "Pegawai Swasta",
        3 => "Wirausaha",
        4 => "Petani",
        5 => "Nelayan",
        6 => "Ibu Rumah Tangga",
		7 => "Konsultan",
		8 => "Mahasiswa / Pelajar",
		9 => "Lainnya"
);

$config['jenis_bayar']	= array(
		0 => 'Cash',
		1 => 'EDC'
	);

$config['jenkel']	= array(
		0 => 'Pria',
		1 => 'Wanita'
	);
	
$config['bulan'] = array(
	'01'	=> "January",
	'02'	=> "February",
	'03'	=> "Maret",
	'04'	=> "April",
	'05'	=> "Mei",
	'06'	=> "Juni",
	'07'	=> "July",
	'08'	=> "Agustus",
	'09'	=> "September",
	'10'	=> "Oktober",
	'11'	=> "November",
	'12'	=> "Desember"
);

$config['kocok_usia'] = array(
		"13" => "U13",
		"15" => "U15",
		"17" => "U17",
		"19" => "U19",
		"21-50" => "U21 - U50"
	);
$config['tipe_undian'] = array(
		'tipe' => array(
				"id"	=> 'tipe',
				"title"	=> 'Undian Tipe'
			),
		'wilayah' => array(
				"id"	=> 'wilayah',
				"title"	=> 'Undian Wilayah'
			),
		'interval' => array(
				"id"	=> 'interval',
				"title"	=> 'Undian Interval'
			),
		'acara' => array( 
				"id"	=> 'acara',
				"title"	=> 'Undian Acara'
			)
	);

$config['tipe_kategroi_undian'] = array(
		"0"	=> "Umum",
		"1"	=> "Atlet"
	);

$config['interval_kategroi_undian'] = array(
		"0"	=> "Mingguan",
		"1"	=> "Bulanan",
		"3"	=> "Tahunan"
	);


$config['url_api'] = 'http://180.250.71.209:8011/';

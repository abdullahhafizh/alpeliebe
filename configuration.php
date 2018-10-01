<?php
$cfg['db']['hostname'] = "localhost";
$cfg['db']['username'] = "root";
$cfg['db']['password'] = "";
$cfg['db']['database'] = "alpenindo";
$cfg['db']['port'] 	   = "";
$cfg['db']['dbdriver'] = "mysqli";
// $cfg['db']['hostname'] = $_SERVER['MYSQL_HOST'];
// $cfg['db']['username'] = $_SERVER['MYSQL_USER'];
// $cfg['db']['password'] = $_SERVER['MYSQL_PASSWORD'];
// $cfg['db']['port'] 	   = $_SERVER['MYSQL_PORT'];
// $cfg['db']['database'] = $_SERVER['MYSQL_DATABASE'];
// $cfg['db']['dbdriver'] = "mysqli";
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
$config['app_name'] 	= "ALPENINDO - KTA";
$config['app_version'] 	= "1.0.0";
$config['version_code'] = "100";

// // develop
// $config['api_ip'] = "159.89.196.36";
// $config['user'] = "useralpen1";
// $config['pwd'] = "e10adc3949ba59abbe56e057f20f883e";

// production
$config['api_ip'] = "116.90.165.246";
$config['user'] = "1179396001";
$config['pwd'] = "4a42a2374b9baa48a0e2cd38df0a780e";

// $config['color_theme'] = '#019927';
$config['color_theme'] = '#016599';


$config['activeLog'] 		= true;
$config['activeChat'] 		= true;

$config['status_anggota'] = array(
		0	=> 'Non-Aktif',
		1	=> 'Aktif',
		2	=> 'Rejected',
		9	=> 'Review'
	);

$config['jenis_id'] = array(
		"KTP"	=> "KTP",
		"SIM"	=> "SIM",
		"AKTA" 	=> "AKTA"
	);

$config['tingkatan']	= array(
		1 => 'DPP',
		2 => 'DPD PROV.',
		3 => 'DPD KAB/KOTA',
		4 => 'PK KEC',
		5 => 'PL DS/KEL',
		6 => 'Bukan Pengurus'
	);

$config['hasta_karya']	= array(
		'AMPI'	 		=> 'AMPI',
		'HWK'	  		=> 'HWK',
		'MDI'	  		=> 'MDI',
		'AL-HIDAYAH'	=> 'AL-HIDAYAH',
		'SATKAR ULAMA' 	=> 'SATKAR ULAMA'
	);
$config['trikarya']	= array(
		'KOSGORO'		  => 'KOSGORO',
		'MKGR' 	 		  => 'MKGR',
		'SOKSI'	  		  => 'SOKSI',
		'Bukan Trikarya'  => 'Bukan Trikarya'
	);
$config['sayap']	= array(
		'AMPG' 			=> 'AMPG',
		'KPPG'			=> 'KPPG',
		'Bukan Orsa'	=> 'Bukan Orsa'
	);
$config['jabatan']	= array(
		'0' => '',
		1 => 'Ketua',
		2 => 'Wakil Ketua',
		3 => 'Sekretaris',
		4 => 'Wakil Sekretaris',
		5 => 'Bendahara',
		6 => 'Wakil Bendahara',
		7 => 'Anggota Pleno',
		8 => 'Anggota Biasa'
	);

$config['status_nikah']	= array(
		1 => 'Belum Kawin',
		2 => 'Kawin',
		3 => 'Pernah Menikah'
	);

$config['pendidikan'] = array(
        'SD' => "SD",
        'SMP' => "SMP / Sederajat",
        'SMA' => "SMA / Sederajat",
        'D3' => "D3",
        'S1' => "S1",
        'S2' => "S2",
        'S3' => "S3",
        'Lainnya' => "Lainnya"
);
$config['pekerjaan'] = array(
        1 => "Pelajar",
        2 => "Mahasiswa",
        3 => "Profesional",
        4 => "Pegawai Swasta",
        5 => "Wirausaha",
        6 => "Buruh",
		7 => "Pensiunan",
		8 => "Ibu Rumah Tangga",
		9 => "Petani",
		10 => "Nelayan",
		11 => "Lainnya",
);

$config['jenkel']	= array(
		1 => 'Laki-laki',
		2 => 'Perempuan',
);

$config['domisili']	= array(
		'YA' 	=> 'YA',
		'TIDAK' => 'TIDAK'
);

$config['bulan'] = array(
	'01'	=> "01",
	'02'	=> "02",
	'03'	=> "03",
	'04'	=> "04",
	'05'	=> "05",
	'06'	=> "06",
	'07'	=> "07",
	'08'	=> "08",
	'09'	=> "09",
	'10'	=> "10",
	'11'	=> "11",
	'12'	=> "12"
);
$config['browser']	= array(
		'IE'		=> '9',
		'Firefox'	=> '50',
		'Opera'		=> '30',
		'Chrome'	=> '50',
		'Safari'	=> '',
		'Netscape'	=> ''
	);

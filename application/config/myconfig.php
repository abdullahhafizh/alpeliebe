<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("configuration.php");
$config['path_file_source'] = "./assets/collections/source/";

$config['exam_type'] = array(
		"100"	=> "AAS",
		"200"	=> "LBHP",
		"300"	=> "AMSI",
		"400"	=> "APK"	
	);

$config['rep_reg_user'] = array(
		"BANDUNG"	=> array(
				"IO80" 	=> "Telkom Professional Development Center"
				),
		"JAKARTA"	=> array(
				"IO14"	=> "PT. MITRA INTEGRASI INFORMATIKA",
				"IO4"	=> "PT EXECUTRAIN NUSANTARAJAYA",
				"IO11Q"	=> "Institut Akuntan Publik Indonesia"
			),
		"MEDAN"		=> array(
				"IO16" 	=> "WEBMEDIA TRAINING CENTER"
			),
		"SURABAYA"	=> array(
				"IO11" 	=> "EBIZ EDUCATION ENTERPRISE",
				"IO11G" => "Trust Training Partners",
				"IOFA" 	=> "PT INIXINDO WIDYA UTAMA"
				)
	);

$config['batas_min'] = 51;
$config['porsi_nilai'] = array(
		"pg"	=> 65,
		"essay"	=> 35
	);

$config['show_test'] = array(
		"HADIR"	=> "test",
		"TIDAK"	=> "no-show"
	);

$config['date_start'] = 2009;

$config['periode_ujian'] = array(
		1 => array("01","02","03"),
		2 => array("04","05","06"),
		3 => array("07","08","09"),
		4 => array("10","11","12")
	);
 
$config['bobot_nilai_pg'] = array(
		"100" => array(
				1 => 21.67,
				2 => 21.67,
				3 => 21.67
			),
		"200" => array(
				1 => 16.25,
				2 => 16.25,
				3 => 16.25,
				4 => 16.25
			),
		"300" => array(
				1 => 30,
				2 => 23.33,
				3 => 23.33,
				4 => 23.34
			),
		"400" => array(
				1 => 21.67,
				2 => 21.67,
				3 => 21.67
			)
	);

 $config['svy'] = array(
	"1"		=> array("title" => "Apakah materi dalam ujian telah mencerminkan pengujian kompetensi yang dibutuhkan untuk berprofesi sebagi seorang CPA of Indonesia? No.1 sebagi terbaik dan no.5 terburuk.",
					 "id"	 => "svy1",
					 "q"	 => array(1,2,3,4,5)
				),
	"2"		=> array(
			"title"	=> "Bagaimana tingkat kesulitan pertanyaan ujian? No.1 sangat sulit dan no.5 sangat mudah.",
			"id"	=> "svy2",
			"q"	 	=> array(1,2,3,4,5)
		),
	"3"		=> array(
			"title"	=> "Apakah jumlah soal yang diujikan secara keseluruhan memadai? No. 1 terlalu banyak dan no.5 terlalu sedikit.",
			"id"	=> "svy3",
			"q"	 	=> array(1,2,3,4,5)
		),
	"4"		=> array(
			"title" => "Apakah rata-rata waktu pengerjaan soal pilihan ganda memadai? No.1 telalu pendek dan no 5 teralu panjang.",
			"id"	=> "svy4",
			"q"		=> array(1,2,3,4,5)
		),
	"5"		=> array(
			"title"	=> "Apakah rata-rata waktu pengerjaan soal essay memadai? No 1 terlalu pendek dan no 5 terlalu panjang.",
			"id"	=> "svy5",
			"q"	 	=> array(1,2,3,4,5)
		),
	"6"		=>	array(
					"title" => "Bagaimana kualitas fasilitas tempat ujian ?",
					"id"	=> "svy6",
					"sub"   => array(
						"6a" => array(
								"title" => "Bagaimana kualitas fasilitas tempat ujian ? Lokasi Ujian? No 1 sebagai terbaik dan no 5 terburuk",
								"id"	=> "svy6a",
								"q"	 	=> array(1,2,3,4,5)
							),
						"6b" => array(
								"title" => "Temperatur ruangan? No 1 sangat dingin dan no 5 sangat panas",
								"id"	=> "svy6b",
								"q"	 	=> array(1,2,3,4,5)
							),
						"6c" => array(
								"title" => "Monitor Komputer ? No 1 sebagai terbaik dan no 5 terburuk",
								"id"	=> "svy6c",
								"q"	 	=> array(1,2,3,4,5)
							),
						"6d" => array(
								"title" => "Mouse ? No 1 sebagai terbaik dan no 5 terburuk",
								"id"	=> "svy6d",
								"q"	 	=> array(1,2,3,4,5)
							),
						"6e" => array(
								"title" => "Keyboard ? No 1 sebagai terbaik dan no 5 terburuk",
								"id"	=> "svy6e",
								"q"	 	=> array(1,2,3,4,5)
							),
						"6f" => array(
								"title" => "Keramahan petugas ? No 1 sebagai terbaik dan no 5 terburuk",
								"id"	=> "svy6f",
								"q"	 	=> array(1,2,3,4,5)
							),
						"6g" => array(
								"title" => "Fasilitas lainnya ? No 1 sebagai terbaik dan no 5 terburuk",
								"id"	=> "svy6g",
								"q"	 	=> array(1,2,3,4,5)
							)
					)
				),

	"7"		=> array(
				"title" => "Berapa rata-rata waktu belajar anda per mata ujian sebelum duduk ujian",
				"id"	=> "svy7",
				"q"	 	=> array(
							1 => "0 - 80 jam",
							2 => "81 - 160 jam",
							3 => "161 - 240 jam",
							4 => ">241 jam"
						)
			),
	"8"		=> array(
					"title" => "Bagaimana anda mempersiapkan ujian",
					"id"	=> "svy8",
					"sub"	=> array(
						"8a"	=> array(
								"title" => "Belajar Sendiri",
								"id"	=> "svy8a",
								"q"	 	=> array(1,2)
						),
						"8b"	=> array(
								"title" => "Belajar Kelompok",
								"id"	=> "svy8b",
								"q"	 	=> array(1,2)
						),
						"8c.2"	=> array(
								"title"	=> "Exam Review Sebutkan : ",
								"id"	=> "svy8c.2",
								"q"	 	=> array(1,2)
						)
					)),
	"9"		=> array(
				"title" => "Pelayanan sebelum mengukuti ujian",
				"id"	=> "svy9",
				"sub"	=> 	array(
					"9a"	=> array(
								"title" => "Apakah anda diminta untuk menyerahkan kartu identitas?",
								"id"	=> "svy9a",
								"q"	 	=> array(1,2)
								),
					"9b"	=> array(
								"title" => "Apakah anda diminta untuk menyerahkan kartu identitas tambahan?",
								"id"	=> "svy9b",
								"q"	 	=> array(1,2)
								),
					"9c"	=> array(
								"title" => "Apakah anda diminta untuk menyimpan barang bawaan di tempat yang disediakan?",
								"id"	=> "svy9c",
								"q"	 	=> array(1,2)
								),
					"9d"	=> array(
								"title" => "Apakah anda diperbolahkan untuk membawa kalkulator?",
								"id"	=> "svy9d",
								"q"	 	=> array(1,2)
								),
					"9e"	=> array(
								"title" => "Apakah anda diminta untuk menyerahkan voucher?",
								"id"	=> "svy9e",
								"q"	 	=> array(1,2)
								),
					"9f"	=> array(
								"title" => "Apakah petugas tes center membantu anda dalam memasukkan nomor ujian?",
								"id"	=> "svy9f",
								"q"	 	=> array(1,2)
				)			
			)
	),
	"10"	=> array(
				"title" => "Adakah soal yang ingin anda pertanyakan? Anda dapat meninjau kembali soal yang anda pertanyakan dan mengisi ruang di bawah ini tetapi tidak dapat merubah jawaban anda.",
				"id"	=> "svy10"
			),
	"11"	=> array(
				"title" => "Apa saran anda bagi perbaikan penyelenggaraan CPA of Indonesia Exam, baik penyelenggaraan, kurikulum, silabus, soal yang diujikan, hingga metodologi sertifikasi.",
				"id"	=> "svy11"
			)
);
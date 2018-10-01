<?php
class FrontController extends My_Controller{ 
	var $meta_keyword 		= "";
	var $meta_title 		= "Home";
	var $meta_desc 			= "";
	
	function __construct(){  
		parent::__construct(); 		  
		$this->jCfg['theme'] = 'web/'.cfg('template_web');		
	}
	
	function _v($file,$data=array(),$single=true){
		$data["meta_desc"]		= $this->meta_desc;
		$data["meta_title"]		= $this->meta_title;
		$data["meta_keyword"] 	= $this->meta_keyword;
		
		if(!$single)
			$this->load->view($this->jCfg['theme'].'/header',$data);
		
		$this->load->view($this->jCfg['theme'].'/'.$file,$data);
		
		if(!$single)
			$this->load->view($this->jCfg['theme'].'/footer',$data);
	}
	
}
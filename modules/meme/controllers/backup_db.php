<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Backup_db extends AdminController {  
	var $path_backup = "./backup/db/";
	var $absolute_path_backup = "D:\\web\backup\db";
	function __construct()    
	{
		parent::__construct();    
		$this->_set_action();
		$this->_set_action(array("delete"),"ITEM");
		$this->_set_title( 'Backup Database' );
		$this->folder_view = "meme/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Backup Database",
				"url"		=> $this->own_link
			);
 		$this->load->helper('file');

	}

	function index(){
		$this->breadcrumb[] = array(
				"title"		=> "List"
			);
		$file = get_dir_file_info($this->path_backup);
		$data['data'] = $file;			
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	

	function delete($id=''){
		$id=dbClean(trim($id));		
		if(trim($id) != ''){
			if(file_exists($this->path_backup.$id) && !is_dir($this->path_backup.$id)){
				@unlink($this->path_backup.$id);
			}
		}
		redirect($this->own_link."?msg=".urldecode('Delete backup data succes')."&type_msg=success");
	}

	function restore($file_name=""){

		$id=dbClean(trim($file_name));		
		if(trim($id) != ''){
			if(file_exists($this->path_backup.$id) && !is_dir($this->path_backup.$id)){
				$sql = "RESTORE FILELISTONLY 
   				FROM DISK = '".$this->absolute_path_backup."\\".$id."'";
   				/*RESTORE FILELISTONLY
				FROM DISK ='D:\Backups\AdventureWorks.BAK' 

				RESTORE DATABASE AdventureWorks
				FROM DISK ='D:\Backups\AdventureWorks.BAK'
				WITH 
				MOVE 'AdventureWorks_Data' TO 'D:\MSSQL\DATA\AdventureWorks_Data.MDF',
				MOVE 'AdventureWorks_Log' TO 'D:\MSSQL\DATA\AdventureWorks_Log.LDF',
				NORECOVERY 

				RESTORE LOG AdventureWorks
				FROM DISK ='D:\Backups\AdventureWorks.TRN'
				WITH RECOVERY*/
   				$m = $this->db->query($sql);
			}

			redirect($this->own_link."?msg=".urldecode('Restore Database succes')."&type_msg=success");
		}else{
			redirect($this->own_link."?msg=".urldecode('Invalid file name.')."&type_msg=error");
		}
	}

	function backup(){
		$query = "
			BACKUP DATABASE champions 
			TO DISK = N'".$this->absolute_path_backup."\champions_".date("Y-m-d-H-i-s").".bak' 
			WITH NOFORMAT, NOINIT, NAME = N'Champions_".date("Y-m-d-H-i-s")."Database Backup Test', 
			SKIP, NOREWIND, NOUNLOAD";
		$this->db->query($query);
		redirect($this->own_link."?msg=".urldecode('Backup Database succes')."&type_msg=success");
	}
	

}

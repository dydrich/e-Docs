<?php

require_once 'data_source.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class UploadManager {
	
	private $pathTo;
	private $data;
	private $file;
	private $datasource;
	
	const FILE_EXISTS = 1;
	const UPL_ERROR = 2;
	const UPL_OK = 3;
	
	public function __construct($pt, $file, $db){
		$this->pathTo = $pt;
		$this->file = $file;
		$this->datasource = new MySQLDataLoader($db);
	}
	
	public function setData($d){
		$this->data = $d;
	}

	private function createFileName() {
		$Y = date("Y");
		$m = str_pad(date("m"), 2, "0", STR_PAD_LEFT);
		$d = str_pad(date("d"), 2, "0", STR_PAD_LEFT);
		$fn = $Y.$m.$d;
		$id = $this->datasource->executeCount("SELECT (IFNULL(MAX(doc_id),0) + 1 ) AS id FROM rb_documents");
		$fn .= str_pad($id, 16, "0", STR_PAD_LEFT);
		$ext = pathinfo($_SESSION['__config__']['document_root']."/".basename($this->file['name']), PATHINFO_EXTENSION);
		$fn .= ".".$ext;
		return $fn;
	}
	
	public function moveFile(){
		/**
		 * gestione del filesystem
		 */
		$file = basename($this->file['name']);
		$fileName = $this->createFileName();

		/**
		 * gestione file nel filesystem
		*/
		$dir = $_SESSION['__config__']['document_root']."/";
		/*
		if(!file_exists($dir)){
			echo $dir. 'non esiste???';
			if (!mkdir($dir, 0775, true)) {
				return self::UPL_ERROR;
			}
		}
		*/
		
		$target_path = $dir . $fileName;

		if(file_exists($target_path)){
			echo "file exists";
		}
		else{
			if(move_uploaded_file($this->file['tmp_name'], $target_path)) {
				chdir($dir);
				chmod($fileName, 0644);
			}
			else {
				echo "<br>moving error to $target_path";
			}
		}
		return $fileName;
	}
	
	public function upload(){
		return $this->uploadDocument();
	}
	
	private function uploadDocument(){
		$ret = $this->moveFile();
		return $ret;
	}
}

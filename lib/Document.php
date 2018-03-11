<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 17.47
 */

namespace edocs;

require_once "RBUtilities.php";
require_once "MimeType.php";


class Document
{
	/**
	 * document ID
	 * rb_documents.id
	 */
	protected $id;
	protected $uploadDate;
	protected $file;
	protected $documentName;
	protected $documentType;
	protected $abstract;
	protected $school;
	protected $schoolGrade;
	protected $subject;
	protected $owner;
	protected $lastUpdate;
	protected $title;
	protected $uri;
	protected $filePath = null;
	protected $tags = [];
	protected $category;

	protected $datasource;

	public static $INSERT_DOCUMENT = 1;
	public static $UPDATE_DOCUMENT = 2;
	public static $DELETE_DOCUMENT = 3;
	public static $QUICK_DELETE    = 4;

	/**
	 *
	 * upload const
	 */
	const FILE_EXISTS = 1;
	const UPL_ERROR = 2;
	const UPL_OK = 3;

	public function __construct($id, $data, $category, \MySQLDataLoader $dl){
		$this->id = $id;
		$this->datasource = $dl;
		$this->category = $category;
		$this->file = null;
		$this->filePath = "/library/";
		if ($data != null){
			$this->uploadDate = $data['data_upload'];
			$this->file = $data['file'];
			$this->abstract = $data['abstract'];
			$this->documentName = $data['document_name'];
			$this->documentType = $data['doc_type'];
			$this->school = $data['school'];
			$this->schoolGrade = $data['school_grade'];
			$this->subject = $data['subject'];
			$rb = \RBUtilities::getInstance($dl);
			$this->owner = $rb->loadUserFromUid($data['owner']);
			$this->lastUpdate = $data['last_update'];
			$this->title = $data['title'];
			$this->uri = $data['uri'];

			if (isset($data['tags']) && $data['tags'] != ""){
				$tags = explode(",", $data['tags']);
				$right_tags = array();
				foreach ($tags as $t){
					if ($t != ""){
						$right_tags[] = $t;
					}
				}
				if (count($right_tags) > 0){
					$this->tags = $right_tags;
				}
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getUploadDate() {
		return $this->uploadDate;
	}

	/**
	 * @param mixed $uploadDate
	 */
	public function setUploadDate($uploadDate) {
		$this->uploadDate = $uploadDate;
	}

	/**
	 * @return mixed
	 */
	public function getDocumentName() {
		return $this->documentName;
	}

	/**
	 * @param mixed $documentName
	 */
	public function setDocumentName($documentName) {
		$this->documentName = $documentName;
	}

	/**
	 * @return mixed
	 */
	public function getSchool() {
		return $this->school;
	}

	/**
	 * @param mixed $school
	 */
	public function setSchool($school) {
		$this->school = $school;
	}

	/**
	 * @return mixed
	 */
	public function getSchoolGrade() {
		return $this->schoolGrade;
	}

	/**
	 * @param mixed $schoolGrade
	 */
	public function setSchoolGrade($schoolGrade) {
		$this->schoolGrade = $schoolGrade;
	}

	/**
	 * @return mixed
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param mixed $subject
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * @return mixed
	 */
	public function getUri() {
		return $this->uri;
	}

	/**
	 * @param mixed $uri
	 */
	public function setUri($uri) {
		$this->uri = $uri;
	}

	/**
	 * @return mixed
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * @param mixed $category
	 */
	public function setCategory($category) {
		$this->category = $category;
	}

	/**
	 * @return \MySQLDataLoader
	 */
	public function getDatasource() {
		return $this->datasource;
	}

	/**
	 * @param \MySQLDataLoader $datasource
	 */
	public function setDatasource($datasource) {
		$this->datasource = $datasource;
	}

	public function getID(){
		return $this->id;
	}

	public function getDataUpload(){
		return $this->uploadDate;
	}

	public function getFile(){
		return $this->file;
	}

	public function setFile($f){
		$this->file = $f;
	}

	public function getTags(){
		return $this->tags;
	}

	public function setTags($tags){
		$this->tags = $tags;
	}

	public function getDocumentType(){
		return $this->documentType;
	}

	public function setDocumentType($t){
		$this->documentType = $t;
	}

	public function getAbstract(){
		return $this->abstract;
	}

	public function setAbstract($ab){
		$this->abstract = $ab;
	}

	public function getOwner(){
		return $this->owner;
	}

	public function setOwner(User $o){
		$this->owner = $o;
	}

	public function getLastUpdate(){
		return $this->lastUpdate;
	}

	public function setLastUpdate($lu){
		$this->lastUpdate = $lu;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($t){
		$this->title = $t;
	}

	public function getFilePath(){
		return $this->filePath;
	}

	public function setFilePath($fp){
		$this->filePath = $fp;
	}

	protected function insertTags(){
		$this->datasource->executeUpdate("DELETE FROM rb_doc_tag WHERE doc_id = {$this->id}");
		foreach ($this->tags as $tag){
			$sel_tag = "SELECT tid FROM rb_tags WHERE name = '{$tag}'";
			$tid = $this->datasource->executeCount($sel_tag);
			if ($tid == null){
				// insert new tag
				$tid = $this->datasource->executeUpdate("INSERT INTO rb_tags (name) VALUES ('{$tag}')");
			}
			$this->datasource->executeUpdate("INSERT INTO rb_doc_tag (tid, doc_id) VALUES ({$tid}, {$this->id})");
		}
	}

	public function downloadFile(){
		$mime = \MimeType::getMimeContentType($this->file);
		$fp = $_SESSION['__config__']['document_root']."/".$this->file;
		header("Content-Type: ".$mime['ctype']);
		header("Content-Disposition: attachment; filename=".$this->file);
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		readfile($fp);
		//exit;
	}

	protected function deleteFile(){
		if (file_exists("../../".$this->getFilePath().$this->file)){
			unlink("../../".$this->getFilePath().$this->file);
		}
	}

	public function registerDownload(){
		$id_type = $this->getDocumentType();
		$id = $this->getID();
		$ip = $_SERVER['REMOTE_ADDR'];
		if ($_SESSION['__user__']){
			$user = $_SESSION['__user__']->getUId();
		}
		else {
			$user = 0;
		}
		$ins = "INSERT INTO rb_downloads (document_id, document_type, ip_address, dw_date, user) VALUES ({$id}, {$id_type}, '{$ip}', NOW(), {$user})";
		$this->datasource->executeUpdate($ins);

		$upd = "UPDATE rb_documents SET download_counter = (rb_documents.download_counter + 1) WHERE doc_id = $id";
		$this->datasource->executeUpdate($upd);
	}

	public function insert(){
		$sql = "INSERT INTO rb_documents (upload_date, file, document_name, document_type, category, abstract, school, school_grade, owner, last_modified_time, title, subject, link) 
				VALUES (
				NOW(), 
				'{$this->file}', 
				'{$this->documentName}',
				{$this->documentType}, 
				{$this->category}, 
				'{$this->abstract}', 
				".field_null($this->school, false).",
				".field_null($this->schoolGrade, false).",
				{$_SESSION['__user__']->getUid()},
				NOW(),
				'{$this->title}', 
				".field_null($this->subject, false).",
				".field_null($this->uri, true).")";
		$this->id = $this->datasource->executeUpdate($sql);
		$this->insertTags();
	}

	public function update(){
		$this->datasource->executeUpdate("UPDATE rb_documents SET file = '{$this->file}', title = '{$this->title}', abstract = '{$this->abstract}' WHERE doc_id = {$this->id}");
		$this->insertTags();
	}

	public function delete(){
		$this->deleteFile();
		$this->datasource->executeUpdate("DELETE FROM rb_doc_tag WHERE doc_id = {$this->id}");
		$this->datasource->executeUpdate("DELETE FROM rb_downloads WHERE document_id = {$this->id}");
		$this->datasource->executeUpdate("DELETE FROM rb_documents WHERE doc_id = {$this->id}");
	}

	public function download($register = false){
		if ($this->file == null) {
			$this->file = $this->datasource->executeCount("SELECT file FROM rb_documents WHERE doc_id = ".$this->id);
		}
		if (file_exists($_SESSION['__config__']['document_root']."/".$this->file)){
			if ($register) {
				$this->registerDownload();
			}
			$this->downloadFile();
		}
		else {
			$_SESSION['no_file']['file'] =  $_SESSION['__config__']['document_root']."/".$this->file;
			header("Location: no_file.php");
		}
	}
}
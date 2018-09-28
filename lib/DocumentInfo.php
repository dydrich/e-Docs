<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 14/08/18
 * Time: 17.03
 */

namespace edocs;

require_once "MimeType.php";

class DocumentInfo
{
	private static $instance;
	private $datascource;
	private $document;
	private $data;
	/**
	 * DocumentInfo constructor.
	 */
	private function __construct($doc_id, \MySQLDataLoader $ds) {
		$this->datascource = $ds;
		$this->document = $doc_id;
		$this->loadData();
	}

	public static function getInstance($document_id, \MySQLDataLoader $ds) {
		if(empty(self::$instance)){
			self::$instance = new DocumentInfo($document_id, $ds);
		}
		return self::$instance;
	}

	private function loadData() {
		$sel_f = "SELECT rb_documents.*, CONCAT_WS(' ', firstname, lastname) as author, rb_categories.name AS cat, rb_subjects.name AS sub 
		  		  FROM rb_documents, rb_users, rb_categories, rb_subjects 
		  		  WHERE doc_id = ".$this->document." AND owner = uid AND category = cid AND subject = sid";
		$this->data['row'] = $this->datascource->executeQuery($sel_f);
		$this->data['ext'] = pathinfo($_SESSION['__config__']['document_root']."/".$this->data['row']['file'], PATHINFO_EXTENSION);
		$this->data['fs'] = filesize($_SESSION['__config__']['document_root']."/".$this->data['row']['file']);
		$this->data['mime'] = \MimeType::getMimeContentType($_SESSION['__config__']['document_root']."/".$this->data['row']['file']);
		$this->data['avg'] = $this->datascource->executeCount("SELECT COALESCE(ROUND(AVG(grade), 2), 0) AS avg FROM rb_doc_grades WHERE did = $this->document");
		$this->data['grades_count'] = $this->datascource->executeCount("SELECT COUNT(grade) AS grades_count FROM rb_doc_grades WHERE did = $this->document");
		$this->data['last_month_avg'] = $this->datascource->executeCount("SELECT COALESCE(ROUND(AVG(grade), 2), 0) AS last_avg FROM rb_doc_grades WHERE did = $this->document AND grade_time > DATE_SUB(NOW(), INTERVAL + 1 MONTH)");
		$this->data['last_month_grades_count'] = $this->datascource->executeCount("SELECT COUNT(grade) AS last_grades_count FROM rb_doc_grades WHERE did = $this->document AND grade_time > DATE_SUB(NOW(), INTERVAL + 1 MONTH)");
		$this->data['last_month_dwn'] = $this->datascource->executeCount("SELECT COUNT(dw_id) AS last_dw FROM rb_downloads WHERE document_id = $this->document AND dw_date > DATE_SUB(NOW(), INTERVAL + 1 MONTH)");
	}

	public function getData() {
		return $this->data;
	}

	public function getHTMLInfos() {
		$cls = ['', 'classe prima', 'classe seconda', 'classe terza', 'classe quarta', 'classe quinta', 'classe prima', 'classe seconda', 'classe terza'];
		$school = 'Tutti';
		$data = $this->data;
		$row = $data['row'];
		if ($row['school'] != '') {
			$school = strtolower($this->datascource->executeCount('SELECT name FROM rb_schools WHERE sid = '.$row['school']));
			if ($row['school_grade'] != '') {
				$school .= ", ".$cls[$row['school_grade']];
			}
		}
		$html = '<div class="info_back_card mdc-elevation--z5">
				<div style="flex: 3; display: flex; align-items: center; " class="bottom_decoration">
					<i class="material-icons accent_color" style="margin-right: 20px; font-size: 4rem">';
		if($row['document_type'] == 1){
			$html .= $data['mime']['icon'];
		}
		else {
			$html .= "public";
		}
		$html .= "</i>
                    <span style=\"font-size: 2rem\">".$row["title"]."</span>
				</div>
				<div style=\"display: block; color: rgba(0, 0, 0, .55); margin-top: 5px\">".$row['abstract']."</div>
                <div style=\"margin-top: 25px\">
                	<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>description</i>
                	Tipo di file: ";
		if($row['document_type'] == 1){
			$html .= $data['mime']['tipo'];
		}
		else {
			$html .= "link esterno";
		}
		$html .= "</div>
					<div>
						<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>info</i>
						Nome: ";
		if($row['document_type'] == 1){
			$html .= $row['document_name'];
		}
		else {
			$html .= "ND";
		}
		$html .= "</div>
					<div>
						<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>poll</i>
						Dimensioni: ";
		if($row['document_type'] == 1){
			$html .= human_filesize($data['fs'], 0);
		}
		else {
			$html .= "ND";
		}
		$html .= "</div>
					<div style=\"margin-top: 25px\">
						<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>cloud_upload</i>
						Online dal ".format_date(substr($row['upload_date'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/")." ".substr($row['last_modified_time'], 10, 6)."</div>
					<div>
						<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>edit</i>
						Ultima modifica: ".format_date(substr($row['last_modified_time'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/")." ".substr($row['last_modified_time'], 10, 6)."</div>
					<div>
						<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>person</i>
						Caricato da: ". $row['author'] ."</div>
					<div style=\"margin-top: 25px\">
						<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>personal_video</i>
						Tipo di risorsa: ". $row['cat']."</div>
					<div>
						<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>local_library</i>
						Disciplina: ". $row['sub'] ."</div>
					<div>
						<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>school</i>
						Livello scolare: ". $school ."</div>
					</div>";
		return $html;

	}

	public function getHTMLStats() {
		$data = $this->data;
		$row = $data['row'];
		$html = "<div class=\"info_back_card mdc-elevation--z5\">
				<div style=\"flex: 3; display: flex; align-items: center; \" class=\"bottom_decoration\">
					<i class=\"material-icons accent_color\" style=\"margin-right: 20px; font-size: 4rem\">";
		if($row['document_type'] == 1){
			$html .= $data['mime']['icon'];
		}
		else {
			$html .= "public";
		}
		$html .= "</i>
					<span style=\"font-size: 2rem\">". $row['title'] ."</span>
				</div>
				<div style=\"display: block; color: rgba(0, 0, 0, .55); margin-top: 5px\">". $row['abstract'] ."</div>
				<div style=\"margin-top: 15px\">
					<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>cloud_upload</i>
					Online dal ".format_date(substr($row['upload_date'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, '/')." ".substr($row['last_modified_time'], 10, 6) ."</div>
				<div style=\"margin-top: 25px\" class=\"accent_decoration _bold\">Dati complessivi</div>
				<div style=\"\">
					<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>cloud_download</i>
					Download: ".$row['download_counter'] ."</div>
				<div style=\"\">
					<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>star</i>
					Media voto: ";
		if($data['avg'] > 0){
			$html .= $data['avg']." (".$data['grades_count']." voti)";
		}
		else {
			$html .= "ND";
		}
		$html .= "</div>
				<div style=\"margin-top: 25px\" class=\"accent_decoration _bold\" style='font-size: 1.1em'>Dati ultimo mese</div>
				<div style=\"\">
					<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>assignment_returned</i>
					Download: ". $data['last_month_dwn'] ."</div>
				<div style=\"\">
					<i class='material-icons normal' style='margin-right: 20px; position: relative; top: 7px'>star_half</i>
					Media voto: ";
		if($data['last_month_avg'] > 0){
			$html .= $data['last_month_avg']." (".$data['last_month_grades_count']." voti)";
		}
		else {
			$html .= 'ND';
		}
		$html .= "</div>
			</div>";
		return $html;
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 27/07/14
 * Time: 15.48
 */

namespace edocs;


class Subject {

	private $id;
	private $description;
	private $datasource;
	private $parent;

	public function __construct($id, $des, $parent, \MySQLDataLoader $dl) {
		$this->id = $id;
		$this->description = $des;
		$this->datasource = $dl;
		$this->parent = $parent;
		if ($this->parent == 0) {
			$this->parent = null;
		}
	}

	/**
	 * @return null
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param null $parent
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/*
	 * insert a new subject
	 */
	public function insert() {
		$sql = "INSERT INTO rb_subjects (name, parent) VALUES ('{$this->description}', ".field_null($this->parent, false).")";
		$this->id = $this->datasource->executeUpdate($sql);
	}

	/* update values */
	public function update() {
		$sql = "UPDATE rb_subjects SET name = '{$this->description}', parent = ".field_null($this->parent, false)." WHERE sid = ".$this->id;
		$this->datasource->executeUpdate($sql);
	}

	/* delete instance */
	public function delete() {
		$sql = "DELETE FROM rb_subjects WHERE sid = ".$this->id;
		if ($this->checkIfUsed()) {
			$this->datasource->executeUpdate($sql);
		}
		else {
			throw new CustomException('Impossibile eliminare la disciplina in quanto utilizzata in archivio');
		}
	}

	/* check if some documents use the subject */
	protected function checkIfUsed() {
		// TODO: implement function
		return true;
	}

} 

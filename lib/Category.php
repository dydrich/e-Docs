<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 24/10/17
 * Time: 7.21
 */

namespace edocs;


class Category {
	private $id;
	private $name;
	private $code;
	private $description;
	private $datasource;
	private $parent;

	public function __construct($id, $nm, $cd, $des, $parent, \MySQLDataLoader $dl) {
		$this->id = $id;
		$this->name = $nm;
		$this->code = $cd;
		$this->description = $des;
		$this->datasource = $dl;
		$this->parent = $parent;
		if ($this->parent == 0) {
			$this->parent = null;
		}
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @param mixed $code
	 */
	public function setCode($code) {
		$this->code = $code;
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
	 * insert a new category
	 */
	public function insert() {
		$sql = "INSERT INTO rb_categories (name, description, code, parent) VALUES ('{$this->name}', '{$this->description}', '{$this->code}', ".field_null($this->parent, false).")";
		$this->id = $this->datasource->executeUpdate($sql);
	}

	/* update */
	public function update() {
		$sql = "UPDATE rb_categories SET name = '{$this->name}', description = '{$this->description}', code = '{$this->code}', parent = ".field_null($this->parent, false)." WHERE cid = ".$this->id;
		$this->datasource->executeUpdate($sql);
	}

	/* delete instance */
	public function delete() {
		$sql = "DELETE FROM rb_categories WHERE cid = ".$this->id;
		if ($this->checkIfUsed()) {
			$this->datasource->executeUpdate($sql);
		}
		else {
			throw new CustomException('Impossibile eliminare la categoria in quanto utilizzata in archivio');
		}
	}

	/* check if some documents use the category */
	protected function checkIfUsed() {
		// TODO: implement function
		return true;
	}


}
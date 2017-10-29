<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 10.14
 */

namespace edocs;


class Tag
{
	private $id;
	private $name;
	private $description;
	private $datasource;

	/**
	 * Tag constructor.
	 * @param $id
	 * @param $name
	 * @param $description
	 * @param $datasource
	 */
	public function __construct($id, $name, $description, \MySQLDataLoader $datasource) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->datasource = $datasource;
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
	public function getDescription() {
		return $this->description;
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
	public function getId() {
		return $this->id;
	}

	/**
	 * @return \MySQLDataLoader
	 */
	public function getDatasource() {
		return $this->datasource;
	}

	/*
	 * insert a new tag
	 */
	public function insert() {
		$sql = "INSERT INTO rb_tags (name, description) VALUES ('{$this->name}', '{$this->description}')";
		$this->id = $this->datasource->executeUpdate($sql);
	}

	/* update */
	public function update() {
		$sql = "UPDATE rb_tags SET name = '{$this->name}', description = '{$this->description}' WHERE tid = ".$this->id;
		$this->datasource->executeUpdate($sql);
	}

	/* delete instance */
	public function delete() {
		$sql = "DELETE FROM rb_tags WHERE tid = ".$this->id;
		$this->datasource->executeUpdate($sql);
	}

}
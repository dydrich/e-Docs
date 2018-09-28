<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/09/18
 * Time: 8.09
 */

namespace edocs;

require_once "RBUtilities.php";

class Channel
{
	private $id;
	private $name;
	private $description;
	private $system;
	private $school = null;
	private $grade = null;
	private $subject = null;
	private $owner;
	private $datasource;
	private $personalParameters;
	private $parents;
	private $subchannels;
	private $level;

	/**
	 * Channel constructor.
	 * @param $id
	 * @param $name
	 * @param $description
	 * @param $system
	 * @param $school
	 * @param $grade
	 * @param $subject
	 * @param $owner
	 * @param $datasource
	 * @param $personalParameters
	 */
	public function __construct($id, $name, $description, $system, $school, $grade, $subject, User $owner, \MySQLDataLoader $datasource, $personalParameters) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->system = $system;
		if ($subject == 0) {
			$subject = null;
		}
		if ($school == 0) {
			$school = null;
		}
		if ($grade == 0) {
			$grade = null;
		}
		$this->school = $school;
		$this->grade = $grade;
		$this->subject = $subject;
		$this->owner = $owner;
		$this->datasource = $datasource;
		$this->personalParameters = $personalParameters;
		$this->parents = [];
		$this->subchannels = [];
		$this->loadParentChannels();
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 * @return Channel
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return Channel
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 * @return Channel
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSystem() {
		return $this->system;
	}

	/**
	 * @param mixed $system
	 * @return Channel
	 */
	public function setSystem($system) {
		$this->system = $system;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSchool() {
		return $this->school;
	}

	/**
	 * @param mixed $school
	 * @return Channel
	 */
	public function setSchool($school) {
		$this->school = $school;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getGrade() {
		return $this->grade;
	}

	/**
	 * @param mixed $grade
	 * @return Channel
	 */
	public function setGrade($grade) {
		$this->grade = $grade;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param mixed $subject
	 * @return Channel
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOwner() {
		return $this->owner;
	}

	/**
	 * @param mixed $owner
	 * @return Channel
	 */
	public function setOwner($owner) {
		$this->owner = $owner;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPersonalParameters() {
		return $this->personalParameters;
	}

	/**
	 * @param mixed $personalParameters
	 * @return Channel
	 */
	public function setPersonalParameters($personalParameters) {
		$this->personalParameters = $personalParameters;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getParents() {
		return $this->parents;
	}

	/**
	 * @param mixed $parents
	 */
	public function setParents($parents) {
		$this->parents = $parents;
		$this->updateParentChannels();
	}

	/**
	 * @return mixed
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * @param mixed $level
	 */
	public function setLevel($level) {
		$this->level = $level;
	}

	/**
	 * @return array
	 */
	public function getSubchannels() {
		return $this->subchannels;
	}

	/**
	 * @param array $subchannels
	 */
	public function setSubchannels($subchannels) {
		$this->subchannels = $subchannels;
	}

	private function loadParentChannels() {
		$parents = $this->datasource->executeQuery("SELECT parent_id FROM rb_channels_relations WHERE channel_id = ".$this->id);
		if ($parents && count($parents) > 0) {
			$this->parents = $parents;
		}
	}

	private function loadSubChannels() {
		$subs = $this->datasource->executeQuery("SELECT channel_id FROM rb_channels_relations WHERE parent_id = ".$this->id);
		if ($subs && count($subs) > 0) {
			foreach ($subs as $sub) {
				$this->subchannels[] = $sub;
			}
		}
	}

	/* update parent_channels */
	private function updateParentChannels() {
		$this->datasource->executeUpdate("DELETE FROM rb_channels_relations WHERE channel_id = ".$this->id);
		if ($this->parents != null) {
			if (count($this->parents) > 0) {
				foreach ($this->parents as $ch) {
					$this->datasource->executeUpdate("INSERT INTO rb_channels_relations (channel_id, parent_id) VALUES ({$this->id}, $ch)");
				}
				$this->datasource->executeUpdate("UPDATE rb_channels SET level = 2 WHERE idc = ".$this->id);
			}
		}
	}

	/*
		 * insert a new subject
		 */
	public function insert() {
		$sql = "INSERT INTO rb_channels (name, description, system, subject, school, grade, owner) 
				VALUES ('{$this->name}', 
				'{$this->description}', 
				$this->system, 
				".field_null($this->subject, false).", 
				".field_null($this->school, false).", 
				".field_null($this->grade, false).",
				{$this->owner->getUid()})";
		$this->id = $this->datasource->executeUpdate($sql);
	}

	/* update values */
	public function update() {
		$sql = "UPDATE rb_channels 
				SET name = '{$this->name}', 
				description = '{$this->description}',
				subject = ".field_null($this->subject, false).",  
				school = ".field_null($this->school, false).",
				grade = ".field_null($this->grade, false)."
				WHERE idc = ".$this->id;
		$this->datasource->executeUpdate($sql);
	}

	/* delete instance */
	public function delete() {
		$sql = "DELETE FROM rb_channels WHERE idc = ".$this->id;
		$this->datasource->executeUpdate($sql);
		$this->datasource->executeUpdate("DELETE FROM rb_channels_relations WHERE channel_id = ".$this->id);
	}

	public function reloadData() {
		$data = $this->datasource->executeQuery('SELECT * FROM rb_channels WHERE idc = '.$this->id);
		$this->name = $data['name'];
		$this->description = $data['description'];
		$this->system = $data['system'];
		if ($data['subject'] == 0) {
			$data['subject'] = null;
		}
		if ($data['school'] == 0) {
			$data['school'] = null;
		}
		if ($data['grade'] == 0) {
			$data['grade'] = null;
		}
		$this->school = $data['school'];
		$this->grade = $data['grade'];
		$this->subject = $data['subject'];
		$rb = \RBUtilities::getInstance($this->datasource);
		$this->owner = $rb->loadUserFromUid($data['owner']);
		//$this->personalParameters = $data['personalParameters'];
		$this->parents = [];
		$this->level = $data['level'];
		$this->loadParentChannels();
		$this->loadSubChannels();
	}

	public function isFirstLevelChannel() {
		return $this->level < 2;
	}

	public function isSubjectChannel() {
		return $this->subject != null;
	}

	public function isSchoolChannel() {
		return $this->school != null;
	}
}
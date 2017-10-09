<?php

class User {
	/**
	 * from table: utenti
	 */
	protected $uid;
	protected $firstName;
	protected $lastName;
	protected $username;
	protected $groups = array();
	protected $role;
	protected $sex;
	protected $pwd;
	protected $accesses;

    /**
     * token for authentication from mobile devices
     * @var $token string
     */
    protected $token;

    public static $ADMIN = 3;
    public static $USER = 1;
    public static $GUEST = 2;

	public function __construct($u, $fn, $ln, $un, $rl){
		$this->uid = $u;
		$this->firstName = $fn;
		$this->lastName = $ln;
		$this->username = $un;
		$this->role = $rl;
	}
	
	public function getGroups(){
		return $this->groups;
	}

	public function setFirstName($fn){
		$this->firstName = $fn;
	}

	public function getFirstName(){
		return $this->firstName;
	}

	public function setLastName($ln){
		$this->lastName = $ln;
	}

	public function getLastName(){
		return $this->lastName;
	}

	/**
	 * @param mixed $accesses
	 */
	public function setAccesses($accesses) {
		$this->accesses = $accesses;
	}

	/**
	 * @return mixed
	 */
	public function getAccesses() {
		return $this->accesses;
	}
	
	/**
	 * 
	 * @param number $order: the order of printing
	 * @param number $full: unused (@see ParentBean::getFullName)
	 * @return string
	 */
	public function getFullName($order = 1, $full = 0){
		($order == 1) ? ($ret = $this->firstName." ".$this->lastName) : ($ret = $this->lastName." ".$this->firstName);
		return $ret;
	}

	/**
	 * print name's initials
	 * @param number $order: the order of printing
	 * @param number $dot: print a dot after every initial
	 * @return string
	 */
	public function getInitials($order = 1, $dot = 0) {
		$fn_init = $ln_init = "";
		$fname = explode(" ", $this->firstName);
		foreach ($fname as $item) {
			$fn_init .= substr($item, 0, 1);
			if ($dot) {
				$fn_init .= ".";
			}
		}
		$lname = explode(" ", $this->lastName);
		foreach ($lname as $item) {
			$ln_init .= substr($item, 0, 1);
			if ($dot) {
				$ln_init .= ".";
			}
		}
		if ($dot) {
			($order == 1) ? ($ret = $fn_init." ".$ln_init) : ($ret = $ln_init." ".$fn_init);
		}
		else {
			($order == 1) ? ($ret = $fn_init.$ln_init) : ($ret = $ln_init.$fn_init);
		}
		return $ret;
	}

	public function getRole(){
		return $this->role;
	}

	public function getUid(){
		return $this->uid;
	}

	public function getUsername(){
		return $this->username;
	}

	public function isInGroup($groupId){
		return in_array($groupId, $this->groups);
	}

	public function getSex(){
		return $this->sex;
	}
	
	public function setSex($s){
		$this->sex = $s;
	}
	
	public function setPwd($p){
		$this->pwd = $p;
	}
	
	public function getPwd(){
		return $this->pwd;
	}

	public function getGroupsString(){
		return join(",", $this->groups);
	}

	public function check_perms($permissions){
		return $this->perms&$permissions;
	}

	public function isAdministrator(){
		return $this->check_perms(1);
	}

	/**
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * return an array of data in json string format
     * @return array
     */
    public function toJSON() {
        $json_array = [];
        $json_array['uid'] = $this->uid;
        $json_array['fname'] = $this->firstName;
        $json_array['lname'] = $this->lastName;
        $json_array['username'] = $this->username;
        $json_array['token'] = $this->token;
        return $json_array;
    }
}
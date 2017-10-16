<?php

require_once "AccountManager.php";

class User {
	protected $uid;
	protected $firstName;
	protected $lastName;
	protected $username;
	protected $role;
	protected $pwd;
	protected $accesses;
	protected $datasource;

    /**
     * token for authentication from mobile devices
     * @var $token string
     */
    protected $token;

    public static $ADMIN = 3;
    public static $USER = 1;
    public static $GUEST = 2;

	public function __construct($u, $fn, $ln, $un, $pwd = null, $rl, $dl){
		$this->uid = $u;
		$this->firstName = $fn;
		$this->lastName = $ln;
		$this->username = $un;
		$this->role = $rl;
		if ($dl instanceof MySQLDataLoader) {
			$this->datasource = $dl;
		}
		else {
			$this->datasource = new MySQLDataLoader($dl);
		}
		if ($pwd == null) {
			$pass = AccountManager::generatePassword();;
			$this->pwd = $pass['e'];
		}
		else {
			$this->pwd = $pwd;
		}
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

	public function setPwd($p){
		$this->pwd = $p;
	}
	
	public function getPwd(){
		return $this->pwd;
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

    public static function getHumanReadebleRole ($r) {
    	switch ($r) {
			case 1:
				return "User";
			case 2:
				return "Guest";
			case 3:
				return "Administrator";
		}
		return "Guest";
	}

	public static function generatePassword() {

	}

	public function insert () {
    	$sql = "INSERT INTO rb_users (username, password, firstname, lastname, accesses_count, last_access, previous_access, active, files_count, downloads, role)  
				VALUES ('{$this->username}', '{$this->pwd}', '{$this->firstName}', '{$this->lastName}', 0, NULL, NULL, 1, 0, 0, {$this->role})";
    	$this->uid = $this->datasource->executeUpdate($sql);
	}

	public function update () {
    	if ($this->username == null) {
			$sql = "UPDATE rb_users SET firstname = '{$this->firstName}', lastname = '{$this->lastName}', role = {$this->role} WHERE uid = ".$this->uid;
		}
		else {
			$sql = "UPDATE rb_users SET username = '{$this->username}', firstname = '{$this->firstName}', lastname = '{$this->lastName}', role = {$this->role} WHERE uid = ".$this->uid;
		}
		$this->datasource->executeUpdate($sql);
	}

	public function delete ($deleteFromDB) {
    	if ($deleteFromDB) {
    		$sql = "DELETE FROM rb_users WHERE uid = ".$this->uid;
		}
		else {
    		$sql = "UPDATE rb_users SET active = 0 WHERE uid = ".$this->uid;
		}
		$this->datasource->executeUpdate($sql);
	}

	public function restore () {
		$sql = "UPDATE rb_users SET active = 1 WHERE uid = ".$this->uid;

		$this->datasource->executeUpdate($sql);
	}
}
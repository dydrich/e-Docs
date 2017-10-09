<?php

require_once 'User.php';
require_once 'RBUtilities.php';

class Authenticator {
	
	private $datasource;
	private $response;

    public function __construct(DataLoader $dl){
		$this->datasource = $dl;
		$this->response = array();
	}
	
	/**
	 * @return array
	 */
	public function getResponse() {
		return $this->response;
	}
	
	public function login($username, $password){
		$sel_user = "SELECT uid FROM rb_users WHERE username = '{$username}' AND password = '".trim($password)."'";
		$res_user = $this->datasource->executeCount($sel_user);
		if ($res_user == null){
			return false;
		}

		$rb = RBUtilities::getInstance($this->datasource->getSource());
		$user = $rb->loadUserFromUid($res_user);

		$update = "UPDATE rb_users SET accesses_count = (rb_users.accesses_count + 1), previous_access = last_access, last_access = NOW() WHERE uid = ".$res_user;
		$upd = $this->datasource->executeUpdate($update);

		return $user;
	}

	public function loginWithToken($token, $area) {
	    $table = 'rb_users';
        $field = 'uid';

        $sel_user = "SELECT $field FROM $table WHERE token = '{$token}'";
        $uid = $this->datasource->executeCount($sel_user);
        if ($uid == null || $uid == false) {
            return false;
        }
        $rb = RBUtilities::getInstance($this->datasource->getSource());
        $user = $rb->loadUserFromUid($uid, $area);

        $smt = $this->datasource->prepare("UPDATE rb_users SET accesses_count = (rb_users.accesses_count + 1), previous_access = last_access, last_access = NOW() WHERE uid = ?");

        $smt->bind_param("i", $uid);
        $smt->execute();

        return $user;
    }
}

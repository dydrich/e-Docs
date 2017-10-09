<?php

require_once "data_source.php";
require_once "Authenticator.php";

final class RBUtilities{
	
	private $datasource;
	private static $instance;
	
	private function __construct($conn){
		if ($conn instanceof MySQLDataLoader){
			$this->datasource = $conn;
		}
		else{
			$this->datasource = new MySQLDataLoader($conn);
		}
	}

	/**
	 * Load an instance of RBUtilities - Singleton
	 * @param MySQLConnection or MySQLDataLoader $conn - db access
	 * @return RBUtilities instance
	 */
	public static function getInstance($conn){
		if(empty(self::$instance)){
			self::$instance = new RBUtilities($conn);
		}
		return self::$instance;
	}

	public function loadUserConfig($uid){
		$sel_config = "SELECT rb_parametri_utente.*, rb_parametri_configurabili.codice FROM rb_parametri_utente, rb_parametri_configurabili WHERE rb_parametri_utente.id_parametro = rb_parametri_configurabili.id AND id_utente = {$uid}";
		$res_config = $this->datasource->executeQuery($sel_config);
		$config = array();
		if ($res_config){
			foreach ($res_config as $row){
				$data = explode(";", $row['valore']);
				$config[$row['codice']] = $data;
			}
		}
		return $config;
	}

	/**
	 * Load an instance of some User class
	 * @param integer $uid - the user's id
	 * @param string $area - type of user
	 */
	public function loadUserFromUid($uid){
			$sel_user = "SELECT firstname, lastname, username, accesses_count, role FROM rb_users WHERE rb_users.uid = {$uid} ";
				$ut = $this->datasource->executeQuery($sel_user);
				$utente = $ut[0];

				$user = new User($uid, $utente['firstname'], $utente['lastname'], $utente['username'], $utente['role']);

		return $user;
	}

	/**
	 * Returns the distance between dates in a human readable style
	 * @param DateTime $start_date
	 * @param DateTime|null $end_date
	 * @return bool|DateInterval
	 */
	public static function getDateTimeDistance(DateTime $start_date, DateTime $end_date = null) {
		if ($end_date == null) {
			$end_date = new DateTime();
		}
		$distance = $end_date->diff($start_date);
		if ($distance->y > 1) {
			return "oltre ".$distance->y." anni fa";
		}
		else if ($distance->y == 1) {
			return "oltre un anno fa";
		}
		else if ($distance->m > 1) {
			return "oltre ".$distance->m." mesi fa";
		}
		else if ($distance->m == 1) {
			return "oltre un mese fa";
		}
		else if ($distance->d > 1) {
			return "oltre ".$distance->d." giorni fa";
		}
		else if ($distance->d == 1) {
			return "oltre un giorno fa";
		}
		else if ($distance->h > 1) {
			return "oltre ".$distance->h." ore fa";
		}
		else if ($distance->h == 1) {
			return "oltre un'ora fa";
		}
		else if ($distance->i > 35) {
			return "meno di un'ora fa";
		}
		else if ($distance->i < 35 && $distance->i > 30) {
			return "circa mezz'ora fa";
		}
		else if ($distance->i > 10) {
			return "meno di mezz'ora fa";
		}
		else if ($distance->i > 1) {
			return "pochi minuti fa";
		}
		else if ($distance->i == 0) {
			return "pochi secondi fa";
		}
		return "";
	}
	
}

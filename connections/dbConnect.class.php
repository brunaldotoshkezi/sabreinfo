<?php

require_once('config.php');  
include("/../adodb5/adodb.inc.php");
   
    class dbConnect {
	private $_connection;
	private static $_instance;
	
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {
		$db = & ADONewConnection('odbc_mssql');
                $db->Connect('Driver={SQL Server};Server=senecaenterprise.db.seneca.local;Database=SabreDB;', 'sa', 'SspossbV') or die("Unable select db xenia.\n");
                $db->debug = 0;
                $this->_connection=$db;
	}
	
	private function __clone() { }

	public function getConnection() {
		return $this->_connection;
	}
}


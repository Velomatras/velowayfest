<?php //EVO configuration file 
class connection {

private $database_type = '';
private $database_server = '';
private $database_user = '';
private $database_password = '';
private $database_connection_charset = '';
private $database_connection_method = '';
private $dbase = '';

 public function __construct() {
$this->database_type = 'mysql';
$this->database_server = 'localhost';
$this->database_user = 'u1561280_Lion';
$this->database_password = 'slavka04072015!';
$this->database_connection_charset = 'utf8';
$this->database_connection_method = 'SET NAMES';
$this->dbase = 'u1561280_veloway-test';
 }
 public function getConnect() {
	$mysqli = new mysqli($this->database_server, $this->database_user, $this->database_password, $this->dbase);
	$mysqli->set_charset('utf8mb4'); // это может понадобиться, а может — нет
	return $mysqli;
 }
 
}
//$cfg['Servers'][$i]['ssl_verify']
?>
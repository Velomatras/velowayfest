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
//global $database_type, $database_server, $database_user, $database_password,
//$database_connection_charset, $database_connection_method, $dbase;

$this->database_type = 'mysql';
$this->database_server = 'localhost';
$this->database_user = 'u1561280_Lev';
$this->database_password = 'slavkA04072015!';
$this->database_connection_charset = 'utf8';
$this->database_connection_method = 'SET NAMES';
$this->dbase = 'u1561280_velowayfest.su';
 }
 public function getConnect() {
	$mysqli = new mysqli($this->database_server, $this->database_user, $this->database_password, $this->dbase);
	$mysqli->set_charset('utf8'); // это может понадобиться, а может — нет
	return $mysqli;
 }
 public function close($mysqli) {
	$mysqli->close(); 
 }
 
}
//$cfg['Servers'][$i]['ssl_verify']
?>
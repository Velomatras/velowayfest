<?php
require_once 'manager/includes/connection.php';

class loginConnect{
private $sql = NULL;
private $modx_user = 'way_users'; 
private $mysqli = NULL;
private $user = NULL;
private $pass = NULL;

public function __construct() {
	if (!empty($_POST['email'])) $this->user = $_POST['email'];
	else if (!empty($_SESSION['login'])) $this->user = $_SESSION['login'];
    if (!empty($_POST['password'])) $this->pass = md5($_POST['password']);
	else if (!empty($_SESSION['pass'])) $this->pass = $_SESSION['pass'];
	
		  $this->sql = new connection();
		  $this->mysqli = $this->sql->getConnect();	
	  }
  
  //Получение строки с данными юзера из БД
public function getQuery(){
	$uid2 = 0;
	if (empty($this->user) || empty($this->pass)) return $uid2;
	
 $q = "SELECT * FROM $this->modx_user WHERE username = ? AND password = ? ";
$userQ = $this->mysqli->execute_query("$q",[$this->user, $this->pass]);

return $userQ;
}

public function getQuery2($user, $pass){
	$uid2 = 0;
	if (empty($user) || empty($pass)) return $uid2;
	
 $q = "SELECT * FROM $this->modx_user WHERE username = ? AND password = ? ";
$userQ = $this->mysqli->execute_query("$q",[$user, $pass]);

return $userQ;
}

// Получение id юзера
public function getLoginID(){
$userQ = $this->getQuery();
if (!empty($userQ)){
	while ($row = $userQ->fetch_array(MYSQLI_ASSOC)) {
	$uid2 = $row['id']; 
}
}
return $uid2;
}	

// Получение id произвольного юзера, если есть логин и пароль
public function getLoginID2($user, $pass){
$userQ = $this->getQuery2($user, $pass);
if (!empty($userQ)){
	while ($row = $userQ->fetch_assoc()) {
	$uid2 = $row['id']; 
}
}
return $uid2;
}	
  
  //Получение логина юзера
  public function getLoginName(){
	  $uid2 = '';
$userQ = $this->getQuery();
if (!empty($userQ)){
	while ($row = $userQ->fetch_assoc()) {
	$uid2 = $row['username']; 
}
}
return $uid2;
}

//Получение логина юзера используя переменные сессии
  public function getLoginName2(){
	  $this->user = $_SESSION['login'];
	  $this->pass = $_SESSION['pass'];
	  $uid2 = '';
$userQ = $this->getQuery2();
if (!empty($userQ)){
	while ($row = $userQ->fetch_assoc()) {
	$uid2 = $row['username']; 
}
}
return $uid2;
}

public function getSession(){
	if (empty( $_SESSION['login'])) $_SESSION['login'] = $this->user;
	if (empty( $_SESSION['pass'])) $_SESSION['pass'] = $this->pass;
}

public function getMysqli(){
 return $this->mysqli;
}	
  
}
?>
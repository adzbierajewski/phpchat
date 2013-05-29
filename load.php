<?php
//header('HTTP/1.1 500 Internal Server Error');
define('db_host','localhost');
define('db_username','root');
define('db_password','apples');
define('db_name','chat');
define('chatlimit', 100);

session_start();
require_once('MysqliDb.php');
require_once('functions.php');
?>

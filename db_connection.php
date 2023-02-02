<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'iteh_domaci';

$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
$conn->set_charset("utf8");

/* check connection */
if ($conn->connect_errno) {
  printf("Connect failed: %s\n", $conn->connect_error);
  exit();
}


?>
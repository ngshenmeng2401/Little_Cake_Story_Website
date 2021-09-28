<?php
$servername = "localhost";
$username = "javathre_littlecakestoryadmin";
$password = "UUM217kachi";
$dbname = "javathre_littlecakestorydb";

try {
  $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
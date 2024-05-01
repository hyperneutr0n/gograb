<?php 
session_start();
$driverLogged= $_SESSION["driverLogged"];
if ($driverLogged) {
  require "header.php";
  
} else {
  $driverLogged = false;
  $_SESSION["driverLogged"] = $driverLogged;
  header("Location: login.php");

}
?>
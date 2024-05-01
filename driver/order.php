<?php 
session_start();
$userLogged= $_SESSION["userLogged"];
if ($userLogged) {
  require "header.php";
  
} else {
  $userLogged = false;
  $_SESSION["userLogged"] = $userLogged;
  header("Location: login.php");

}
?>
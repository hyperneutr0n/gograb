<?php

include "cryptographic.inc.php";
//pengecekan agar user ga bisa sembarang buka login.php
if (isset($_POST["login-submit"])) {
  require 'dbconn.inc.php';

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM customers WHERE id=? OR username=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../login.php?error=sqlerror");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ss", $username, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      var_dump($result);

      $pwd_Check = PasswordVerify($password, $row["password"]);


      if ($pwd_Check == false) {
        header("Location: ../login.php?error=wrongPassword");
        exit();
      } elseif ($pwd_Check == true) {
        session_start();
        $_SESSION['userid'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        $userLogged = true;
        $_SESSION["userLogged"] = $userLogged;
 
        header("Location: ../index.php?login=loginSuccess");
        exit();
      } else {
        header("Location: ../login.php?error=wrongPassword");
        exit();
      }
    } else {
      header("Location: ../login.php?error=noUser");
      exit();
    }
  }
} else {
  header("Location: ../login.php");
  exit();
}

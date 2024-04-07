<?php
require "includes/dbsetting.inc.php";

//pengecekan d db here
if (isset($_POST["login-submit"])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    header("Location: ../index.php?error=emptyfields");
  } else {
    $sql = "SELECT * FROM customer WHERE username=? OR email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $email, $password);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc()) {
      }
    }
  }
} else {
  header("Location: ../index.php");
  exit();
}

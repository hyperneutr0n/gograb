<?php
require "dbconn.inc.php";
include "cryptographic.inc.php";

session_start();
function generateID()
{
  $currdate = date("YmdHis");
  $id = "GGRB" . $currdate;
  return $id;
}

function generateIDKey()
{
  $currdate = date("YmdHis");
  $id = "CSTKEY" . $currdate;
  return $id;
}


if (isset($_POST['register-submit'])) {
  $id =  generateID();
  $fullname = $_POST["name"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $mobilenumber = $_POST["mobilenumber"];
  $ktp = $_POST["ktp"];
  $password = $_POST["password"];
  $confirmpass = $_POST["confirm"];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../register.php?error=invalidemail" .
      "&fullname=" . $fullname .
      "&username=" . $username .
      "&mobile=" . $mobilenumber);

    exit();
  } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../register.php?error=invalidusername" .
      "&fullname=" . $fullname .
      "&email=" . $email .
      "&mobile=" . $mobilenumber);
    exit();
  } else if (preg_match('/^[0-9]{9}+$/', $mobilenumber)) {
    header("Location: ../register.php?error=invalidemobilenumber" .
      "&fullname=" . $fullname .
      "&username=" . $username .
      "&email=" . $email);
    exit();
  } else if ($password != $confirmpass) {
    header("Location: ../register.php?error=invalidemail" .
      "&fullname=" . $fullname .
      "&username=" . $username .
      "&email=" . $email .
      "&mobile=" . $mobilenumber .
      "&ktp=" . $ktp);
    exit();
  } else {
    $sql = "SELECT username FROM admins WHERE username=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../register.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s",  $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $result_check = mysqli_stmt_num_rows($stmt);
      if ($result_check > 0) {
        header("Location: ../register.php?error=usernametaken" .
          "&fullname=" . $fullname .
          "&email=" . $email .
          "&mobile=" . $mobilenumber);
        exit();
      } else {
        $hashpass = PasswordHash($password);
        $sql = "INSERT INTO admins(id, username, password, nama, email, nomor_telp, nomor_ktp) VALUES(?,?,?,?,?,?,?)";
        $sql2 = "INSERT INTO keyadmins(id, admins_id, encryptionkey) VALUES(?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          //error handling
          header("Location: ../register.php?error=sqlerror");
          exit();
        } else if (!mysqli_stmt_prepare($stmt2, $sql2)) {
          header("Location: ../register.php?error=sqlerror");
          exit();
        } else if (!preg_match("/^[0-9]{16}$/", $ktp)) {
          header("Location: ../register.php?error=invalidktp" .
            "&fullname=" . $fullname .
            "&username=" . $username .
            "&email=" . $email .
            "&mobile=" . $mobilenumber);
          exit();
        } else {
          //bind param
          $key = GenerateKey();
          $encryptedID = DataEncrypt($id, $key);
          $encryptedTelp = DataEncrypt($mobilenumber, $key);
          $encryptedKtp = DataEncrypt($ktp, $key);
          $idKey = generateIDKey();

          mysqli_stmt_bind_param($stmt, "sssssss", $encryptedID, $username, $hashpass, $fullname, $email, $mobilenumber, $ktp);
          mysqli_stmt_execute($stmt);

          mysqli_stmt_bind_param($stmt2, "sss", $idKey, $encryptedID, $key);
          mysqli_stmt_execute($stmt2);

          header("Location: ../adminregister.php?register=success");
          exit();
        }
      }
    }
  }
} else {
  mysqli_stmt_close($stmt);
  mysqli_stmt_close($stmt2);
  mysqli_close($conn);
  header("Location: ../register.php?error=sqlerror");
  exit();
}

<?php
require "dbconn.inc.php";
require "cryptographic.inc.php";

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
  $id = generateID();
  $fullname = $_POST["name"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $mobilenumber = $_POST["mobilenumber"];
  $ktp = $_POST["ktp"];
  $password = $_POST["password"];
  $confirmpass = $_POST["confirm"];
  $vehicle_type = $_POST["vehicle_type"];
  $vehicle_plate = $_POST["vehicle_plate"];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../driverregister.php?error=invalidEmail" .
      "&fullname=" . $fullname .
      "&username=" . $username .
      "&mobile=" . $mobilenumber .
      "&ktp=" . $ktp .
      "&type=" . $vehicle_type .
      "&plate=" . $vehicle_plate);
    exit();
  } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../driverregister.php?error=invalidUsername" .
      "&fullname=" . $fullname .
      "&email=" . $email .
      "&mobile=" . $mobilenumber .
      "&ktp=" . $ktp .
      "&type=" . $vehicle_type .
      "&plate=" . $vehicle_plate);
    exit();
  } else if (preg_match('/^[0-9]{9}+$/', $mobilenumber)) {
    header("Location: ../driverregister.php?error=invalidMobileNumber" .
      "&fullname=" . $fullname .
      "&username=" . $username .
      "&email=" . $email .
      "&ktp=" . $ktp .
      "&type=" . $vehicle_type .
      "&plate=" . $vehicle_plate);
    exit();
  } else if (!preg_match("/^[0-9]{16}$/", $ktp)) {
    header("Location: ../driverregister.php?error=invalidKtp" .
      "&fullname=" . $fullname .
      "&username=" . $username .
      "&email=" . $email .
      "&mobile=" . $mobilenumber .
      "&ktp=" . $ktp .
      "&type=" . $vehicle_type .
      "&plate=" . $vehicle_plate);
    exit();
  } else if (!preg_match('/[A-Z]{1,2}\s{1}\d{1,4}\s{1}[A-Z]{1,4}/i', $vehicle_plate)) {
    header("Location: ../driverregister.php?error=invalidPlate" .
      "&fullname=" . $fullname .
      "&username=" . $username .
      "&email=" . $email .
      "&mobile=" . $mobilenumber .
      "&ktp=" . $ktp .
      "&type=" . $vehicle_type);
    exit();
  } else if ($password != $confirmpass) {
    header("Location: ../driverregister.php?error=passNotMatch" .
      "&fullname=" . $fullname .
      "&username=" . $username .
      "&email=" . $email .
      "&ktp=" . $ktp .
      "&type=" . $vehicle_type);
    exit();
  } else {
    $sql = "SELECT username FROM drivers WHERE username=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../driverregister.php?error=sqlerrorSelect");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s",  $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $result_check = mysqli_stmt_num_rows($stmt);
      if ($result_check > 0) {
        header("Location: ../driverregister.php?error=usernametaken" .
          "&fullname=" . $fullname .
          "&email=" . $email .
          "&mobile=" . $mobilenumber);
        exit();
      } else {
        $hashpass = PasswordHash($password);
        $sql = "INSERT INTO drivers(id, nama, username, email, password, saldo, nomor_telp, nomor_ktp, jenis_kendaraan, plat_nomor_kendaraan) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $sql2 = "INSERT INTO keydrivers(id, drivers_id, encryptionkey) VALUES(?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          //error handling
          echo "Kesalahan query: " . mysqli_stmt_error($stmt);
          header("Location: ../driverregister.php?error=sqlerrorInsertDriver");
          exit();
        } else if (!mysqli_stmt_prepare($stmt2, $sql2)) {
          $error_message = mysqli_stmt_error($stmt2);
          header("Location: ../driverregister.php?error=sqlerrorInsertKey" . mysqli_error($conn));
          exit();
        } else {
          //bind param
          $key = GenerateKey();
          $encryptedID = DataEncrypt($id, $key);
          $encryptedKtp = DataEncrypt($ktp, $key);
          $encryptedTelp = DataEncrypt($mobilenumber, $key);
          $encryptedZero = DataEncrypt(0, $key);
          $idKey = generateIDKey();
          mysqli_stmt_bind_param($stmt, "ssssssssss", $encryptedID, $fullname, $username, $email, $hashpass, $encryptedZero, $encryptedTelp, $encryptedKtp, $vehicle_type, $vehicle_plate);

          mysqli_stmt_execute($stmt);

          mysqli_stmt_bind_param($stmt2, "sss", $idKey, $encryptedID, $key);
          mysqli_stmt_execute($stmt2);

          header("Location: ../driverregister.php?register=success");
          exit();
        }
      }
    }
  }
} else {
  mysqli_stmt_close($stmt);
  mysqli_stmt_close($stmt2);
  mysqli_close($conn);
  header("Location: ../driverregister.php?error=sqlerror" . mysqli_error($conn));
  exit();
}

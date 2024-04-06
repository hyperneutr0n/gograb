<?php
require "dbconn.inc.php";
function generateID()
{
    $currdate = date("YmdHis");
    $id = "GGRB" . $currdate;
    return $id;
}


if (isset($_POST['register-submit'])) {
    $fullname = $_POST["full-name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $mobilenumber = $_POST["mobile-number"];
    $password = $_POST["password"];
    $confirmpass = $_POST["confirm-password"];

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
            "&mobile=" . $mobilenumber);
        exit();
    } else {
        $sql = "SELECT username FROM customers WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
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
                $hashpass = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO customers VALUES(?,?,?)";
            }
        }
    }
}

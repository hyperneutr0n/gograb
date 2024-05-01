<?php
session_start();
require "dbconn.inc.php";
require "cryptographic.inc.php";

if (isset($_POST["confirm"])) {
    $id = "";


    if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
    }
    $sql2 = "SELECT * FROM customers WHERE id=?";
    $stmt2 = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt2, $sql2)) {
        mysqli_stmt_bind_param($stmt2, "s", $id);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        if ($result2) {
            $customerRow = mysqli_fetch_assoc($result2);
        } else {
            header("Location: ../accountdetails.php?nocustomer");
        }
    }



    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];


    if ($newPassword != $confirmPassword) {
        header("Location: ../accountdetails.php?wrongpassword");
    } else {
        $passwordCheck = $customerRow["password"];
        $oldPassword = $_POST["oldPassword"];

        $pwdCheck = PasswordVerify($oldPassword, $passwordCheck);

        if (!$pwdCheck) {
            header("Location: ../accountdetails.php?incorrectoldpass");
        } else {
            $notelp = $_POST["no_telp"];
            $email = $_POST["email"];
            $fullname = $_POST["fullName"];

            $sql = "SELECT encryptionkey FROM keyCustomers WHERE customers_id= ?";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                $resultkey = mysqli_stmt_get_result($stmt);

                if ($resultkey) {
                    $row = mysqli_fetch_assoc($resultkey);
                    // Get encryption key
                    $encryptionKey = $row["encryptionkey"];
                }
            }


            $hashedPassword = PasswordHash($confirmPassword);



            $sqlUpdate = "UPDATE customers SET nama = ?,  email = ?, no_telp = ?, password = ? WHERE id = ?";
            $stmtupdate = mysqli_stmt_init($conn);

            $encryptedNoTelp = DataEncrypt($notelp, $encryptionKey);

            if (mysqli_stmt_prepare($stmtupdate, $sqlUpdate)) {
                mysqli_stmt_bind_param($stmtupdate, "sssss", $fullname, $email, $encryptedNoTelp, $hashedPassword, $id);
                mysqli_stmt_execute($stmtupdate);
                header("Location: accountdetails.inc.php");
            }
        }
    }
} else {
    header("Location: ../accountdetails.php");
}

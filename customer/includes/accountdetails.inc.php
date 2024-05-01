<?php 
session_start();

// Include necessary files
include "dbconn.inc.php";
include "cryptographic.inc.php";

// Initialize customer details array
$customerdetails = array();

// Check if user is logged in
if(isset($_SESSION["userLogged"]) && $_SESSION["userLogged"] == true){

    // Get user ID
    $id =  $_SESSION["id"];

    echo "User ID: $id";
    // Query to fetch encryption key
    $sql = "SELECT encryptionkey FROM keyCustomers WHERE customers_id= ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if($result){
            $row = mysqli_fetch_assoc($result);
    
            // Get encryption key
            $encryptionKey = $row["encryptionkey"];
    
            // Query to fetch customer details
            $sql2 = "SELECT * FROM customers WHERE id=?";
            $stmt2 = mysqli_stmt_init($conn);
    
            if(mysqli_stmt_prepare($stmt2, $sql2)){
                mysqli_stmt_bind_param($stmt2, "s", $id);
                mysqli_stmt_execute($stmt2);
                $result2 = mysqli_stmt_get_result($stmt2);
    
                if($result2){
                    $customerRow = mysqli_fetch_assoc($result2);
    
                    // Decrypt sensitive datas
                    $decryptedID = DataDecrypt($customerRow["id"], $encryptionKey);
                    $decryptedSaldo = DataDecrypt($customerRow["saldo"], $encryptionKey);
                    $decryptedNoTelp = DataDecrypt($customerRow["no_telp"], $encryptionKey);
    
                    // Store customer details in an array
                    $customerdetails = array(
                        "id" => $decryptedID,
                        "nama" => $customerRow["nama"],
                        "username" => $customerRow["username"],
                        "email" => $customerRow["email"],
                        "saldo" => $decryptedSaldo,
                        "no_telp" => $decryptedNoTelp
                    );
    
                    // Store customer details in session variable
                    $_SESSION["customerDetails"] = $customerdetails;
    
                    // Redirect to account details page
                    header("Location: ../accountdetails.php");
                    exit(); // Terminate script execution after redirection
                } else {
                    echo "Error fetching customer details: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to prepare statement for fetching customer details: " . mysqli_error($conn);
            }
        } else {
            echo "Error fetching encryption key: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to prepare statement for fetching encryption key: " . mysqli_error($conn);
    }}
    

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
    $sql = "SELECT encryptionkey FROM keyCustomers WHERE customers_id= '$id'";
    
    $stmt = mysqli_query($conn, $sql);

    if($stmt){
        $row = mysqli_fetch_assoc($stmt);

        // Get encryption key
        $encryptionKey = $row["encryptionkey"];

        // Query to fetch customer details
        $sql2 = "SELECT * FROM customers WHERE id='$id'";
        $stmt2 = mysqli_query($conn, $sql2);

        if($stmt2){
            // Fetch customer details
            $customerRow = mysqli_fetch_assoc($stmt2);

            // Decrypt sensitive data
            $decryptedID = DataDecrypt($customerRow["id"], $encryptionKey);

            // Store customer details in an array
            $customerdetails = array(
                "id" => $decryptedID,
                "nama" => $customerRow["nama"],
                "username" => $customerRow["username"],
                "email" => $customerRow["email"],
                "saldo" => $customerRow["saldo"],
                "no_telp" => $customerRow["no_telp"],
                "points" => $customerRow["points"]
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
        echo "Error fetching encryption key: " . mysqli_error($conn);
    }
} else {
    // Redirect to index page if user is not logged in
    header("Location: ../index.php");
    exit(); // Terminate script execution after redirection
}
?>

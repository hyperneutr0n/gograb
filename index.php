<?php
session_start(); //membuat session ID ini dijalankan sebelum html digenerate

$userLogged = false;
if (isset($_SESSION['userLogged'])) { //SESSION berfungsi untuk store data dan bisa digunakan cross website tanpa session $userLogged masih bisa diakses di sini tanpa di redeclare, session berguna hnya utk manipulasi data
    $userLogged = true;
    require "header.php";
} else {
  /*   $userLogged = false;
    $_SESSION['userLogged'] = $userLogged;
    header("Location: login.php"); */
}
?>
<main>
    <div class="container container-login bg-light">
        <div class="row">
            <div class='d-flex col-auto'>
                <h3 class='balance'>Welcome XXXXX</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">
                <h3 class='balance'>Balance: XXXX</h3>
            </div>
            <div class="col">
                <div class="d-flex justify-content-end">
                    <a href="" class="btn btn-primary ml-1 bg-dark">Pay</a>
                    <a href="" class="btn btn-primary ml-1 bg-dark">History</a>
                    <a href="" class="btn btn-primary ml-1 bg-dark">More</a>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require "footer.php";
?>
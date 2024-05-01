<?php
session_start(); //membuat session ID ini dijalankan sebelum html digenerate

$adminLogged = $_SESSION["adminLogged"];


if ($adminLogged) { //SESSION berfungsi untuk store data dan bisa digunakan cross website tanpa session $userLogged masih bisa diakses di sini tanpa di redeclare, session berguna hnya utk manipulasi data
    require "header.php";
} else {
    $adminLogged = false;
    $_SESSION["adminLogged"] = $adminLogged;
    header("Location: login.php");
}
?>
<main>
    <div class="container container-login bg-light">

        <div class="row">
            <div class="col-8">
                <label for="cstdata">Access Customer Data</label>
                <a href="datacustomer.php">
                    <button name="cstdata">
                        Customer Data
                    </button>
                </a>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-8">
                <label for="drvdata">Access Driver Data</label>
                <a href="datadriver.php">
                    <button name="drvdata">
                        Driver Data
                    </button>
                </a>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-8">
                <label for="orderdata">Access Order Data</label>
                <a href="dataorder.php">
                    <button name="orderdata">
                        Order Data
                    </button>
                </a>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
</main>


<?php
require "footer.php";
?>
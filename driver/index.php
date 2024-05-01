<?php
session_start(); //membuat session ID ini dijalankan sebelum html digenerate

$driverLogged = $_SESSION["driverLogged"];


if ($driverLogged) { //SESSION berfungsi untuk store data dan bisa digunakan cross website tanpa session $driverLogged masih bisa diakses di sini tanpa di redeclare, session berguna hnya utk manipulasi data
    require "header.php";
} else {
    $driverLogged = false;
    $_SESSION["driverLogged"] = $driverLogged;
    header("Location: login.php");
}
?>
<main>
    <div class="container container-login bg-light">
        <div class="row">
            <div class="col-8">
                <label for="">add some pics</label>

            </div>
            <div class="col-3">
                <label for="">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquid quis, veniam facere amet nihil corporis commodi est cumque praesentium odio perferendis porro natus nemo ipsam dicta fugiat dolore, illum mollitia!</label>

            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <label for="">add some pics</label>

            </div>
            <div class="col-3">
                <label for="">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquid quis, veniam facere amet nihil corporis commodi est cumque praesentium odio perferendis porro natus nemo ipsam dicta fugiat dolore, illum mollitia!</label>

            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <label for="">add some pics</label>

            </div>
            <div class="col-3">
                <label for="">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquid quis, veniam facere amet nihil corporis commodi est cumque praesentium odio perferendis porro natus nemo ipsam dicta fugiat dolore, illum mollitia!</label>

            </div>
        </div>
    </div>
</main>


<?php
require "footer.php";
?>
<?php
session_start(); //membuat session ID ini dijalankan sebelum html digenerate

$userLogged = $_SESSION["userLogged"];


if ($userLogged) { //SESSION berfungsi untuk store data dan bisa digunakan cross website tanpa session $userLogged masih bisa diakses di sini tanpa di redeclare, session berguna hnya utk manipulasi data
    require "header.php";
} else {
    $userLogged = false;
    $_SESSION["userLogged"] = $userLogged;
    header("Location: login.php");
}
?>
<main>
<div class="container container-login">
        <div class="image">
            <img src="assets/homepic1.jpg" alt="Driver in car" width="800" height="400">
        </div>

        <?php
        $title = "Drive when you want, make what you need";
        $description = " There's a hundred-thousand streets in this city. You don't need to know the route. You give us a time and a place, We will get you there.";
        $buttonText = "Order GoGrab";
        ?>

        <div class="content">
            <h1><?php echo $title; ?></h1>
            <p><?php echo $description; ?></p>
            <button class="button"><?php echo $buttonText; ?></button>
        </div>
    </div>
    <div class="container">

        <?php
        $title = "Good to Go? Use our GoGrab app today!";
        ?>
        <div class="content">
            <h1><?php echo $title; ?></h1>
        </div>

        <div class="image">
            <img src="assets/homepic2.jpg" width="612" height="400">
        </div>

    </div>
    <br>
    <br>
</main>


<?php
require "footer.php";
?>
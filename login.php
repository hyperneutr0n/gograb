<?php
session_start();
$userLogged = $_SESSION["userLogged"];

if ($userLogged == true) {
    header("Location: index.php");
} else {
    require "header.php";
}


/*  di comment karena pengecekannya nanti melalui database ini hanya simple checking

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // insert pengecekan database here sementara lsg ubah jadi true

        $userLogged = true;

        $_SESSION['userLogged'] = $userLogged;

        header("Location: index.php");
    }
} */ 
?>
<main>
    <form method="post" action="includes/login.inc.php" class="text-center">
        <div class="container container-login bg-light">
            <p>Sign in</p>
            <div class="row justify-content-center">
                <div class="col-5">
                    <p style="text-align: left">Username</p>
                    <div class="form-group d-flex justify-content-center align-items-center">
                        <input type="text" class="form-control" autofocus placeholder="Username" name="username">
                        <i class="fas fa-user ml-2"></i>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-5">
                    <p style="text-align: left">Password</p>
                    <div class="form-group d-flex justify-content-center align-items-center">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <i class="fas fa-lock ml-2"></i>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="row mt-4">

            </div>
        </div>
    </form>
</main>

<?php require "footer.php" ?>
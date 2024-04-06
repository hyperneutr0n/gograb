<?php
session_start();

$userLogged = $_SESSION["userLogged"];

if ($userLogged) {

    header("Location:index.php");
} else {
    require "header.php";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["mobilenumber"]) && isset($_POST["password"])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $name = $firstname . $lastname;
        $email = $_POST["email"];
        $mobilenumber = $_POST["mobilenumber"];
        $password = $_POST["password"];

        //isi masukno database and stuff


        header("Location: index.php");
    }
}
?>
<main>
    <form method="post" action="includes/register.inc.php" class="text-center">
        <div class="container container-login bg-light"> <!-- class dr css biar tampilan nya turun dikit -->
            <p>Register</p>
            <div class="row"><!-- buat baris yang diisi kolom intinya smua nya nnti posisi e dlm 1 baris -->
                <div class="col"> <!-- isi kolom pertama -->
                    <p style="text-align:left">Full Name:</p>
                    <div class="form-group justify-content-center">
                    </div>
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="col"><!-- isi kolom kedua -->
                    <p style="text-align:left">Username:</p>
                    <div class="form-group justify-content-center">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="text-align:left">Email:</p>
                    <div class="form-group justify-content-center">
                        <input type="text" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="col">
                    <p style="text-align: left">Mobile Number:</p>
                    <div class="form-group d-flex">
                        <input type="text" name="mobilenumber" placeholder="+62" disabled style="width:35px">
                        <input type="text" name="mobilenumber" placeholder="xxxx-xxxx-xxxx" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="text-align:left">Password:</p>
                    <div class="form-group justify-content-center">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="col">
                    <p style="text-align:left">
                        Confirm Password:
                    </p>
                    <div class="form-group">
                        <input type="password" name="confirm" placeholder="Confirm Password" required>
                    </div>
                    <!-- Untuk spacing -->
                </div>
            </div>
            <div class="row justify-content-end mr-2">
                <button type="submit" class="btn btn-primary" name = "register-submit">Register</button>
            </div>
            <div class="row mt-4">
                <!-- Untuk spacing -->
            </div>
        </div>
    </form>
</main>

<?php require "footer.php"; ?>
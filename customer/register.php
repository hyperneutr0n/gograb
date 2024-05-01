<?php
if (isset($_SESSION["userLogged"]) && $_SESSION["userLogged"]== true) {
    header("Location: index.php");
    exit();
} else {
    $userLogged = false;
    require "header.php";
}
?>
<main>
    <form method="post" action="includes/register.inc.php" class="text-center">
        <div class="container container-login bg-light"> 
            <!-- class dr css biar tampilan nya turun dikit -->
            <p>Register</p>
            <div class="row">
                <!-- buat baris yang diisi kolom intinya smua nya nnti posisi e dlm 1 baris -->
                <div class="col"> <!-- isi kolom pertama -->
                    <p style="text-align:left">Full Name:</p>
                    <div class="form-group justify-content-center">
                    </div>
                    <input type="text" name="name"class = "form-control" placeholder="Full Name" required>
                </div>
                <div class="col"><!-- isi kolom kedua -->
                    <p style="text-align:left">Username:</p>
                    <div class="form-group justify-content-center">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="text-align:left">Email:</p>
                    <div class="form-group justify-content-center">
                        <input type="text" name="email" class="form-control" placeholder="Email" required>
                    </div>
                </div>
                <div class="col">
                    <p style="text-align: left">Mobile Number:</p>
                    <div class="form-group d-flex">
                        <div class="input-group-prepend">
                            <span class="input-group-text">+62</span>
                        </div>
                        <input type="text" class="form-control" name="mobilenumber" placeholder="xxxx-xxxx-xxxx" required>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <p style="text-align:left">Password:</p>
                    <div class="form-group justify-content-center">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>
                <div class="col">
                    <p style="text-align:left">
                        Confirm Password:
                    </p>
                    <div class="form-group">
                        <input type="password" name="confirm" class="form-control" placeholder="Confirm Password" required>
                    </div>
                    <!-- Untuk spacing -->
                </div>
            </div>
            <div class="row justify-content-end mr-2">
                <button type="submit" class="btn btn-primary" name="register-submit">Register</button>
            </div>
            <div class="row mt-4">
                <!-- Untuk spacing -->
            </div>
        </div>
    </form>
</main>

<?php 
require "footer.php"; 
?>
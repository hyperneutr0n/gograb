<?php require "header.php";
session_start();
$userLogged = $_SESSION["userLogged"];


if ($userLogged) { //SESSION berfungsi untuk store data dan bisa digunakan cross website tanpa session $userLogged masih bisa diakses di sini tanpa di redeclare, session berguna hnya utk manipulasi data
    require "header.php";
} else {
    $userLogged = false;
    $_SESSION["userLogged"] = $userLogged;
    header("Location: login.php");
}
$showPasswordFields = false;
$editButtonVisible = true;
$access = "disabled";
if (isset($_POST["edit"])) {
    $showPasswordFields = true;
    $editButtonVisible = false;
    $access = "";
}
if (isset($_POST['cancel'])) {
    $showPasswordFields = false;
    $editButtonVisible = true;
}


$customerdetails =  $_SESSION["customerDetails"];



?>

<div class="container container-login">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center mb-4">Account Details</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="id">
                        ID:
                    </label>
                    <input type="text" class="form-control" id="id" value="<?=$customerdetails["id"];?>" disabled>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" value="<?=$customerdetails["username"];?>" disabled>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" value="<?=$customerdetails["email"];?>" <?=$access?>>
                </div>
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" class="form-control" id="fullName" value="<?=$customerdetails["nama"];?>" <?=$access?>>
                </div>
                <div class="form-group">
                    <label for="nomor_telp">Nomor Telp:</label>
                    <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                    <input type="text" class="form-control" id="no_telp" value="<?=$customerdetails["no_telp"];?>" <?=$access?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Saldo: </label>
                    <label for="saldo">Rp.<?=$customerdetails["saldo"];?></label>
                    </select>
                </div>
                <?php if ($showPasswordFields) : ?>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                    </div>
                    <button type="submit" name="confirm" class="btn btn-primary mr-2 mb-4">Confirm</button>
                    <button type="submit" name="cancel" class="btn btn-secondary mb-4">Cancel</button>
                <?php endif; ?>
            </form>
            <form method="POST" action="">
                <?php if ($editButtonVisible) : ?>
                    <button type="submit" name="edit" class="btn btn-primary mb-4">Edit</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
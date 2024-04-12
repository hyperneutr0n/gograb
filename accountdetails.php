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
if (isset($_POST["edit"])) {
    $showPasswordFields = true;
    $editButtonVisible = false;
}
if (isset($_POST['cancel'])) {
    $showPasswordFields = false;
    $editButtonVisible = true;
}

?>

<div class="container container-login">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center mb-4">Account Details</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" value="JohnDoe123" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" value="johndoe@example.com">
                </div>
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" class="form-control" id="fullName" value="John Doe">
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" value="2024-01-01">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
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
            <form method = "POST" action = "">
                <?php if ($editButtonVisible) : ?>
                    <button type="submit" name="edit" class="btn btn-primary mb-4">Edit</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
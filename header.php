<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoGrab</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: black;"> <!-- menggunakan class navbar dari bootstrap, navbar-expand-md itu berarti sampai screen berada di size medium navbar akan expand, navbar-dark untuk fontnya, bg itu background-->
            <a class="navbar-brand ml-5" href="index.php">GoGrab</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation"> <!-- intinya ini utk collapse semisal screen sizenya dibawah medium, yang penting itu class navbar-toggler dan data target, datatargetnya menjadi id di div class agar jika kondisi terpenuhi akan collapse -->
                <span class="navbar-toggler-icon"></span><!--  katanya chatgpt ini placeholder but this is literally an icon -->
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link" href="#company">Company <span class="sr-only">(current)</span></a>
                    <?php
                    if ($userLogged) {  //krn sudah ada pengecekan di atas jika udah log in maka tampilan berbeda sesuai hak akses
                        echo ' 
                        <a class = "nav-item nav-link ml-2 mr-2" href = "ride.php"> Ride</a>
                        <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle bg-transparent mt-0.5" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color:black;">
                        Account
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-light" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="includes/accountdetails.inc.php">Personal Information</a>
                          <form action = "includes/logout.inc.php" method = "POST">
                          <a class = "dropdown-item" href ="includes/accounthistory.inc.php"> History </a>
                          <a class="dropdown-item" href = "logout.php">Logout</a>
                          </form>
                        </div>
                      </div>       
                      ';
                    } else {
                        echo '<a class="nav-item nav-link active" href="login.php">Login</a>';
                        echo '<a class="nav-item nav-link" href="register.php">Register</a>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
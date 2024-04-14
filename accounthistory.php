<?php require "header.php";
session_start();
$userLogged = $_SESSION["userLogged"];


if ($userLogged) { //SESSION berfungsi untuk store data dan bisa digunakan cross website tanpa session $userLogged masih bisa diakses di sini tanpa di redeclare, session berguna hnya utk manipulasi data
    require "header.php";
} else {
    $userLogged = false;
    $_SESSION["userLogged"] = $userLogged;
    header("Location: login.php");


} ?>

<div class="container xcontainer-login">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="text-center mb-4">GoGrab Account History</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th> Invoice </th>
                        <th>Date</th>
                        <th>Ride</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Distance</th>
                        <th>Duration</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-04-01</td>
                        <td>GoGrab Ride - Home to Work</td>
                        <td>123 Main St, City A</td>
                        <td>456 Elm St, City B</td>
                        <td>8 miles</td>
                        <td>30 minutes</td>
                        <td>$15.00</td>
                    </tr>
                    <tr>
                        <td>2024-03-28</td>
                        <td>GoGrab Ride - Work to Home</td>
                        <td>456 Elm St, City B</td>
                        <td>123 Main St, City A</td>
                        <td>8 miles</td>
                        <td>30 minutes</td>
                        <td>$12.00</td>
                    </tr>
                    <tr>
                        <td>2024-03-25</td>
                        <td>GoGrab Ride - Airport Transfer</td>
                        <td>789 Airport Blvd</td>
                        <td>123 Main St, City A</td>
                        <td>15 miles</td>
                        <td>45 minutes</td>
                        <td>$25.00</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "footer.php"?>
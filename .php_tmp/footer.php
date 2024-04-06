<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoGrab-like Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: sans-serif, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Set minimum height to viewport height */
        }

        .content {
            flex: 1;
            /* Grow to fill remaining vertical space */
        }

        .footer {
            background-color: #000000;
            /* Ubah warna latar belakang menjadi hitam */
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .footer h1 {
            margin-top: 0;
            font-size: 14px;
            /* Set the same font size as other footer links */
        }

        .footer-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .footer-link {
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            /* Atur padding agar area efek shadow lebih besar */
            cursor: pointer;
            /* Tambahkan cursor pointer agar terlihat interaktif */
            transition: color 0.3s;
            /* Tambahkan transition untuk perubahan warna */
            position: relative;
            /* Tambahkan position relative untuk mengatur posisi overlay */
        }

        .footer-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background-color: transparent;
            transition: background-color 0.3s;
        }

        .footer-link:hover::after {
            background-color: #ffffff;
        }

        .footer-link:hover {
            color: #ffffff;
            /* Ubah warna tulisan menjadi putih saat hover */
        }

        .footer-link:active {
            color: #ffffff;
            /* Ubah warna tulisan menjadi putih saat ditekan */
        }

        /* Style for the icons */
        .app-icons a {
            position: relative;
        }

        .app-icons a i {
            color: #ffffff;
            font-size: 24px;
            transition: color 0.3s;
        }

        /* Style for the bottom border on hover */
        .app-icons a:hover::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background-color: #ffffff;
            transition: background-color 0.3s;
        }

        /* Style for the icons */
        .app-icons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .app-icons a i {
            color: #ffffff;
            font-size: 24px;
            transition: color 0.3s;
        }

        /* Hover effect for the icons */
        .app-icons a:hover i {
            color: #ffffff;
        }

        /* Style for the bottom border */
        .app-icons a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background-color: transparent;
            transition: background-color 0.3s;
        }

        .app-icons a:hover::after {
            background-color: #ffffff;
        }
    </style>
    <!-- JavaScript imports -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

    <div class="content">
        <!-- Your main content goes here -->
    </div>

    <div class="footer">
        <div class="footer-links">
            <a href="#" class="footer-link">About us</a>
            <a href="#" class="footer-link">Our offerings</a>
            <a href="#" class="footer-link">Newsroom</a>
            <a href="#" class="footer-link">Investors</a>
            <a href="#" class="footer-link">Blog</a>
            <a href="#" class="footer-link">Careers</a>
            <a href="#" class="footer-link">AI</a>
            <a href="#" class="footer-link">Gift cards</a>
            <a href="#" class="footer-link">Ride</a>
            <a href="#" class="footer-link">Drive</a>
            <a href="#" class="footer-link">Deliver</a>
            <a href="#" class="footer-link">Eat</a>
            <a href="#" class="footer-link">GoGrab for Business</a>
            <a href="#" class="footer-link">GoGrab Freight</a>
            <a href="#" class="footer-link">GoGrab Health</a>
            <a href="#" class="footer-link">Safety</a>
            <a href="#" class="footer-link">Diversity and Inclusion</a>
            <a href="#" class="footer-link">Sustainability</a>
            <a href="#" class="footer-link">Reserve</a>
            <a href="#" class="footer-link">Airports</a>
        </div>
        <br>
        <div class="app-icons">
            <a href="#" class="app-link">
                <i class="fab fa-google-play"></i> <span style="color: white;">Get in on Google Play</span>
            </a>
            <a href="#" class="app-links">
                <i class="fab fa-app-store"></i> <span style="color: white;">Download on the App Store</span>
            </a>
        </div>
        <p>&copy; 2024 GoGrab Technologies Inc.</p>
    </div>

</body>

</html>
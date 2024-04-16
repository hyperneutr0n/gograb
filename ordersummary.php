<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <?php
    // Definisikan fungsi untuk memformat angka ke dalam mata uang
    function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
    include 'header.php';
    $orderSummary = [
        'order_id' => 'UBER123456',
        'pickup_location' => 'Jalan Pahlawan No. 10, Jakarta',
        'dropoff_location' => 'Jalan Sudirman No. 50, Jakarta',
        'driver' => [
            'name' => 'John Doe',
            'rating' => 4.8,
            'car' => [
                'make' => 'Toyota',
                'model' => 'Camry',
                'plate' => 'B 1234 XYZ',
            ],
        ],
        'fare' => [
            'base_fare' => 20000,
            'distance_fare' => 15000,
            'time_fare' => 5000,
            'total_fare' => 40000,
        ],
        'trip_details' => [
            'distance' => '10 km',
            'duration' => '15 min',
        ],
    ];
    ?>
    <div class="order-summary">
        <h1>Ringkasan Pesanan Uber</h1>

        <!-- Informasi Pesanan -->
        <div class="order-info">
            <p><strong>Pesanan ID:</strong> <?php echo $orderSummary['order_id']; ?></p>
        </div>

        <!-- Informasi Perjalanan -->
        <div class="trip-info">
            <h2>Informasi Perjalanan</h2>
            <p><strong>Lokasi Penjemputan:</strong> <?php echo $orderSummary['pickup_location']; ?></p>
            <p><strong>Lokasi Tujuan:</strong> <?php echo $orderSummary['dropoff_location']; ?></p>
        </div>

        <!-- Informasi Pengemudi -->
        <div class="driver-info">
            <h2>Informasi Pengemudi</h2>
            <p><strong>Nama:</strong> <?php echo $orderSummary['driver']['name']; ?></p>
            <p><strong>Rating:</strong> <?php echo $orderSummary['driver']['rating']; ?></p>
            <p><strong>Kendaraan:</strong> <?php echo $orderSummary['driver']['car']['make']; ?> <?php echo $orderSummary['driver']['car']['model']; ?></p>
            <p><strong>Plat Nomor:</strong> <?php echo $orderSummary['driver']['car']['plate']; ?></p>
        </div>

        <!-- Detail Tarif -->
        <div class="fare-details">
            <h2>Detail Tarif</h2>
            <p><strong>Tarif Dasar:</strong> <?php echo formatCurrency($orderSummary['fare']['base_fare']); ?></p>
            <p><strong>Tarif Jarak:</strong> <?php echo formatCurrency($orderSummary['fare']['distance_fare']); ?></p>
            <p><strong>Tarif Waktu:</strong> <?php echo formatCurrency($orderSummary['fare']['time_fare']); ?></p>
            <p><strong>Tarif Total:</strong> <?php echo formatCurrency($orderSummary['fare']['total_fare']); ?></p>
        </div>

        <!-- Detail Perjalanan -->
        <div class="trip-details">
            <h2>Detail Perjalanan</h2>
            <p><strong>Jarak:</strong> <?php echo $orderSummary['trip_details']['distance']; ?></p>
            <p><strong>Durasi:</strong> <?php echo $orderSummary['trip_details']['duration']; ?></p>
        </div>
    </div>

    <?php
    // Sertakan file footer
    include 'footer.php';
    ?>

</body>

</html>
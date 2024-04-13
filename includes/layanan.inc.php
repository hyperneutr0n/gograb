<?php
include "dbconn.inc.php";

$sql = "SELECT jenis FROM layanans";
$stmt = mysqli_query($conn, $sql);

if ($stmt) {
  while ($row = mysqli_fetch_array($stmt)) {
    echo "<option>" . $row[0] . "</option>";
  }
} else {
  // Handle error
  echo "<option>No data available</option>";
}

mysqli_close($conn);

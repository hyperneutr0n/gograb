<?php

$arraylayanans = array();
include "dbconn.inc.php";

$sql = "SELECT jenis,tarif FROM layanans";
$stmt = mysqli_query($conn, $sql);

if ($stmt) {
  while ($row = mysqli_fetch_array($stmt)) {
    $arraylayanans[] = array(
      "jenis" => $row["jenis"],
      "tarif" => $row["tarif"]
    );
  }

$_SESSION["layanans"] = $arraylayanans;
} else {
  // Handle error
  echo "<option>No data available</option>";
}

mysqli_close($conn);

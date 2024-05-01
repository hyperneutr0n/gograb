<?php

session_start();

if (!isset($_SESSION["driverLogged"]) || !$_SESSION["driverLogged"]) {
  header("Location: login.php");
  exit();
} else {
  $driverLogged = true;
  require "header.php";
  include "includes/cryptographic.inc.php";
}

$order = isset($_SESSION["order"]) ? $_SESSION["order"] : array();
?>

<div class="container container-login">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <h2 class="text-center mb-4">Order List</h2>
      <table class="table">
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Asal</th>
            <th>Tujuan</th>
            <th>Total</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order as $orderDetails) : ?>
            <form action="includes/updateorder.inc.php" method = "POST">
              <tr>
                <td><?php echo DataDecrypt($orderDetails['id'], $orderDetails['key']); ?></td>
                <td><?php echo $orderDetails['customer_name']; ?></td>
                <td><?php echo DataDecrypt($orderDetails['asal'], $orderDetails['key']); ?></td>
                <td><?php echo DataDecrypt($orderDetails['tujuan'], $orderDetails['key']); ?></td>
                <td><?php echo $orderDetails['total']; ?></td>
                <td><?php echo $orderDetails['notes']; ?></td>
                <td><button type="submit" name="submit">Update</button></td>
              </tr>
              <input type="hidden" name="id" value="<?php echo $orderDetails['id']; ?>">
              <input type="hidden" name="name" value="<?php echo $orderDetails['customer_name']; ?>">
              <input type="hidden" name="asal" value="<?php echo $orderDetails['asal']; ?>">
              <input type="hidden" name="tujuan" value="<?php echo $orderDetails['tujuan']; ?>">
              <input type="hidden" name="total" value="<?php echo $orderDetails['total']; ?>">
              <input type="hidden" name="notes" value="<?php echo $orderDetails['notes']; ?>">
            </form>
          <?php endforeach; ?>
          <?php if (empty($order)) : ?>
            <tr>
              <td colspan="9" class="text-center">No transaction history available.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
</div>

<?php require "footer.php"; ?>
?>
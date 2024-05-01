<?php
session_start();

if (!isset($_SESSION["userLogged"]) || !$_SESSION["userLogged"]) {
    header("Location: login.php");
    exit();
} else {
    $userLogged = true;
    require "header.php";
}

$historyTransaction = isset($_SESSION["historyTransaction"]) ? $_SESSION["historyTransaction"] : array();
?>

<div class="container container-login">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="text-center mb-4">GoGrab Account History</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Payment Method</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historyTransaction as $historyRow) : ?>
                        <form action="invoice.php" method="post">
                        <tr>
                                <td><?php echo $historyRow['id']; ?></td>
                                <td><?php echo $historyRow['tanggal']; ?></td>
                                <td><?php echo $historyRow['asal']; ?></td>
                                <td><?php echo $historyRow['tujuan']; ?></td>
                                <td><?php echo $historyRow['total']; ?></td>
                                <td><?php echo $historyRow['diskon']; ?></td>
                                <td><?php echo $historyRow['payment_method']; ?></td>
                                <td><?php echo $historyRow['notes']; ?></td>
                                <td>
                                    <input type="hidden" name="invoice_id" value="<?php echo $historyRow['encryptedID']; ?>">
                                    <button type="submit" name = "submit" class="btn btn-primary">See Receipt</button>
                                    
                                </td>
                            </tr>
                        </form>
                    <?php endforeach; ?>
                    <?php if (empty($historyTransaction)) : ?>
                        <tr>
                            <td colspan="9" class="text-center">No transaction history available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
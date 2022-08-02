<?php require_once(__DIR__ . "/../../partials/nav.php"); ?>
<?php
$TABLE_NAME = "Orders";
$columns = get_columns($TABLE_NAME);
$results = [];
$db = getDB();
//Get the order and the items in the order
$id = se($_GET, "order_id", -1, false);
$stmt = $db->prepare("SELECT * FROM $TABLE_NAME where id =:id");
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Loading Product Page", "danger");
}
?>
<div class='container-fluid main'>
    <h1>THANKYOU FOR YOUR ORDER, <?php echo get_username() ?> !</h1>
    <h2>Order #<?php se($result, "id"); ?></h2>
    <h3>Date</h3>
    <p><?php se($result, "created"); ?></p>
    <h3>Order Total</h3>
    <p><?php se($result, "total_price"); ?></p>
    <h3>Money Received</h3>
    <p><?php se($result, "money_received"); ?></p>
    <?php if ($result['money_received'] < $result['total_price']) : ?>
        <h3>Money Owed</h3>
        <p><?php $moneyDue = 0;
            $moneyDue = $result['total_price'] - $result['money_received'];
            echo $moneyDue; ?></p>
    <?php endif; ?>
    <h3>Items</h3>
    <?php
    $stmt = $db->prepare("SELECT * FROM OrderItems where order_id =:id");
    try {
        $stmt->execute([":id" => $id]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        error_log(var_export($e, true));
        flash("Error Loading Product Page", "danger");
    }
    ?>
    <table class='table'>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row) : ?>
                <tr>
                    <td><?php se($row, "item_id"); ?></td>
                    <td><?php se($row, "quantity"); ?></td>
                    <td><?php se($row, "unit_price"); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
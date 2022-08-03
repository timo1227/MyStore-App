<?php
require_once(__DIR__ . "/../../../lib/functions.php");
$order_id = $_GET["order_id"];
$OrderTable = "OrderItems";
$db = getDB();
//Get the Order Items from the database
$stmt = $db->prepare("SELECT * FROM $OrderTable JOIN RM_Items ON $OrderTable.item_id = RM_Items.id JOIN Orders ON $OrderTable.order_id = Orders.id where order_id =:order_id");
$items = [];
try {
    $stmt->execute([":order_id" => $order_id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $items = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Orders ", "danger");
}
//send back the data as a json object
error_log(var_export($items, true));
echo json_encode($items);

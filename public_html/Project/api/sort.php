<?php
//Send back the items with the given category
require_once(__DIR__ . "/../../../lib/functions.php");
$price = $_GET["cost"];
//log price
error_log("price: " . $price);
//get DB connection
$TableName = "RM_Items";
$db = getDB();
//get all items with the given category
if ($price == "High->Low") {
    $stmt = $db->prepare("SELECT * FROM $TableName WHERE stock > 0 ORDER BY cost DESC");
} else if ($price == "Low->High") {
    $stmt = $db->prepare("SELECT * FROM $TableName WHERE stock > 0 ORDER BY cost ASC");
}
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//log results
foreach ($results as $item) {
    error_log("Item: " . var_export($item, true));
}
//send back the results
if ($results) {
    echo json_encode($results);
} else {
    flash("No items found", "warning");
}

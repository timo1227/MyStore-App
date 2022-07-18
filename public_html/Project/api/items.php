<?php
//Send back the items with the given category
require_once(__DIR__ . "/../../../lib/functions.php");
$category = $_GET["category"];
//log category
error_log("Category: " . $category);
//get DB connection
$TableName = "RM_Items";
$db = getDB();
//get all items with the given category
$stmt = $db->prepare("SELECT * FROM $TableName WHERE category = :category AND stock > 0");
$stmt->bindParam(":category", $category);
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

<?php
require_once(__DIR__ . "/../../../lib/functions.php");
$order_id = $_GET["order_id"];
$category = $_GET["category"];
$sort = $_GET["sort"];
$OrderTable = "OrderItems";
$query = "SELECT * FROM $OrderTable JOIN RM_Items ON $OrderTable.item_id = RM_Items.id JOIN Orders ON $OrderTable.order_id = Orders.id WHERE order_id =:order_id";
$params = [];
if (!empty($category)) {
    $query .= " AND category = :category";
    $params[":category"] = "$category";
}
if (!empty($sort)) {
    if ($sort == "date_desc") {
        $query .= " ORDER BY created DESC";
    } else if ($sort == "date_asc") {
        $query .= " ORDER BY created ASC";
    } else if ($sort == "high") {
        $query .= " ORDER BY cost DESC";
    } else if ($sort == "low") {
        $query .= " ORDER BY cost ASC";
    }
}
$params[":order_id"] = $order_id;
$db = getDB();
//Get the Order Items from the database
$stmt = $db->prepare($query);
$items = [];
try {
    // $stmt->execute([":order_id" => $order_id]);
    $stmt->execute($params);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $items = $r;
        //get the users_id username and email from the Users table and add it to the items array
        $stmt = $db->prepare("SELECT * FROM Users where id =:user_id");
        try {
            $stmt->execute([":user_id" => $items[0]["user_id"]]);
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $items[0]["username"] = $r["username"];
                $items[0]["email"] = $r["email"];
            }
        } catch (PDOException $e) {
            error_log(var_export($e, true));
            flash("Error Loading Product Page", "danger");
        }
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Orders ", "danger");
}
//send back the data as a json object
echo json_encode($items);

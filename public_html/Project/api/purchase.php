<?php
require_once(__DIR__ . "/../../../lib/functions.php");
error_log("checkout.php received data: " . var_export($_REQUEST, true));
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
$response = ["status" => 400, "message" => "There was a problem completing your purchase"];
http_response_code(400);

//the4 08/01/2022  
//Saving all infomration to the database tables 
$user_id = get_user_id();
$total_price = substr($_POST['total'], 1);
$address = $_POST['full_address'];
$payment_method = $_POST['payment_type'];
$money_received = $_POST['amount'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

if ($user_id > 0) {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Orders (user_id, total_price, address, payment_method, money_received, first_name, last_name) VALUES (:user_id, :total_price, :address, :payment_method, :money_received, :first_name, :last_name)");
    try {
        $stmt->execute([":user_id" => $user_id, ":total_price" => $total_price, ":address" => $address, ":payment_method" => $payment_method, ":money_received" => $money_received, ":first_name" => $first_name, ":last_name" => $last_name]);
        $response["status"] = 200;
        $response["message"] = "Successfully purchased items";
        flash("Successfully purchased items", "success");
        http_response_code(200);
    } catch (PDOException $e) {
        error_log("Error saving order: " . var_export($e, true));
        $response["message"] = "There was a problem completing your purchase";
        http_response_code(400);
    }
} else {
    $response["message"] = "You must be logged in to purchase items";
    http_response_code(400);
    die(json_encode($response));
}
//save order ID
$order_id = $db->lastInsertId();
$response = ["status" => 200, "message" => "Successfully purchased items", "order_id" => $order_id];
error_log("checkout.php response: " . var_export($response, true));

//Get Cart information 
//the4 08/01/2022
$query = "SELECT cart.item_id, cart.id, item.stock, item.name, cart.unit_price, (cart.unit_price * cart.desired_quantity) as subtotal, cart.desired_quantity
FROM RM_Items as item JOIN RM_Cart_Alt as cart on item.id = cart.item_id
 WHERE cart.user_id = :uid";
$db = getDB();
$stmt = $db->prepare($query);
$cart = [];
try {
    $stmt->execute([":uid" => get_user_id()]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($results) {
        $cart = $results;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    $response["message"] = "$e";
    die(json_encode($response));
}

//transfer each cart item to the orderitems table
foreach ($cart as $item) {
    $item_id = $item['item_id'];
    $quantity = $item['desired_quantity'];
    $unit_price = $item['unit_price'];
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO OrderItems (order_id, item_id, quantity, unit_price) VALUES (:order_id, :item_id, :quantity, :unit_price)");
    try {
        $stmt->execute([":order_id" => $order_id, ":item_id" => $item_id, ":quantity" => $quantity, ":unit_price" => $unit_price]);
    } catch (PDOException $e) {
        error_log(var_export($e, true));
        $response["message"] = "$e";
        die(json_encode($response));
    }
    //update the stock of the item 
    $db = getDB();
    $stmt = $db->prepare("UPDATE RM_Items SET stock = stock - :quantity WHERE id = :item_id");
    try {
        $stmt->execute([":quantity" => $quantity, ":item_id" => $item_id]);
    } catch (PDOException $e) {
        error_log(var_export($e, true));
        $response["message"] = "$e";
        die(json_encode($response));
    }
    //remove the item from the cart
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM RM_Cart_Alt WHERE id = :id");
    try {
        $stmt->execute([":id" => $item['id']]);
    } catch (PDOException $e) {
        error_log(var_export($e, true));
        $response["message"] = "$e";
        die(json_encode($response));
    }
}

echo json_encode($response);

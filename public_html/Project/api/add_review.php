<?php
require_once(__DIR__ . "/../../../lib/functions.php");
error_log("add_review.php received data: " . var_export($_REQUEST, true));
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
// Check if user already Posted a review for this item
$user_id = get_user_id();
$item_id = $_POST['item_id'];
$db = getDB();
$stmt = $db->prepare("SELECT * FROM Ratings WHERE user_id = :uid AND item_id = :iid");
try {
    $stmt->execute([":uid" => $user_id, ":iid" => $item_id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    $response = ["status" => 400, "message" => "Error getting review"];
    flash("Error Posting Rating", "danger");
    die(json_encode($response));
}
//Check is $results is empty
if (empty($result)) {
    // Add review to Ratings table
    $stmt = $db->prepare("INSERT INTO Ratings (user_id, item_id, rating, comment) VALUES (:uid, :iid, :rating, :comment)");
    try {
        $stmt->execute([":uid" => $user_id, ":iid" => $item_id, ":rating" => $_POST['rating'], ":comment" => $_POST['comment']]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        $response = ["status" => 200, "message" => "Review added"];
        if ($r) {
            $result = $r;
        }
    } catch (PDOException $e) {
        error_log(var_export($e, true));
        flash("Error Posting Rating", "danger");
    }
} else {
    // Notify user that they have already posted a review for this item
    $response = ["status" => 400, "message" => "You have already posted a review for this item"];
}

//Get the average rating for the item
$stmt = $db->prepare("SELECT AVG(rating) AS average FROM Ratings WHERE item_id = :iid");
try {
    $stmt->execute([":iid" => $item_id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Posting Rating", "danger");
}
//Update the average rating for the item on RM_Items table
$stmt = $db->prepare("UPDATE RM_Items SET average_rating = :ar WHERE id = :iid");
try {
    $stmt->execute([":ar" => $result['average'], ":iid" => $item_id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Posting Rating", "danger");
}


error_log(var_export($response, true));
echo json_encode($response);

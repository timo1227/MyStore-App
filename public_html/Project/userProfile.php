<!-- Get User ID -->
<?php
require_once(__DIR__ . "/../../partials/nav.php");
$profileId = se($_GET, "id", -1, false);
//SELECT USERNAME AND EMAIL AND PROFILE FROM USER TABLE
$sql = "SELECT username, email, profile FROM Users WHERE id = $profileId";
$db = getDB();
$stmt = $db->prepare($sql);
try {
    $stmt->execute();
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $username = $r["username"];
        $email = $r["email"];
        $profile = $r["profile"];
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Loading Profile Page", "danger");
}

//Get ALL OF PROFILE'S REVIEWS
$sql = "SELECT * FROM Ratings JOIN RM_Items ON Ratings.item_id = RM_Items.id WHERE user_id = $profileId";
$stmt = $db->prepare($sql);
$reviews = [];
try {
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $reviews = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Loading Profile Page", "danger");
}
?>
<!-- Display Profile Information -->
<div class="container-fluid main">
    <div class="profile">
        <h1>Profile</h1>
        <div class="profile_info">
            <h3>Username: <?php echo $username; ?></h3>
            <?php if ($profile == "Public") : ?>
                <h3>Email: <?php echo $email; ?></h3>
            <?php endif; ?>
        </div>
    </div>
    <div class="profile_reviews">
        <h1>Reviews</h1>
        <?php if (count($reviews) > 0) : ?>
            <?php foreach ($reviews as $review) : ?>
                <div class="ReviewCard">
                    <h5>Item: <a class="ReviewTitle" href="product_page.php?id=<?php se($review, "item_id") ?>"> <?php se($review, "name") ?></a></h5>
                    <div class="Review">
                        <p>Rating: <?php se($review, "rating"); ?> / 5</p>
                        <p class="user_review"><?php se($review, "comment"); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <h3>No User Reviews</h3>
        <?php endif; ?>
    </div>
</div>
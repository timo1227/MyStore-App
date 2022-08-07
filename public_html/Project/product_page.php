<?php require_once(__DIR__ . "/../../partials/nav.php"); ?>
<?php
$TABLE_NAME = "RM_Items";
$columns = get_columns($TABLE_NAME);
$results = [];
$ignore = ["id", "modified", "created"];
$db = getDB();
//get the item
$id = se($_GET, "id", -1, false);
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

//Check if user has purchased the item before
$purchased = false;
if (is_logged_in()) {
    $stmt = $db->prepare("SELECT * FROM Orders where user_id =:user_id");
    try {
        $stmt->execute([":user_id" => get_user_id()]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $orders = $r;
        }
        // Check each order_id to see if the item is in the orderItems table
        foreach ($orders as $order) {
            $stmt = $db->prepare("SELECT * FROM OrderItems where order_id =:order_id");
            try {
                $stmt->execute([":order_id" => $order["id"]]);
                $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($r) {
                    $orderItems = $r;
                }
                // Check each orderItem to see if the item is in the item table
                foreach ($orderItems as $orderItem) {
                    if ($orderItem["item_id"] == $id) {
                        $purchased = true;
                    }
                }
            } catch (PDOException $e) {
                error_log(var_export($e, true));
                flash("Error Loading Previous Orders", "danger");
            }
        }
    } catch (PDOException $e) {
        error_log(var_export($e, true));
        flash("Error Loading Product Page", "danger");
    }
}


// Get all Reviews for the item
$reviews = [];
$stmt = $db->prepare("SELECT * FROM Ratings where item_id =:item_id");
try {
    $stmt->execute([":item_id" => $id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $reviews = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Loading Product Page", "danger");
}
// Get the average rating for the item
$avgRating = $result["average_rating"];
//Limit Decimal Places 
$avgRating = round($avgRating, 1);
$numReviews = 0;
foreach ($reviews as $review) {
    $numReviews++;
}
?>
<!-- Parse through Results -->
<script>
    function addCart(form) {
        add_to_cart('<?php se($result, 'id'); ?>', form.desired_quantity.value)
        return false;
    }
</script>

<div class="container-fluid main">
    <h1 style="display:none ;"><?php se($result, "name", false) ?> Product Page</h1>
    <div class='main_body'>
        <div class="image_container">
            <img class="center" src="<?php se($result, 'image') ?>" alt="Product Picture">
        </div>
        <div class="info">
            <h1 class="name"><?php se($result, "name"); ?></h1>
            <div class="price">
                <p>$<?php se($result, "cost"); ?></p>
            </div>
            <?php if (se($result, "description", "", false)) : ?>
                <p><?php se($result, "description"); ?></p>
            <?php endif; ?>
        </div>
        <div class="cart_action">
            <a id="Rating" href="#Reviews">
                <h6>Rating: <?php se($avgRating, true) ?> (<?php se($numReviews, true) ?>)</h6>
            </a>
            <form method="POST" class="QuantityForm" onsubmit="return addCart(this);">
                <input type="hidden" name="item_id" value="<?php se($result, "id"); ?>" />
                <input type="hidden" name="action" value="add" />
                <input type="number" name="desired_quantity" value="1" min="0" />
                <input type="submit" id='Active_Button' value="Add to Cart" />
            </form>
        </div>
    </div>
    <div class="footer">
        <div class="admin">
            <?php if (has_role("Admin")) : ?>
                <h3>Stock</h3>
                <p><?php se($result, "stock"); ?></p>
                <button class="admin"><a href="admin/edit_item.php?id=<?php se($result, "id"); ?>">Edit Item</a></button>
            <?php endif; ?>
        </div>
        <div id="Reviews" class="CustomerReviews">
            <div class="AddReview">
                <?php if ($purchased) : ?>
                    <h4>Add a Review</h4>
                    <form method="POST" class='center ReviewForm' onsubmit="return addReview(this);">
                        <input type="hidden" name="item_id" value="<?php se($result, "id"); ?>" />
                        <label for="rate">Rating</label>
                        <input class="rating" name="rating" max="5" step="1" type="range" value="1" />
                        <textarea value="Your Review Here" name="review"></textarea>
                        <input class="btn" type="submit" id='Active_Button' value="Add Review" />
                    </form>
                <?php endif; ?>
            </div>
            <h3>Customer Reviews</h3>
            <?php if (!empty($reviews)) : ?>
                <?php foreach ($reviews as $review) : ?>
                    <div class="Review">
                        <p>Rating: <?php se($review, "rating"); ?></p>
                        <p>Review: <?php se($review, "comment"); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No Reviews</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    function addReview(form) {
        add_review('<?php se($result, 'id'); ?>', form.rating.value, form.review.value)
        return false;
    }
</script>
<style>
    .QuantityForm {
        margin: 0;
        width: 70%;
    }

    .QuantityForm input {
        text-align: center;
    }

    .ReviewForm {
        width: 100%;
        max-width: 60%;
    }

    .ReviewForm>.btn {
        display: block;
        margin: auto;
        max-width: 75%;
    }

    .main_body {
        display: grid;
        grid-template-areas: "info image cart_action";
        grid-template-columns: 25% 50% 25%;
        margin-top: 20px;
    }

    .image_container {
        grid-area: image;
        width: 100%;
        height: auto;
        max-width: 700px;
        margin: 0 auto;
    }

    .info {
        grid-area: info;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 500px;
    }

    .name {
        text-align: center;
        width: 100%;
        font-size: 2em;
        font-weight: bold;
    }

    .price {
        font-size: 1em;
    }

    .admin {
        width: 100%;
    }

    .cart_action {
        grid-area: cart_action;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .footer {
        grid-area: decription;
        margin-top: 20px;
        width: 100%;
    }

    .image_container img {
        border-radius: 10px;
    }

    textarea {
        width: 100%;
        min-height: 200px;
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 10px;
        font-size: 1em;
        margin-bottom: 10px;
    }

    #Rating {
        text-decoration: none;
        color: gray;
    }
</style>
<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
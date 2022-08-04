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
?>
<!-- Parse through Results -->
<script>
    function addCart(form) {
        add_to_cart('<?php se($result, 'id'); ?>', form.desired_quantity.value)
        return false;
    }
</script>

<div class='container-fluid main'>
    <div class="image_container">
        <img src="<?php se($result, 'image') ?>" alt="Product Picture">
    </div>
    <div class="info">
        <h1 class="name"><?php se($result, "name"); ?></h1>
        <div class="price">
            <p>$<?php se($result, "cost"); ?></p>
        </div>
    </div>
    <div class="cart_action">
        <form method="POST" class='quickAdd' onsubmit="return addCart(this);">
            <input type="hidden" name="item_id" value="<?php se($result, "id"); ?>" />
            <input type="hidden" name="action" value="add" />
            <input type="number" name="desired_quantity" value="1" min="0" />
            <input type="submit" id='Active_Button' value="Add to Cart" />
        </form>
    </div>
    <div class="footer">
        <div class="admin">
            <?php if (has_role("Admin")) : ?>
                <h3>Stock</h3>
                <p><?php se($result, "stock"); ?></p>
                <button class="admin"><a href="admin/edit_item.php?id=<?php se($result, "id"); ?>">Edit Item</a></button>
            <?php endif; ?>
        </div>
        <?php if (se($result, "description", "", false)) : ?>
            <h3>description</h3>
            <p><?php se($result, "description"); ?></p>
        <?php endif; ?>
        <h3>Customer Reviews</h3>
        <div class="CustomerReviews">
            <?php if (se($result, "reviews", "", false)) : ?>
                <p><?php se($result, "reviews"); ?></p>
            <?php else : ?>
                <p>No Reviews</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<style>
    .main {
        display: grid;
        grid-template-areas: "info image cart_action"
            "decription description description";
        margin-top: 20px;
    }

    .image_container {
        grid-area: image;
        width: 100%;
        height: auto;
        max-width: 500px;
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
</style>
<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
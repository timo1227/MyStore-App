<?php
require(__DIR__ . "/../../partials/nav.php");

if (!is_logged_in(true)) {
    die(header("Location: $BASE_PATH/login.php"));
}

$action = strtolower(trim(se($_POST, "action", "", false)));
if (!empty($action)) {
    $db = getDB();
    switch ($action) {
        case "add":
            $query = "INSERT INTO RM_Cart_Alt (item_id, desired_quantity, unit_price, user_id)
            VALUES (:iid, :dq, (SELECT cost FROM RM_Items where id = :iid), :uid) ON DUPLICATE KEY UPDATE
            desired_quantity = desired_quantity + :dq";
            $stmt = $db->prepare($query);
            $stmt->bindValue(":iid", se($_POST, "item_id", 0, false), PDO::PARAM_INT);
            $stmt->bindValue(":dq", se($_POST, "desired_quantity", 0, false), PDO::PARAM_INT);
            $stmt->bindValue(":uid", get_user_id(), PDO::PARAM_INT);
            try {
                $stmt->execute();
                flash("Added item to cart", "success");
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 3819) {
                    flash("Quantity greater than 0 must be added to Cart", "warning");
                } else {
                    flash("Error adding item to cart", "danger");
                    echo $e->getMessage();
                    error_log(var_export($e, true));
                }
            }
            break;
        case "update":
            $query = "UPDATE RM_Cart_Alt set desired_quantity = :dq WHERE id = :cid AND user_id = :uid";
            $stmt = $db->prepare($query);
            $stmt->bindValue(":dq", se($_POST, "desired_quantity", 0, false), PDO::PARAM_INT);
            //cart id specifies a specific cart item
            $stmt->bindValue(":cid", se($_POST, "cart_id", 0, false), PDO::PARAM_INT);
            //user id ensures we can only edit our cart
            $stmt->bindValue(":uid", get_user_id(), PDO::PARAM_INT);
            try {
                $stmt->execute();
                flash("Updated item quantity", "success");
            } catch (PDOException $e) {
                //TODO handle item removal when desired_quantity is <= 0
                //TODO handle any other update related rules per your proposal
                error_log(var_export($e, true));
                flash("Enter Valid Quantity", "danger");
            }
            break;
        case "delete":
            //TODO you do this part
            $query = "DELETE FROM RM_Cart_Alt WHERE id = :cid AND user_id = :uid";
            $stmt = $db->prepare($query);
            $stmt->bindValue(":cid", se($_POST, "cart_id", 0, false), PDO::PARAM_INT);
            $stmt->bindValue(":uid", get_user_id(), PDO::PARAM_INT);
            try {
                $stmt->execute();
                flash("Removed item from cart", "success");
            } catch (PDOException $e) {
                error_log(var_export($e, true));
                flash("Error removing item from cart", "danger");
            }
            break;

        case "delete_all":
            $query = "DELETE FROM RM_Cart_Alt WHERE user_id = :uid";
            $stmt = $db->prepare($query);
            $stmt->bindValue(":uid", get_user_id(), PDO::PARAM_INT);
            try {
                $stmt->execute();
                flash("Removed all items from cart", "success");
            } catch (PDOException $e) {
                error_log(var_export($e, true));
                flash("Error removing all items from cart", "danger");
            }
            break;
    }
}
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
    flash("Error fetching cart", "danger");
}
?>

<div class="container-fluid">
    <h1>Cart</h1>
    <table class="table table-striped">
        <?php $total = 0; ?>
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $c) : ?>
                <tr>
                    <td> <a href="product_page.php?id=<?php se($c, "item_id"); ?>" target=_blank><?php se($c, "name"); ?></a></td>
                    <td><?php se($c, "unit_price"); ?></td>
                    <td>
                        <form method="POST" style="margin:0 auto">
                            <input type="hidden" name="cart_id" value="<?php se($c, "id"); ?>" />
                            <input type="hidden" name="action" value="update" />
                            <input type="number" name="desired_quantity" value="<?php se($c, "desired_quantity"); ?>" min="0" max="<?php se($c, "stock"); ?>" />
                            <input type="submit" class="btn btn-primary" value="Update Quantity" />
                        </form>
                    </td>
                    <?php $total += (int)se($c, "subtotal", 0, false); ?>
                    <td><?php se($c, "subtotal"); ?></td>
                    <td>
                        <form method="POST" style="margin: 0 auto">
                            <input type="hidden" name="cart_id" value="<?php se($c, "id"); ?>" />
                            <input type="hidden" name="action" value="delete" />
                            <input type="submit" class="btn btn-danger" value="x" />
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($cart) == 0) : ?>
                <tr>
                    <td colspan="100%">No items in cart</td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="100%">Total: <?php se($total, null, 0); ?></td>
            </tr>
        </tbody>
    </table>
    <div class='after_cart'>
        <!-- Remove All Items from Cart -->
        <form method="POST" class='quickRemove' style="margin: 0 auto">
            <input type="hidden" name="action" value="delete_all" />
            <p>Clear Cart</p>
            <input type="submit" class="btn btn-danger" value="x" />
        </form>
        <a href="checkout.php"><button class="btn btn-primary">Checkout</button></a>
    </div>
</div>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>
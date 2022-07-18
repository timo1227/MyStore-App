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
    <h1><?php se($result, "name"); ?></h1>
    <img src="<?php se($result, 'image') ?>" alt="Product Picture">
    <h3>Price</h3>
    <p><?php se($result, "cost"); ?></p>
    <form method="POST" class='quickAdd' onsubmit="return addCart(this);">
        <input type="hidden" name="item_id" value="<?php se($result, "id"); ?>" />
        <input type="hidden" name="action" value="add" />
        <input type="number" name="desired_quantity" value="1" min="0" />
        <input type="submit" id='Active_Button' value="Add to Cart" />
    </form>
    <?php if (se($result, "description", "", false)) : ?>
        <h3>description</h3>
        <p><?php se($result, "description"); ?></p>
    <?php endif; ?>

</div>
<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
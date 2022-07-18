<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: $BASE_PATH/home.php"));
}
if (isset($_POST["submit"])) {
    flash('Item Would Be Added to Cart In Normal Shop View', 'success');
}

$results = [];
$db = getDB();
$stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock >= 0 LIMIT 50");
try {
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $results = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error fetching items", "danger");
}
?>

<div class="container-fluid main">
    <h1>Shop</h1>
    <div class="cards">
        <?php foreach ($results as $item) : ?>
            <div class="col">
                <div class="card bg-light">
                    <?php if (se($item, "image", "", false)) : ?>
                        <a href="../product_page.php?id=<?php se($item, "id"); ?>">
                            <img src="<?php se($item, "image"); ?>" class="card-img-top" alt="...">
                        </a>
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?php se($item, "name"); ?></h5>
                        <div class="card-footer">
                            Cost: <?php se($item, "cost"); ?>
                            <form method="POST" class='quickAdd'>
                                <input type="hidden" name="item_id" value="<?php se($item, "id"); ?>" />
                                <input type="hidden" name="action" value="add" />
                                <input type="hidden" name="desired_quantity" value="1" />
                                <input type="submit" id='Active_Button' value="Quick Add" name="submit" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once(__DIR__ . "/../../../partials/flash.php"); ?>
<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<?php
// if (is_logged_in(true)) {
//     error_log("Session data: " . var_export($_SESSION, true));
// }
$results = [];
$db = getDB();
if (!is_logged_in()) {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock > 0 LIMIT 10");
} else {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock > 0 LIMIT 50");
}
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
<div id='main' class="container-fluid main">
    <h1>Shop</h1>
    <div class="Options">
        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Filters
        </a>
        <ul class="dropdown-menu" aria-labelledby="FilterDropdown">
            <li><a class="dropdown-item" onclick="filter('mens')">Men</a></li>
            <li><a class="dropdown-item" onclick="filter('womens')">Women</a></li>
        </ul>
        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sort
        </a>
        <ul class="dropdown-menu" aria-labelledby="FilterDropdown">
            <li><a class="dropdown-item" onclick="sort('High->Low')">High->Low</a></li>
            <li><a class="dropdown-item" onclick="sort('Low->High')">Low->High</a></li>
        </ul>
    </div>
    <div id='cards' class="cards">
        <?php foreach ($results as $item) : ?>
            <div class="col">
                <div class="card bg-light">
                    <?php if (se($item, "image", "", false)) : ?>
                        <a href="product_page.php?id=<?php se($item, "id"); ?>">
                            <img src="<?php se($item, "image"); ?>" class="card-img-top" alt="...">
                        </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php se($item, "name"); ?></h5>
                        <div class="card-footer">
                            Cost: <?php se($item, "cost"); ?>
                            <button onclick="add_to_cart('<?php se($item, 'id'); ?>')" class="quickAddBtn" id="Active_Button">Quick Add</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
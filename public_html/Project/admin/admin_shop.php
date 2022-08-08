<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: $BASE_PATH/home.php"));
}
$results = [];
$db = getDB();
if (!is_logged_in()) {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock >= 0 LIMIT 12");
} else {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock >= 0");
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

//Check Sort
$sort = isset($_GET['sort']) ? $_GET['sort'] : "";
if ($sort == "high") {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock >= 0 ORDER BY cost DESC");
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
} elseif ($sort == "low") {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock >= 0 ORDER BY cost ASC");
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
} elseif ($sort == "avg_rating_desc") {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock >= 0 ORDER BY average_rating DESC");
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
} elseif ($sort == "avg_rating_asc") {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock >= 0 ORDER BY average_rating ASC");
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
} else if ($sort == "OOS") {
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock = 0");
    try {
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Check for no results
        if (!$r) {
            flash("No items are out of stock", "info");
        } else {
            $results = $r;
        }
    } catch (PDOException $e) {
        error_log(var_export($e, true));
        flash("Error fetching items", "danger");
    }
}

// Creat Pagination for the items
$total_items = count($results);
$items_per_page = 12;
$total_pages = ceil($total_items / $items_per_page);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;
$results = array_slice($results, $offset, $items_per_page);
?>
<div id='main' class="container-fluid main">
    <h1>Admin Shop View</h1>
    <div class="Options">
        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Filters
        </a>
        <ul class="dropdown-menu" aria-labelledby="FilterDropdown">
            <li><a class="dropdown-item" href="../mens-new.php?page=1&sort=manual"">Men</a></li>
            <li><a class=" dropdown-item" href="../womens-new.php?sort=manual"">Women</a></li>
            <li><a class=" dropdown-item" onclick="filter('OOS')">Out of Stock</a></li>
        </ul>
        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sort
        </a>
        <ul class="dropdown-menu" aria-labelledby="FilterDropdown">
            <li><a class="dropdown-item" onclick="sort('High->Low')">Price:High-Low</a></li>
            <li><a class="dropdown-item" onclick="sort('Low->High')">Price:Low-High</a></li>
            <li><a class="dropdown-item" onclick="sort('avg_desc')">Rating:High-Low</a></li>
            <li><a class="dropdown-item" onclick="sort('avg_asc')">Rating:Low-High</a></li>
        </ul>
    </div>
    <div id='cards' class="cards">
        <?php foreach ($results as $item) :
            $itemStock = se($item, "stock", "", false); ?>
            <div <?php if ($itemStock == 0) : ?> style="border: 2px solid red; border-radius:10px ;" <?php endif; ?> class="col">
                <div class="card bg-light">
                    <?php if (se($item, "image", "", false)) : ?>
                        <div class="imgSlide">
                            <div class="card-footer">
                                <button onclick="flash('Item Would Have Been Added To Cart In Normal Shop View','info')" class="btn btn-primary btn-lg quickAddBtn">Add to Cart</button>
                            </div>
                            <a href="../product_page.php?id=<?php se($item, "id"); ?>">
                                <img src="<?php se($item, "image"); ?>" class="card-img-top" alt="...">
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php se($item, "name"); ?></h5>
                        Cost: $<?php se($item, "cost"); ?>
                        <?php if ($itemStock == 0) : ?>
                            <p class="red-color">Out Stock</p>
                        <?php endif; ?>
                        <?php if ($itemStock < 10) : ?>
                            <p class="red-color">Low Stock</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="footer">
        <!-- Change Page Number -->
        <?php if ($total_pages > 1) : ?>
            <ul class="pagination">
                <?php if ($current_page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&sort=<?php echo $sort; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($current_page == $i) : ?>active<?php endif; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($current_page < $total_pages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&sort=<?php echo $sort; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php require_once(__DIR__ . "/../../../partials/flash.php"); ?>
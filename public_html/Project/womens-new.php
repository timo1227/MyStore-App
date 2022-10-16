<?php
require(__DIR__ . "/../../partials/nav.php");
$results = [];
$db = getDB();
$category = 'womens';
if (!is_logged_in()) {
    $stmt = $db->prepare("SELECT * FROM RM_Items WHERE category = :category AND stock > 0 LIMIT 12");
    $stmt->bindParam(":category", $category);
} else {
    $stmt = $db->prepare("SELECT * FROM RM_Items WHERE category = :category AND stock > 0");
    $stmt->bindParam(":category", $category);
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
    $stmt = $db->prepare("SELECT * FROM RM_Items WHERE category = :category AND stock > 0 ORDER BY cost DESC");
    $stmt->bindParam(":category", $category);
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
    $stmt = $db->prepare("SELECT * FROM RM_Items WHERE category = :category AND stock > 0 ORDER BY cost ASC");
    $stmt->bindParam(":category", $category);
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
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock > 0 ORDER BY average_rating DESC");
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
    $stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM RM_Items WHERE stock > 0 ORDER BY average_rating ASC");
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
    <h1>Women's Shop</h1>
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
            <li><a class="dropdown-item" onclick="sort('avg_desc')">Rating:High-Low</a></li>
            <li><a class="dropdown-item" onclick="sort('avg_asc')">Rating:Low-High</a></li>
        </ul>
    </div>
    <div id='cards' class="cards">
        <?php foreach ($results as $item) : ?>
            <div class="col">
                <div class="card bg-light">
                    <?php if (se($item, "image", "", false)) : ?>
                        <div class="imgSlide">
                            <div class="card-footer">
                                <button onclick="add_to_cart('<?php se($item, 'id'); ?>')" class="btn btn-primary btn-lg quickAddBtn">Add to Cart</button>
                            </div>
                            <a href="product_page.php?id=<?php se($item, "id"); ?>">
                                <img src="<?php se($item, "image"); ?>" class="card-img-top" alt="...">
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php se($item, "name"); ?></h5>
                        <span class="Cost">Cost: $<?php se($item, "cost"); ?></span>
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
<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
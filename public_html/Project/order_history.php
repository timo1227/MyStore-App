<?php require_once(__DIR__ . "/../../partials/nav.php");
$OrderTable = "Orders";
$db = getDB();
$user_id = get_user_id();
//Get All Orders from the database of the User
// $stmt = $db->prepare("SELECT * FROM $OrderTable where user_id =:user_id LIMIT 10");
// try {
//     $stmt->execute([":user_id" => $user_id]);
//     $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     if ($r) {
//         $results = $r;
//     }
// } catch (PDOException $e) {
//     error_log(var_export($e, true));
//     flash("Error Orders ", "danger");
// }
//
$query = "SELECT * FROM $OrderTable where user_id =:user_id";
$params = [];
$category = isset($_GET['category']) ? $_GET['category'] : "";
$sort = isset($_GET['sort']) ? $_GET['sort'] : "";
// if (!empty($category)) {
//     $query .= " AND category = :category";
//     $params[':category'] = $category;
// }
if (!empty($sort)) {
    if ($sort == "date_desc") {
        $query .= " ORDER BY created DESC";
    } else if ($sort == "date_asc") {
        $query .= " ORDER BY created ASC";
    } else if ($sort == "high") {
        $query .= " ORDER BY total_price DESC";
    } else if ($sort == "low") {
        $query .= " ORDER BY total_price ASC";
    }
}
$params[':user_id'] = $user_id;
$stmt = $db->prepare($query);
try {
    $stmt->execute($params);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $results = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Orders ", "danger");
}

// Pagination 
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = 5;
$total_count = count($results);
$total_pages = ceil($total_count / $per_page);
$offset = ($current_page - 1) * $per_page;
$results = array_slice($results, $offset, $per_page);

?>

<!-- Orders IN table Form -->
<div id="RecentOrders" class='container-fluid main'>
    <h1>Orders</h1>
    <div class="Options">
        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Filters
        </a>
        <ul class="dropdown-menu" aria-labelledby="FilterDropdown">
            <li><a class="dropdown-item" onclick="category('')">None</a></li>
            <li><a class="dropdown-item" onclick="category('mens')">Men</a></li>
            <li><a class="dropdown-item" onclick="category('womens')">Women</a></li>
        </ul>
        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sort
        </a>
        <ul class="dropdown-menu" aria-labelledby="FilterDropdown">
            <li><a class="dropdown-item" onclick="sort('High->Low')">Total:High-Low</a></li>
            <li><a class="dropdown-item" onclick="sort('Low->High')">Total:Low-High</a></li>
            <li><a class="dropdown-item" onclick="sort('date_desc')">Date:Newest</a></li>
            <li><a class="dropdown-item" onclick="sort('date_asc')">Date:Oldest</a></li>
        </ul>
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Total Price</th>
                <th>Items</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row) : ?>
                <tr>
                    <td><?php se($row, "id"); ?></td>
                    <td><?php se($row, "created"); ?></td>
                    <td><?php se($row, "total_price"); ?></td>
                    <td><a class="ToogleView" href="order_history.php?order_id=<?php se($row, "id"); ?>&sort=<?php se($sort, true) ?>&category=<?php se($category, true) ?>">View Items</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="footer">
        <ul class="pagination">
            <?php if ($current_page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="order_history.php?page=<?php echo $current_page - 1; ?>&sort=<?php se($sort, true) ?>&category=<?php se($category, true) ?>">Previous</a>
                </li>
            <?php endif; ?>
            <?php if ($total_pages > 1) :
                for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($current_page == $i) ? "active" : ""; ?>">
                        <a class="page-link" href="order_history.php?page=<?php echo $i; ?>&sort=<?php se($sort, true) ?>&category=<?php se($category, true) ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            <?php endif; ?>
            <?php if ($current_page < $total_pages) : ?>
                <li class="page-item">
                    <a class="page-link" href="order_history.php?page=<?php echo $current_page + 1; ?>&sort=<?php se($sort, true) ?>&category=<?php se($category, true) ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<!-- Order Items -->
<div id="OrderTable" class='container-fluid main' style="display:none">
    <div id="OrderItems"></div>
</div>
<script>
    let ToggleView = document.querySelectorAll(".ToogleView");
    Array.from(ToggleView).forEach(function(element) {
        element.addEventListener("click", function(e) {
            e.preventDefault();
            //Toggle Table View
            $("#RecentOrders").toggle();
            $("#OrderTable").toggle();
            console.log(e.target.href);
            let order_id = e.target.getAttribute("href").split("=")[1];
            let url = "order_history.php?order_id=" + order_id;
            let sort = e.target.getAttribute("href").split("&")[1].split("=")[1];
            let category = e.target.getAttribute("href").split("&")[2].split("=")[1];
            //Get the Order Items from the database
            $.ajax({
                url: "/Project/api/orders.php?order_id=" + order_id + "&category=" + category + "&sort=" + sort,
                method: "GET",
            }).done(function(data) {
                let order_items = JSON.parse(data);
                if (order_items.length == 0) {
                    $("#OrderItems").html(`<h1>No Items Matching Category - ${category} </h1>`);
                } else {
                    let ShippingHeader = document.createElement("h2");
                    ShippingHeader.innerHTML = "Shipping Info";
                    document.getElementById("OrderItems").appendChild(ShippingHeader);
                    let ShippingInfo = document.createElement("p");
                    ShippingInfo.innerHTML = "Name: " + order_items[0].first_name + " " + order_items[0].last_name + "<br>Address: " + order_items[0].address;
                    document.getElementById("OrderItems").appendChild(ShippingInfo);
                    let OrderTotalHeader = document.createElement("h2");
                    OrderTotalHeader.innerHTML = "Order Total";
                    document.getElementById("OrderItems").appendChild(OrderTotalHeader);
                    let OrderTotal = document.createElement("p");
                    OrderTotal.innerHTML = "Total: $" + order_items[0].total_price;
                    document.getElementById("OrderItems").appendChild(OrderTotal);
                    let OrderItemsHeader = document.createElement("h2");
                    OrderItemsHeader.innerHTML = "Order Items";
                    document.getElementById("OrderItems").appendChild(OrderItemsHeader);
                    let order_items_table = document.createElement("table");
                    order_items_table.classList.add("table");
                    let order_items_thead = document.createElement("thead");
                    let order_items_tbody = document.createElement("tbody");
                    let order_items_tr = document.createElement("tr");
                    let order_items_th = document.createElement("th");
                    order_items_th.innerText = "Item";
                    order_items_tr.appendChild(order_items_th);
                    let order_items_th2 = document.createElement("th");
                    order_items_th2.innerText = "Price";
                    order_items_tr.appendChild(order_items_th2);
                    order_items_thead.appendChild(order_items_tr);
                    order_items_table.appendChild(order_items_thead);
                    order_items_table.appendChild(order_items_tbody);
                    let order_items_th3 = document.createElement("th");
                    order_items_th3.innerText = "Quantity";
                    order_items_tr.appendChild(order_items_th3);
                    order_items_thead.appendChild(order_items_tr);
                    order_items_table.appendChild(order_items_thead);
                    order_items_table.appendChild(order_items_tbody);
                    for (let i = 0; i < order_items.length; i++) {
                        let order_items_tr = document.createElement("tr");
                        let order_items_td = document.createElement("td");
                        order_items_td.innerText = order_items[i].name;
                        order_items_tr.appendChild(order_items_td);
                        let order_items_td2 = document.createElement("td");
                        order_items_td2.innerText = order_items[i].unit_price;
                        order_items_tr.appendChild(order_items_td2);
                        order_items_tbody.appendChild(order_items_tr);
                        let order_items_td3 = document.createElement("td");
                        order_items_td3.innerText = order_items[i].quantity;
                        order_items_tr.appendChild(order_items_td3);
                        order_items_tbody.appendChild(order_items_tr);
                    }
                    document.querySelector("#OrderItems").appendChild(order_items_table);
                }
                //Create a button to go back to the Order History
                let goBack = document.createElement("button");
                goBack.innerText = "Go Back";
                goBack.addEventListener("click", function(e) {
                    $("#RecentOrders").toggle();
                    $("#OrderTable").toggle();
                    //delte the table
                    document.querySelector("#OrderItems").innerHTML = "";
                });
                document.querySelector("#OrderItems").appendChild(goBack);
            }).fail(function(data) {
                console.log(data);
            });
        });
    });
</script>
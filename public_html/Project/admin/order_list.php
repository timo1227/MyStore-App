<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: $BASE_PATH/home.php"));
}
//Get all Orders and Items from the database
$OrderTable = "Orders";
$OrderItemsTable = "OrderItems";
$db = getDB();
//Get the Orders from the database
$stmt = $db->prepare("SELECT * FROM $OrderTable LIMIT 10");
$orders = [];
try {
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $orders = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Orders ", "danger");
}

//Get username from the database
$stmt = $db->prepare("SELECT * FROM Users where id =:user_id");
$user_id = $orders[0]["user_id"];
try {
    $stmt->execute([":user_id" => $user_id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $user = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error Orders ", "danger");
}
// save username to variable
$username = $user[0]["username"];
$user_email = $user[0]["email"];
?>
<!-- Search For Order -->

<!-- Table of Orders -->
<div id="RecentOrders" class='container-fluid main'>
    <h1>Customer Orders</h1>
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
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?php se($order, "id"); ?></td>
                    <td><?php se($order, "created"); ?></td>
                    <td><?php se($order, "total_price"); ?></td>
                    <td><a class="ToogleView" href="order_history.php?order_id=<?php se($order, "id"); ?>">View Items</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Order Items -->
<div id="OrderTable" class='container-fluid main' style="display:none">
    <h2>User Info</h2>
    <p> <?php echo $username ?> </p>
    <p> <?php echo $user_email ?> </p>
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
            let order_id = e.target.getAttribute("href").split("=")[1];
            let url = "order_history.php?order_id=" + order_id;
            //Get the Order Items from the database
            $.ajax({
                url: "/Project/api/orders.php?order_id=" + order_id,
                method: "GET",
            }).done(function(data) {
                let order_items = JSON.parse(data);
                console.log(order_items);
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
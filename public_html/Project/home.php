<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<link rel="stylesheet" href="Styles/form.css">
<link rel="stylesheet" href="Styles/nav.css">
<h1>Home</h1>
<?php
if (isset($_SESSION["user"]) && isset($_SESSION["user"]["email"])) {
    echo "Welcome, " . $_SESSION["user"]["email"];
} else {
    echo "You're not logged in";
}
?>
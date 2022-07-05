<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<link rel="stylesheet" href="Styles/form.css">
<link rel="stylesheet" href="Styles/nav.css">
<h1>Home</h1>
<?php
if (is_logged_in()) {
    echo "Welcome, " . get_user_email() . "!";
} else {
    echo "You're not logged in";
}
?>
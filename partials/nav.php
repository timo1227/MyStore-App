<?php
require_once(__DIR__ . "/../lib/functions.php");
if (file_exists('/app/vendor/autoload.php')) {
    require_once('/app/vendor/autoload.php');
    // Make MemCachier connection
    // ==========================

    // parse config
    $servers = explode(",", getenv("MEMCACHIER_SERVERS"));
    for ($i = 0; $i < count($servers); $i++) {
        $servers[$i] = explode(":", $servers[$i]);
    }

    // Using Memcached client (recommended)
    // ------------------------------------
    $m = new Memcached("memcached_pool");
    $m->setOption(Memcached::OPT_BINARY_PROTOCOL, TRUE);
    // Enable no-block for some performance gains but less certainty that data has
    // been stored.
    $m->setOption(Memcached::OPT_NO_BLOCK, TRUE);
    // Failover automatically when host fails.
    $m->setOption(Memcached::OPT_AUTO_EJECT_HOSTS, TRUE);
    // Adjust timeouts.
    $m->setOption(Memcached::OPT_CONNECT_TIMEOUT, 2000);
    $m->setOption(Memcached::OPT_POLL_TIMEOUT, 2000);
    $m->setOption(Memcached::OPT_RETRY_TIMEOUT, 2);

    $m->setSaslAuthData(getenv("MEMCACHIER_USERNAME"), getenv("MEMCACHIER_PASSWORD"));
    if (!$m->getServerList()) {
        // We use a consistent connection to memcached, so only add in the servers
        // first time through otherwise we end up duplicating our connections to the
        // server.
        $m->addServers($servers);
    }

    session_start();
} else {
    // Note: this is to resolve cookie issues with port numbers
    $domain = $_SERVER["HTTP_HOST"];
    if (strpos($domain, ":")) {
        $domain = explode(":", $domain)[0];
    }
    $localWorks = true; //some people have issues with localhost for the cookie params
    //if you're one of those people make this false

    //this is an extra condition added to "resolve" the localhost issue for the session cookie
    if (($localWorks && $domain == "localhost") || $domain != "localhost") {
        session_set_cookie_params([
            "lifetime" => 60 * 60,
            "path" => "$BASE_PATH",
            //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
            "domain" => $domain,
            "secure" => true,
            "httponly" => true,
            "samesite" => "lax"
        ]);
    }
    session_start();
}

?>
<!-- include css and js files -->
<!DOCTYPE html>
<html lang="en">

<head>

    <title>My Shop</title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo get_url('Styles/nav.css'); ?>">
    <link rel="stylesheet" href="<?php echo get_url('Styles/body.css'); ?>">
</head>
<script src="<?php echo get_url('Scripts/helpers.js'); ?>"></script>
<nav class='navbar navbar-expand-lg navbar-light'>
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo get_url('home.php'); ?>">
            <img src="<?php echo get_url('Images/LOGO.48'); ?>" alt="logo" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id='navbarSupportedContent'>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (is_logged_in()) : ?>
                    <li class="nav-item"><a href="<?php echo get_url('home.php'); ?>">Shop</a></li>
                    <li class="nav-item"><a href="<?php echo get_url('profile.php'); ?>">Profile</a></li>
                <?php endif; ?>
                <?php if (!is_logged_in()) : ?>
                    <li class="nav-item"><a href="<?php echo get_url('home.php'); ?>">Shop</a></li>
                    <li class="nav-item"><a href="<?php echo get_url('login.php'); ?>">Login</a></li>
                    <li class="nav-item"><a href="<?php echo get_url('register.php'); ?>">Register</a></li>
                    <li id="nav-minicart" class="nav-item" data-cart-view="data-cart-view">
                        <a href="<?php echo get_url('cart_alt.php'); ?>">
                            <button id="nav-minicart-btn">
                                <svg id="" style="height: 22px;" data-name="Cart Icon" xmlns="http://www.w3.org/2000/svg" role="presentation" viewBox="0 0 20 22">
                                    <path d="M5 4V2C5 1.46957 5.21071 0.960859 5.58579 0.585786C5.96086 0.210714 6.46957 0 7 0H13C13.5304 0 14.0391 0.210714 14.4142 0.585786C14.7893 0.960859 15 1.46957 15 2V4H18C18.5304 4 19.0391 4.21071 19.4142 4.58579C19.7893 4.96086 20 5.46957 20 6V19C20 19.7956 19.6839 20.5587 19.1213 21.1213C18.5587 21.6839 17.7956 22 17 22H3C2.20435 22 1.44129 21.6839 0.87868 21.1213C0.316071 20.5587 0 19.7956 0 19V6C0 5.46957 0.210714 4.96086 0.585786 4.58579C0.960859 4.21071 1.46957 4 2 4H5ZM2 6V19C2 19.2652 2.10536 19.5196 2.29289 19.7071C2.48043 19.8946 2.73478 20 3 20H17C17.2652 20 17.5196 19.8946 17.7071 19.7071C17.8946 19.5196 18 19.2652 18 19V6H2ZM7 4H13V2H7V4Z"></path>
                                </svg>
                            </button>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (has_role("Admin")) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Roles
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/create_role.php'); ?>">Create Role</a></li>
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/list_roles.php'); ?>">List Roles</a></li>
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/assign_roles.php'); ?>">Assign Roles</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Items
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/add_item.php'); ?>">Add Item</a></li>
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/list_items.php'); ?>">List Items</a></li>
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/admin_shop.php'); ?>">Admin Shop</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (is_logged_in()) : ?>
                    <li id="nav-minicart" class="nav-item" data-cart-view="data-cart-view">
                        <a href="cart_alt.php">
                            <button id="nav-minicart-btn">
                                <svg id="" style="height: 22px;" data-name="Cart Icon" xmlns="http://www.w3.org/2000/svg" role="presentation" viewBox="0 0 20 22">
                                    <path d="M5 4V2C5 1.46957 5.21071 0.960859 5.58579 0.585786C5.96086 0.210714 6.46957 0 7 0H13C13.5304 0 14.0391 0.210714 14.4142 0.585786C14.7893 0.960859 15 1.46957 15 2V4H18C18.5304 4 19.0391 4.21071 19.4142 4.58579C19.7893 4.96086 20 5.46957 20 6V19C20 19.7956 19.6839 20.5587 19.1213 21.1213C18.5587 21.6839 17.7956 22 17 22H3C2.20435 22 1.44129 21.6839 0.87868 21.1213C0.316071 20.5587 0 19.7956 0 19V6C0 5.46957 0.210714 4.96086 0.585786 4.58579C0.960859 4.21071 1.46957 4 2 4H5ZM2 6V19C2 19.2652 2.10536 19.5196 2.29289 19.7071C2.48043 19.8946 2.73478 20 3 20H17C17.2652 20 17.5196 19.8946 17.7071 19.7071C17.8946 19.5196 18 19.2652 18 19V6H2ZM7 4H13V2H7V4Z"></path>
                                </svg>
                            </button>
                        </a>
                    </li>
                    <li class="nav-item logout"><a id='logout' href="<?php echo get_url('logout.php'); ?>">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
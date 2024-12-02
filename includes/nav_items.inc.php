<?php // nav_items.inc.php
    // Define the user's role
    $role = $_SESSION["Role"];

    // Define navigation items with associated roles
    $navItems = [
        "Home" => ["url" => "index.php", "roles" => ["admin", "user"]],
        "Library" => ["url" => "library.php", "roles" => ["admin", "user"]],
        "Favourite Books" => ["url" => "library_favourites.php", "roles" => ["admin", "user"]],
        "Add Book" => ["url" => "admin_add_book.php", "roles" => ["admin"]],
        "Admin Panel" => ["url" => "admin_panel.php", "roles" => ["admin"]],
        "Logout" => ["url" => "logout.php", "roles" => ["admin", "user"]],
    ];

    // Generate navigation links based on the user's role
    foreach ($navItems as $name => $item) {
        if (in_array(needle: $role, haystack: $item["roles"])) {
            echo '<a href="' . htmlspecialchars(string: $item["url"]) . '" class="w3-bar-item w3-button">' . htmlspecialchars(string: $name) . '</a>';
        }
    }
<?php // nav_items.inc.php
    // Define the user's role
    // $role = $_SESSION["Role"];

    // // Define navigation items with associated roles
    // $navItems = [
    //     "Home" => ["url" => "index.php", "roles" => ["admin", "user"]],
    //     "Library" => ["url" => "library_all.php", "roles" => ["admin", "user"]],
    //     "Favourite Books" => ["url" => "library_favourites.php", "roles" => ["admin", "user"]],
    //     "Add Book" => ["url" => "admin_add_book.php", "roles" => ["admin"]],
    //     "Admin Panel" => ["url" => "admin_panel.php", "roles" => ["admin"]],
    //     "Logout" => ["url" => "backend/logout.php", "roles" => ["admin", "user"]],
    // ];

    // // Generate navigation links based on the user's role
    // foreach ($navItems as $name => $item) {
    //     if (in_array(needle: $role, haystack: $item["roles"])) {
    //         echo '<a href="' . htmlspecialchars(string: $item["url"]) . '" class="w3-bar-item w3-button">' . htmlspecialchars(string: $name) . '</a>';
    //     }
    // }

    // nav_items.inc.php
    // Define the user's role
    $role = $_SESSION["Role"];

    // Define navigation items with associated roles, alignment, and color
    $navItems = [
        "Home" => ["url" => "index.php", "roles" => ["admin", "user"], "alignment" => "left", "color" => "w3-light-blue"],
        "Library" => ["url" => "library_all.php", "roles" => ["admin", "user"], "alignment" => "left", "color" => "w3-dark-gray"],
        "Favourite Books" => ["url" => "library_favourites.php", "roles" => ["admin", "user"], "alignment" => "left", "color" => "w3-dark-gray"],
        "Add Book" => ["url" => "admin_add_book.php", "roles" => ["admin"], "alignment" => "left", "color" => "w3-dark-gray"],
        "Logout" => ["url" => "backend/logout.php", "roles" => ["admin", "user"], "alignment" => "right", "color" => "w3-red"],
        "Admin Panel" => ["url" => "admin_panel.php", "roles" => ["admin"], "alignment" => "right", "color" => "w3-orange"],
    ];

    // Generate navigation links based on the user's role and alignment
    echo '<div class="w3-bar w3-dark-grey">';
    foreach ($navItems as $name => $item) {
        if (in_array(needle: $role, haystack: $item["roles"])) {
            $alignmentClass = $item["alignment"] === "right" ? "w3-right" : "";
            echo '<a href="' . htmlspecialchars($item["url"]) . '" class="w3-bar-item w3-button ' . htmlspecialchars($item["color"]) . ' ' . $alignmentClass . '">' . htmlspecialchars($name) . '</a>';
        }
    }
    echo '</div>';


<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["username"])) {
    header("Location: /dashboard/");
}

$page = htmlspecialchars($_GET["page"]);

$pages = array("login", "about", "register", "home"); // Array Values needed.
$page_found = false; // * Set true if the page is in the array.

if ($page == "") {
    header("Location: /?page=home");
} else {
    // * Iterate each array value.
    foreach($pages as $pagearray) {
        if ($pagearray != $page) { // * If page not found in array then $page stay false;
            continue;
        } else {
            $page_found = true; // * If it is found then set the $page_found to true then include the file.
            include($page.".php");
        }
    }
    // * If the page is not found and then the $page_found is set to false then raise error;
    if ($page_found == false) {
        die("No Page Found for ".$page);
    }
}
?>
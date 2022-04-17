<?php

$rootdir = dirname(__FILE__);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once($rootdir . "/../libraries/dashboard/get.php");

$pages = array("save", "update", "clear", "action_logs");
$isPageFound = false;

if (isset($_GET["page"])) {
    $page = htmlspecialchars($_GET["page"]);
    foreach ($pages as $val) {
        if ($page != $val) {
            $isPageFound = false;
        } else {
            $isPageFound = true;
            break;
        }
    }

    if ($isPageFound == true) {
        include("ui_".$page.".php");
    } else {
        die("Page <b>".$page."</b> is not found.");
    }
} else if (!isset($_SESSION["username"])) {
    die(header("Location: /?page=login"));
} elseif (isset($_GET["view_id"])) {
    include("view.php");
} elseif (isset($_GET["delete_id"])) {
    include("delete.php");
} elseif (isset($_GET["action_logs"])) {
    include("ui_action_logs.php");
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard_navigation.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title> Dashboard / Contact Book </title>
</head>

<body>
    <?php include("../templates/dashboard_navigation.php"); ?>
    <div class="mt-2 container-lg container">
        <div class="row g-3">
            <div class="col col-lg-8 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        Contacts
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['alert']) && isset($_GET['type'])) {
                            require_once("../libraries/phpstyles.php");
                            echo phpstyle_alert($_GET["alert"], $_GET["type"]);
                        }
                        ?>
                        <div class="mb-3">
                            <form action="" method="get">
                                <label for="search" class="form-label">Search</label>
                                <div class="row g-2">
                                    <div class="col col-lg-6 col-md-12">
                                        <input type="text" name="contact_search" id="js_search" class="form-control"
                                            placeholder="Search contact by Email, Phone, or Alias.">
                                    </div>
                                    <div class="col col-lg-3 col-md-6">
                                        <select name="sortby" id="js_sortby" class="form-control" onchange="syncSearchToSelect()">
                                            <option value="Alias">by Alias</option>
                                            <option value="Email">by Email</option>
                                            <option value="Phone">by Phone number</option>
                                        </select>
                                    </div>
                                    <div class="col col-lg-3 col-md-6">
                                        <button type="submit"
                                            class="btn btn-outline-success form-control">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-responsive">
                                <caption class="caption-top">List of contacts</caption>
                                <thead>
                                    <tr>
                                        <th>Alias</th>
                                        <th>Phone number</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_GET["contact_search"])) {
                                        echo searchContactsToTable(getLoggedUser(), $_GET["contact_search"], $_GET["sortby"]);
                                    } else {
                                        if (isset($_GET["pagination"])) {
                                            echo get_ContactsToTablePagination(getLoggedUser(), $_GET["pagination"]);
                                        } else {
                                            echo get_ContactsToTable(getLoggedUser());
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination float-end">
                                    <?php 
                                    echo contactsTablePagination(getLoggedUser());
                                    ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="mb-3">
                            <!-- Page Navigation -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="table-responsive-sm table-responsive">
                    <table class="table table-bordered text-center">
                        <caption><a href="?page=action_logs">Action Logs</a></caption>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Action Log</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            getUserLogsToTable(getLoggedUser());
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/ui_save.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/3904585a30.js" crossorigin="anonymous"></script>
</body>
<?php } ?>

</html>
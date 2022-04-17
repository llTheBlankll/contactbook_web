<?php
require_once "../libraries/dashboard/get.php";
require_once "../libraries/connection.php";
require_once "../libraries/dashboard/insert.php";
require_once "../libraries/dashboard/delete.php";


// Check if ?delete_id is set.
if (!isset($_GET["delete_id"])) {
    die(header("Location: /dashboard/"));
}

// Check if the value of delete_id is valid.
if (checkContactId(getLoggedUser(), $_GET["delete_id"])) {
    $viewIdData = getContactId(getLoggedUser(), $_GET["delete_id"]);
} else {
    die(header("Location: /dashboard/"));
}

// If the user click Yes.
if (isset($_GET["delete_id"]) && isset($_GET["confirm"]) && $_GET["confirm"] == "yes") {
    if (checkContactId(getLoggedUser(), $_GET["delete_id"])) {
        if (deleteContact(getLoggedUser(), $_GET["delete_id"])) {
            logAction("Notice", "Alias $viewIdData[alias] successfully deleted!", getLoggedUser());
            header("Location: /dashboard/?alert=Alias $viewIdData[alias] successfully deleted!&type=primary");
        } else {
            logAction("Failed", "Alias $viewIdData[alias] failed to delete.", getLoggedUser());
            header("Location: /dashboard/?alert=Alias $viewIdData[alias] successfully deleted!&type=danger");
        }
    } else {
        die(header("Location: /dashboard/"));
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/dashboard_navigation.css">
    <title> Delete / Contact Book </title>
</head>
<body>
    <?php include("../templates/dashboard_navigation.php"); ?>
    <div class="container container-lg mt-2">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-header">
                        Delete <?php  ?>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row text-center">
                                <div class="mb-3">
                                    <h4>Are you sure you want to delete </h4>
                                </div>
                                <div class="mb-3">
                                    <h5>
                                        Alias<br />
                                        <b>
                                            <?php 
                                            echo $viewIdData["alias"];
                                            ?>
                                        </b>
                                        <br>
                                        <br />
                                        Name<br />
                                        <b>
                                            <?php
                                            echo $viewIdData["fullname"];
                                            ?>
                                        </b>
                                    </h5>
                                </div>
                                <div class="mb-3">
                                    <div class="col-12">
                                        <div class="btn-group w-50">
                                            <a class="btn-primary btn" href="/dashboard/">No</a>
                                            <?php
                                            echo "<a class='btn-danger btn' href='?delete_id=" . sanitizeReturn($_GET["delete_id"]) . "&confirm=yes'>Yes</a>"
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
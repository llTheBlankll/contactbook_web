<?php
require_once("../libraries/dashboard/get.php");
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title> Action Logs / Contact Book </title>
</head>
<body>
    <?php include("../templates/dashboard_navigation.php"); ?>
    <div class="container container-lg mt-2">
        <div class="row">
            <div class="col-lg-8 col-12 col-sm-10 col-md-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-cog"></i>
                        Action Logs
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET["pagination"])) {
                                    getUserLogsToTablePagination(getLoggedUser(), $_GET["pagination"]);
                                } else {
                                    getUserLogsToTablePagination(getLoggedUser(), 1);
                                }
                                ?>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <?php
                                if (isset($_GET["pagination"])) {
                                    userLogsPagination(getLoggedUser(), $_GET["pagination"]);
                                } else {
                                    userLogsPagination(getLoggedUser());
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
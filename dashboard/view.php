<?php
$rootdir = dirname(__FILE__);

require_once($rootdir."/../libraries/dashboard/get.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_GET["view_id"])) {
    if (checkContactId(getLoggedUser(), $_GET["view_id"]) == false) {
        header("Location: /dashboard/?alert=Invalid ID $_GET[view_id]&type=danger");
    } else {
        $view_id_array = getContactId(getLoggedUser(), $_GET["view_id"]);
    }
} else {
    header("Location: /dashboard/");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard_navigation.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <?php include($rootdir."/../templates/dashboard_navigation.php"); ?>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col col-lg-6 col-md-8 offset-lg-3 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Viewing alias <b><?php echo sanitizeReturn($view_id_array["alias"]); ?></b>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <divl class="col-lg-7">
                                <div class="mb-2">
                                    <label for="" class="form-label">Alias</label>
                                    <?php
                                    echo '<input type="text" name="alias" id="js_alias" class="form-control" disabled value="' . $view_id_array["alias"] . '">';
                                    ?>
                                </div>
                            </divl>
                            <div class="col-lg-5">
                                <div class="mb-2">
                                    <label for="" class="form-label">Phone number</label>
                                    <?php
                                    echo '<input type="text" name="phone" id="js_phone" class="form-control" disabled value="' . $view_id_array["phone"] . '">';
                                    ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="" class="form-label">Email</label>
                                    <?php
                                    echo '<input type="text" name="email" id="js_email" class="form-control" disabled value="' . $view_id_array["email"] . '">';
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8 col-md-6">
                                <div class="mb-2">
                                    <label for="" class="form-label">Full name</label>
                                    <?php
                                    echo '<input type="text" name="fullname" id="js_fullname" class="form-control" disabled value="' . $view_id_array["fullname"] . '">';
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="mb-2">
                                    <label for="" class="form-label">Phone number type</label>
                                    <?php
                                    echo '<input type="text" name="phonetype" id="js_phonetype" class="form-control" disabled value="' . $view_id_array["phonetype"] . '">';
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 clearfix">
                                <div class="mb-2 text-center">
                                    <div class="btn-group w-50">
                                        <a href="/dashboard/" class="btn btn-danger form-control float-end">Back</a>
                                        <?php echo "<a href='?page=update&view_id=" . $view_id_array["id"] . "' class='btn btn-success form-control float-end'>Update</a>"; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>
<?php
require_once(dirname(__FILE__)."/../libraries/dashboard/get.php");
require_once("../libraries/dashboard/insert.php");
require_once("../libraries/dashboard/update.php");

if (isset($_GET["view_id"])) {
    if (isset($_POST["alias"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["fullname"]) && isset($_POST["phonetype"])) {
        // * getContactId is called to store the action of the user.
        $view_id_array = getContactId(getLoggedUser(), $_GET["view_id"]);
        $alias = sanitizeReturn($_POST["alias"]);

        if ($_POST["alias"] == $view_id_array["alias"]) {
            if (updateContactId(getLoggedUser(), $_POST["viewid"], $_POST["alias"], $_POST["phone"], $_POST["email"], $_POST["fullname"], $_POST["phonetype"], false)) {
                logAction("Success", "$alias successfully updated", getLoggedUser());
                header("Location: /dashboard/?alert=$alias successfully updated!&type=success");
            } else {
                logAction("Failed", "$alias failed to update", getLoggedUser());
                header("Location: /dashboard/?alert=$alias failed to update.&type=danger");
            }
        } else {
            if (updateContactId(getLoggedUser(), $_POST["viewid"], $_POST["alias"], $_POST["phone"], $_POST["email"], $_POST["fullname"], $_POST["phonetype"], true)) {
                logAction("Success", "$view_id_array[alias] updated to $alias", getLoggedUser());
                header("Location: /dashboard/?alert=$view_id_array[alias] successfully updated to $alias!&type=success", getLoggedUser());
            } else {
                logAction("Failed", "$view_id_array[alias] failed to update", getLoggedUser());
                header("Location: /dashboard/?alert=$alias already exist.&type=danger");
            }
        }
    } else {
        if (checkContactId(getLoggedUser(), $_GET["view_id"]) == false) {
            header("Location: /dashboard/?alert=ID $_GET[view_id] is not valid.&type=danger");
        } else {
            $view_id_array = getContactId(getLoggedUser(), $_GET["view_id"]);
        }
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
    <title> Update / Contact Book </title>
</head>

<body>
    <?php include("../templates/dashboard_navigation.php"); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col col-lg-6 col-md-8 offset-lg-3 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Updating
                        <b>
                            <?php echo sanitizeReturn($view_id_array["alias"]); ?>
                        </b>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <form action="" method="post">
                                <div class="row g-2">
                                    <div class="col-lg-7">
                                        <div class="mb-2">
                                            <?php 
                                            echo '<input type="text" hidden name="viewid" value="' . $view_id_array["id"] . '">';
                                            ?>
                                            <label for="" class="form-label">Alias</label>
                                            <?php
                                echo '<input type="text" name="alias" id="js_alias" class="form-control" value="' . $view_id_array["alias"] . '">';
                                ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Phone number</label>
                                            <?php
                                echo '<input type="text" name="phone" id="js_phone" class="form-control" value="' . $view_id_array["phone"] . '">';
                                ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Email</label>
                                            <?php
                                echo '<input type="text" name="email" id="js_email" class="form-control" value="' . $view_id_array["email"] . '">';
                                ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-8 col-md-6">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Full name</label>
                                            <?php
                                echo '<input type="text" name="fullname" id="js_fullname" class="form-control" value="' . $view_id_array["fullname"] . '">';
                                ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-6">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Phone number type</label>
                                            <select name="phonetype" id="js_phonetype" class="form-control">
                                                <?php 
                                                if (sanitizeReturn($view_id_array["phonetype"]) == "Personal") {
                                                    echo "<option value='" . $view_id_array["phonetype"] . "'>" . $view_id_array["phonetype"] . "</option>";
                                                ?>
                                                <option value="Work">Work</option>
                                                <option value="Business">Business</option>
                                                <?php 
                                                } else if (sanitizeReturn($view_id_array["phonetype"]) == "Work")  {
                                                    echo "<option value='" . $view_id_array["phonetype"] . "'>" . $view_id_array["phonetype"] . "</option>";
                                                ?>
                                                <option value="Personal">Personal</option>
                                                <option value="Business">Business</option>
                                                <?php
                                                } else if (sanitizeReturn($view_id_array["phonetype"]) == "Business") {
                                                    echo "<option value='" . $view_id_array["phonetype"] . "'>" . $view_id_array["phonetype"] . "</option>"
                                                ?>
                                                <option value="Personal">Personal</option>
                                                <option value="Work">Work</option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center clearfix">
                                        <div class="mb-2">
                                            <div class="btn-group w-50">
                                            <a href="/dashboard/" class="btn btn-outline-danger form-control">Back</a>
                                            <button name='button_save' id='js_save' class='form-control btn btn-outline-success'>Save</button>
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
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>
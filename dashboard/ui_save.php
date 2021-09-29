<?php
$rootdir = dirname(__FILE__);


require_once($rootdir."/../libraries/dashboard/get.php");
require_once($rootdir."/../libraries/dashboard/insert.php");

if (isset($_POST["button_save"]) && isset($_POST["contact_alias"]) && isset($_POST["contact_phone"]) && isset($_POST["contact_email"]) && isset($_POST["contact_fullname"]) && isset($_POST["contact_phonetype"])) {
    $alias = $_POST["contact_alias"];
    $phone = $_POST["contact_phone"];
    $email = $_POST["contact_email"];
    $fname = $_POST["contact_fullname"];
    $ptype = $_POST["contact_phonetype"];

    // Check if there is a field that has not been filled.
    if ($alias == "" || $phone == "" || $email == "" || $fname == "" || $ptype == "select") {
        header("Location: ?page=save&alert=Please fill up all fields.&type=danger");
    } else {
        if (checkContactAlias($alias, getLoggedUser()) != true) {
            if (saveContact($alias, $phone, $email, $fname, $ptype, getLoggedUser()) != false) {
                if (logAction("Notice", "You added new contact name " . $alias, getLoggedUser()) != false) {
                    header("Location: ?page=save&alert=New contact name ". $alias . " was saved&type=success");
                } else {
                    header("Location: ?page=save&alert=Cannot log action. Please report this to system administrator.&type=danger");
                }
            } else {
                header("Location: ?page=save&alert=Contact cannot be save. Please contact system administrator.&type=danger");
            }
        } else {
            header("Location: ?page=save&alert=Contact named " . htmlspecialchars($alias) . " already exist.&type=danger");
        }
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title> Save / Contact Book </title>
</head>

<body>
    <?php include("../templates/dashboard_navigation.php"); ?>
    <div class="container mt-2">
        <div class="row">
            <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-8 offset-sm-2">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-pen fa-lg" style="margin-right: 4px;"></i>
                        Save
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row g-2">
                                <div class="col-12 col-lg-8 col-md-6 col-sm-12">
                                    <div class="mb-2">
                                        <label for="" class="form-label">Alias</label>
                                        <input type="text" name="contact_alias" id="js_alias" class="form-control"
                                            placeholder="Contact alias" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 col-md-6">
                                    <div class="mb-2">
                                        <label for="" class="form-label">Phone number</label>
                                        <input type="text" name="contact_phone" id="js_phone" class="form-control"
                                            placeholder="Phone number" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" name="contact_email" id="js_email" class="form-control"
                                            placeholder="Contact Email">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8 col-md-6">
                                    <div class="mb-2">
                                        <label for="fullname" class="form-label">Full name</label>
                                        <input type="text" name="contact_fullname" id="js_fullname" class="form-control"
                                            placeholder="Full name / another alias" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 col-md-6">
                                    <div class="mb-2">
                                        <label for="phonetype" class="form-label">Phone number type</label>
                                        <select name="contact_phonetype" id="js_phonetype" class="form-control">
                                            <option value="select">--- Select ---</option>
                                            <option value="Personal">Personal</option>
                                            <option value="Work">Work</option>
                                            <option value="Business">Business</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- ALERT CONTENT -->
                                    <?php
                                    if (isset($_GET["alert"]) && isset($_GET["type"])) {
                                        require("../libraries/phpstyles.php");
                                        echo "<div class='mb-3 text-center'>";
                                        echo phpstyle_alert($_GET["alert"], $_GET["type"]);
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                                <div class="col-12 text-center">
                                    <div class="mb-2">
                                        <button type="submit" name="button_save"
                                            class="btn btn-outline-primary form-control w-50">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/3904585a30.js" crossorigin="anonymous"></script>
</body>
<?php } ?>

</html>
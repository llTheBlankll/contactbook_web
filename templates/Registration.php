<?php

if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["reenter_password"]) && isset($_POST["email"]) && isset($_POST["button_signup"])) {
    $con = mysqli_connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $rpassword = htmlspecialchars($_POST["reenter_password"]);
    $email = htmlspecialchars($_POST["email"]);

    # Check all inputs if there is something wrong.
    if ($username == "" || $password == "" || $rpassword == "" || $email == "") {
        header("Location: /?page=register&alert=Please fill all fields.&type=danger");
    } else {
        if ($password != $rpassword) {
            header("Location /?page=register&alert=Password is not the same&type=danger");
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: /?page=register&alert=Invalid Email Address&type=danger");
            } else {
                require "./libraries/registration.php";
                if (addUser($username, $password, $email)) {
                    header("Location: /?page=register&alert=Account created successfully!&type=success");
                } else {
                    header("Location: /?page=register&alert=" . $username . " already exist.&type=danger");
                }
            }
        }
    }
} else {
    ?>
<div class="container">
    <div class="row">
        <div class="col col-lg-4 offset-lg-4 col-sm-10 offset-sm-1 col-md-7 col-12 offset-md-3">
            <div class="card mt-2 shadow">
                <div class="card-header text-center">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <form action="/?page=register" method="post">
                        <div class="mb-4">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="js_username" class="form-control" onkeyup="validateInputs()" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="js_password" class="form-control" onkeyup="validateInputs()" required>
                        </div>
                        <div class="mb-4">
                            <label for="reenterpassword" class="form-label">Re-enter Password</label>
                            <input type="password" name="reenter_password" id="js_reenterpassword" class="form-control" onkeyup="validateInputs()" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="js_email" class="form-control" onkeyup="validateInputs()" required>
                        </div>
                        <div class="mb-4 text-center" id="errors">
                            <?php
                            if (isset($_GET["alert"]) && isset($_GET["type"])) {
                                require_once "./libraries/phpstyles.php";
                                echo phpstyle_alert($_GET["alert"], $_GET["type"]);
                            }
                            ?>
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary form-control" id="js_signup" name="button_signup" disabled>Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center mt-2"><a href="/?page=login" class="text-decoration-none link-secondary">Sign in here</a></p>
        </div>
    </div>
    <script src="../js/registration.js"></script>
</div>
<?php }?>
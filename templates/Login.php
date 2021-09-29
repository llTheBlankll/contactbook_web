<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require("./libraries/login.php");

if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["button_login"])) {
    if (isset($_POST["remember_me"]) && $_POST["remember_me"] == "on") {
        # Is temporary disabled.
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (login($username, $password) != false) {
            header("Location: /dashboard/");
        } else {
            header("Location: /?page=login&alert=Invalid Username or Password&type=danger");
        }
    }
} else {
?>
<div class="container mt-3">
    <div class="row">
        <div class="col-lg-4 offset-lg-4 col-sm-12 col-md-6 offset-md-3">
            <div class="card shadow " id="login_form">
                <div class="card-header text-center">
                    <h3>
                        Sign in
                    </h3>
                </div>
                <div class="card-body p-4">
                    <form action="/?page=login" method="post">
                        <div class="mb-4">
                            <label for="js_username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="js_username" placeholder="Username" required>
                        </div>
                        <div class="mb-4">
                            <label for="js_password" class="form-label">Password</label>
                            <input type="password" name="password" id="js_password" placeholder="Password" class="form-control" required>
                        </div>
                        <div class="mb-4 text-center">
                            <?php 
                            if (isset($_GET["alert"]) && isset($_GET["type"])) {
                                require("./libraries/phpstyles.php");
                                echo phpstyle_alert($_GET["alert"], $_GET["type"]);
                            }
                            ?>
                        </div>
                        <div class="mb-4">
                            <button class="btn btn-primary form-control" name="button_login" type="submit">Sign in</button>
                        </div>
                        <div class="clearfix">
                            <label class="form-check-label">
                                <input type="checkbox" name="remember_me" id="remember_me" style="margin-right: 4px;">Remember me
                            </label>
                            <a href="#" class="link-primary float-end">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center pt-2"><a href="/?page=register" class="text-decoration-none link-secondary">Create an account.</a></p>
        </div>
    </div>
</div>
<?php } ?>
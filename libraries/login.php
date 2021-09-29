<?php

require("connection.php");

function getUserSalt($user) {
    /*
    ! Take the salt of the user for login in the database.

    * If the salt is found in from the provided user then
    * the function will return it's result in the form of hash salt.

    * If the salt is not found then
    * return false.
    */
    $con = connectMySQL();

    $user = mysqli_real_escape_string($con, htmlspecialchars($user));  # output 'test'
    $sql = "SELECT salt FROM users WHERE username = ?";
    // Preparing and binding variables
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    // Getting result
    $result = $stmt->get_result();
    // Check if user exist.
    if ($result->num_rows == 1) {
        $data = $result->fetch_assoc();

        // * Closing the connection reduce load in the server.
        $con->close();
        return $data["salt"];
    } else {

        // * Closing the connection reduce load in the server.
        $con->close();
        return false;
    }
}

function login($username, $password) {
    /*
    ! Select a user from database provided by user with credentials

    * If the credential is found in database then
    * the function will return true for it's successful execution.

    * If the credential is not found in the database then 
    * the function will return false.
    */
    $con = connectMySQL();

    $username = mysqli_real_escape_string($con, htmlspecialchars($username));
    $password = mysqli_real_escape_string($con, htmlspecialchars($password));
    $salt = getUserSalt($username);
    
    if ($salt != false) {
        $sql = "SELECT * FROM users WHERE BINARY username = ? AND password = ?";
        // ! Hash the Password
        $password = md5(hash("sha512", $password.$salt.$salt.$password.$salt));
        // * Preparing and binding variables
        $prepared = $con->prepare($sql);
        $prepared->bind_param("ss", $username, $password);
        $prepared->execute();
        // * Getting results
        $result = $prepared->get_result();
        if ($result->num_rows == 1) {
            while ($val = $result->fetch_assoc()) {
                if ($val["password"] == $password) {
                    // ! Set user identity for successful login.
                    $_SESSION["username"] = $username;
                    // * Closing the connection reduce load in the server.
                    $con->close();
                    return true;
                } else {
                    // * Closing the connection reduce load in the server.
                    $con->close(); 
                    return false;
                }
            }
        } else {
            // * Closing the connection reduce load in the server.
            $con->close();
            return false;
        }
    }
}
?>
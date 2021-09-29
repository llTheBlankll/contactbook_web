<?php
require "connection.php";
require "miscellaneous.php";

function userexist($username)
{
    /*
     * This function will check if the user already exist in the database
    If the user exist this return true else false
     */

    # MySQL Connection.
    $con = connectMySQL();

    $username = mysqli_real_escape_string($con, htmlspecialchars($username));
    $sql = "SELECT * FROM users WHERE BINARY username = ?";
    $prepared = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($prepared, "s", $username);
    mysqli_stmt_execute($prepared);
    mysqli_stmt_store_result($prepared);
    $rows = mysqli_stmt_num_rows($prepared);
    if ($rows == 1) {
        // * Closing the connection reduce load in the server.
        $con->close();
        return true;
    } else {
        // * Closing the connection reduce load in the server.
        $con->close();
        return false;
    }
}

function addUser($username, $password, $email)
{
    /*
     * This function will insert a row in MySQL Table users.
     * If the statement is executed then return true else false
     */
    # MySQL Connection.
    $con = connectMySQL();


    $username = mysqli_real_escape_string($con, htmlspecialchars($username));
    $password = mysqli_real_escape_string($con, htmlspecialchars($password));
    $email = mysqli_real_escape_string($con, htmlspecialchars($email));
    // ! Generate the salt for password.
    $salt = generateRandomSalt();
    // ! Hash and Salt the password.
    $password = md5(hash("sha512", $password.$salt.$salt.$password.$salt));

    $sql = "INSERT INTO users(username, password, email, salt) VALUES (?, ?, ?, ?)";
    $prepared = $con->prepare($sql);
    $prepared->bind_param("ssss", $username, $password, $email, $salt);
    if (userexist($username) == true) {
        // * Closing the connection reduce load in the server.
        $con->close();
        return false;
    } else {
        if ($prepared->execute()) {
            // * Closing the connection reduce load in the server.
            $con->close();
            return true;
        } else {
            // * Closing the connection reduce load in the server.
            $con->close();
            return false;
        }
    }
}

<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "get.php";

function logAction($type, $action, $user)
{
    /*
     * The use of this function is to save the action of the user to the log.

     * If the user save, delete, or updated their saved contact information then
     * this function will be called to log their action.
     */
    $con = connectMySQL();

    $type = mysqli_real_escape_string($con, htmlspecialchars($type));
    $action = mysqli_real_escape_string($con, htmlspecialchars($action));
    $date = date("M j - h:i:s A");

    $sql = "INSERT INTO user_logs(type, action, date, user) VALUES (?, ?, ?, ?)";

    // * Prepared Statements and execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $type, $action, $date, $user);

    if ($stmt->execute()) {
        // * Closing the connect reduce load in the server.
        $con->close();

        return true;
    } else {
        // * Closing the connect reduce load in the server.
        $con->close();

        return false;
    }

    // Close
    $con->close();
}

function saveContact($alias, $phone, $email, $fname, $ptype, $user)
{
    /*
     * The use of this function is to save contact information belonging to the user.
     */
    $con = connectMySQL();

    // ! Prevent security holes.
    $alias = mysqli_real_escape_string($con, htmlspecialchars($alias));
    $phone = mysqli_real_escape_string($con, htmlspecialchars($phone));
    $email = mysqli_real_escape_string($con, htmlspecialchars($email));
    $fname = mysqli_real_escape_string($con, htmlspecialchars($fname));
    $ptype = mysqli_real_escape_string($con, htmlspecialchars($ptype));
    $userlogged = htmlspecialchars($user);

    $sql = "INSERT INTO contacts (alias, phone, email, fullname, phonetype, for_user) VALUES (?, ?, ?, ?, ?, ?)";

    // * Prepared Statements and Execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssss", $alias, $phone, $email, $fname, $ptype, $userlogged);
    if ($stmt->execute()) {
        // * Closing the connect reduce load in the server.
        $con->close();

        return true;
    } else {
        // * Closing the connect reduce load in the server.
        $con->close();

        return false;
    }

    // Close.
    $con->close();
}

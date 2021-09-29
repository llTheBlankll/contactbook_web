<?php
$rootdir = dirname(__FILE__);
// ! How many rows to display to table.
define("MAX_GET_ROWS", 10);

// * Import libraries
require_once $rootdir."/../connection.php";

// * Check if session started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// * Check if user is logged in.
if (!isset($_SESSION["username"])) {
    header("Location: /?page=login");
}

// * Get user name currently logged in.
function getLoggedUser()
{
    $con = connectMySQL();
    $user = mysqli_real_escape_string($con, htmlspecialchars($_SESSION["username"]));

    // * Closing the connection reduce load in the server.
    $con->close();
    return $user;
}

// * Check if the contact named $alias is already exist.
function checkContactAlias($alias, $user)
{
    $con = connectMySQL();
    $alias = mysqli_real_escape_string($con, htmlspecialchars($alias));
    $user = sanitizeReturn($user, true);

    $sql = "SELECT * FROM contacts WHERE alias = ? AND BINARY for_user = ?";

    // * Prepared Statements and execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $alias, $user);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows >= 1) {
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

/*
 * The function will show and display the result using html tr>td table
 */
function get_ContactsToTable($user, $max = MAX_GET_ROWS)
{
    $con = connectMySQL();
    $sql = "SELECT * FROM contacts WHERE for_user = ? ORDER BY alias DESC LIMIT ?";

    // * Prepared Statements and execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $user, $max);
    $stmt->execute();

    // * Get SELECT result.
    $result = $stmt->get_result();

    // * Display result with html.
    if ($result->num_rows >= 1) {
        while ($val = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $val["alias"] . "</td>";
            echo "<td>" . $val["phone"] . "</td>";
            echo "<td>" . $val["email"] . "</td>";
            echo "<td><a href='?view_id=" . $val["id"] . "'>View</a> <a href='?delete_id=" . $val["id"] . "'>Delete</a>";
            echo "</tr>";
        }
    }

    // Close
    $con->close();
}

function contactsTablePagination($user, $page = 1)
{
    $con = connectMySQL();
    $page = sanitizeReturn($page);
    $rows_perpage = 10;

    $sql = "SELECT * FROM contacts WHERE BINARY for_user = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();
    $pages = round($result->num_rows / $rows_perpage);

    for ($i = 1; $i <= $pages + 1; $i++) {
        echo "<li class='page-item'><a class='page-link' href='?pagination=" . $i . "'>" . $i . "</a></li>";
    }
    $con->close();
}

function get_ContactsToTablePagination($user, $page = 1)
{
    $con = connectMySQL();
    $page = sanitizeReturn($page);
    $rows_perpage = 9; // * 9 + 1 will be ten rows. There is always +1 if you want 20 rows that would be 19
    $offset = ($page - 1) * $rows_perpage;

    $sql = "SELECT * FROM contacts WHERE BINARY for_user = ? ORDER BY alias LIMIT ?, ?";

    // * Prepared Statements and execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sii", $user, $offset, $rows_perpage);
    $stmt->execute();

    $result = $stmt->get_result();
    while ($val = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $val["alias"] . "</td>";
        echo "<td>" . $val["phone"] . "</td>";
        echo "<td>" . $val["email"] . "</td>";
        echo "<td><a href='?view_id=" . $val["id"] . "'>View</a> <a href='?delete_id=" . $val["id"] . "'>Delete</a>";
        echo "</tr>";
    }
}

/*
 * using MySQL SELECT AND LIKE
 * The function is used for searching and displaying the result using html tr>td table
 */
function searchContactsToTable($user, $search, $searchby, $max = MAX_GET_ROWS)
{
    $con = connectMySQL();

    $search = mysqli_real_escape_string($con, htmlspecialchars("%" . $search . "%"));
    $sortby = mysqli_real_escape_string($con, htmlspecialchars($searchby));

    if ($sortby == "Alias") {
        $sql = "SELECT * FROM contacts WHERE alias LIKE ? AND for_user = ? ORDER BY alias DESC LIMIT ?";

        // * Prepared Statements and execute!
        $stmt = $con->prepare($sql);

        $stmt->bind_param("ssi", $search, $user, $max);
        $stmt->execute();

        // * Get MySQL Result.
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            while ($val = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $val["alias"] . "</td>";
                echo "<td>" . $val["phone"] . "</td>";
                echo "<td>" . $val["email"] . "</td>";
                echo "<td><a href='?view_id=" . $val["id"] . "'>View</a> <a href='?delete_id=" . $val["id"] . "'>Delete</a>";
                echo "</tr>";
            }
        }
    } else if ($sortby == "Email") {
        $sql = "SELECT * FROM contacts WHERE email LIKE ? AND for_user = ? LIMIT ?";

        // * Prepared Statements and execute!
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $search, $user, $max);
        $stmt->execute();

        // * Get MySQL Result.
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            while ($val = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $val["id"] . "</td>";
                echo "<td>" . $val["alias"] . "</td>";
                echo "<td>" . $val["phone"] . "</td>";
                echo "<td>" . $val["email"] . "</td>";
                echo "<td><a href='?view_id=" . $val["id"] . "'>View</a> <a href='?delete_id=" . $val["id"] . "'>Delete</a>";
                echo "</tr>";
            }
        }
    } else if ($sortby == "Phone") {
        $sql = "SELECT * FROM contacts WHERE phone LIKE ? AND for_user = ? LIMIT ?";

        // * Prepared Statements and execute!
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $search, $user, $max);
        $stmt->execute();

        // * Get MySQL Result.
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            while ($val = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $val["id"] . "</td>";
                echo "<td>" . $val["alias"] . "</td>";
                echo "<td>" . $val["phone"] . "</td>";
                echo "<td>" . $val["email"] . "</td>";
                echo "<td><a href='?view_id=" . $val["id"] . "'>View</a> <a href='?delete_id=" . $val["id"] . "'>Delete</a>";
                echo "</tr>";
            }
        }
    }

    // Close connection.
    $con->close();
}

// * Sanitize Inputs
function sanitizeReturn($value, $isSql = false)
{
    if ($isSql != false) {
        $con = connectMySQL();
        $sanitized = mysqli_real_escape_string($con, htmlspecialchars($value));

        // * Closing the connect reduce load in the server.
        $con->close();

        return $sanitized;
    } else {
        return htmlspecialchars($value);
    }
}

// * This will check if the contact exist
// * If it exist then return true if not then false
function checkContactId($user, $cid)
{
    $con = connectMySQL();
    $user = sanitizeReturn($user, true);
    $cid = sanitizeReturn($cid, true);

    $sql = "SELECT * FROM contacts WHERE id = ? AND for_user = ?";

    // * Prepared statements and execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $cid, $user);
    $stmt->execute();
    $data = $stmt->get_result()->num_rows;
    if ($data >= 1) {
        $con->close();
        return true;
    } else {
        $con->close();
        return false;
    }
    $con->close();
}

/*
 * The use of this function will return the data's of selected id.
 * Array contents:
! Alias
! Phone
! Email
! Fullname
! Phonetype
 * NOTE: all array contents starts with lowcase.
 */
function getContactId($user, $id)
{
    $con = connectMySQL();

    // Variables
    $id = mysqli_real_escape_string($con, htmlspecialchars($id));
    $sql = "SELECT * FROM contacts WHERE id = ? AND for_user = ?";

    // * Prepared Statements and execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $id, $user);
    if (checkContactId($user, $id) != false) {
        if ($stmt->execute()) {
            // * Get the result of SQL Statement.
            $result = $stmt->get_result();
            $con->close();
            return $result->fetch_assoc();
        }
    } else {
        $con->close();
        return false;
    }

    // Close
    $con->close();
}

function getUserLogsToTable($user, $max = MAX_GET_ROWS)
{
    $con = connectMySQL();

    $sql = "SELECT * FROM user_logs WHERE BINARY user = ? ORDER BY date DESC LIMIT ?";

    // * Prepared Statements and execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $user, $max);
    $stmt->execute();

    // * Get the prepared statement data!
    $result = $stmt->get_result();

    // * Display the data using table row (tr) and table data (td) via html.
    while ($r = $result->fetch_assoc()) {
        echo "<tr>";
        if ($r["type"] == "Failed") {
            echo "<td class='text-danger'>" . $r["type"] . "</td>";
        } else if ($r["type"] == "Success") {
            echo "<td class='text-success'>" . $r["type"] . "</td>";
        } else if ($r["type"] == "Notice") {
            echo "<td class='text-info'>" . $r["type"] . "</td>";
        } else {
            echo "<td class='text-primary" . $r["type"] . "</td>";
        }
        echo "<td>" . $r["action"] . "</td>";
        echo "<td>" . $r["date"] . "</td>";
        echo "</tr>";
    }
    $con->close();
}

function getUserLogsToTablePagination($user, $page, $max = MAX_GET_ROWS)
{
    $con = connectMySQL();

    $max = sanitizeReturn($max, true);
    $page = sanitizeReturn($page, true);
    $row_perpage = 9; // * + 1 -> 10 rows.
    $offset = ($page - 1) * $row_perpage;

    // * Prepared statements and execute!
    $sql = "SELECT * FROM user_logs WHERE BINARY user = ? ORDER BY date DESC LIMIT ?, ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sii", $user, $offset, $row_perpage);

    $stmt->execute();
    $data = $stmt->get_result();

    while ($r = $data->fetch_assoc()) {
        echo "<tr>";
        if ($r["type"] == "Failed") {
            echo "<td class='text-danger'>" . $r["type"] . "</td>";
        } else if ($r["type"] == "Success") {
            echo "<td class='text-success'>" . $r["type"] . "</td>";
        } else if ($r["type"] == "Notice") {
            echo "<td class='text-info'>" . $r["type"] . "</td>";
        } else {
            echo "<td class='text-primary" . $r["type"] . "</td>";
        }
        echo "<td>" . $r["action"] . "</td>";
        echo "<td>" . $r["date"] . "</td>";
        echo "</tr>";
    }
    $con->close();
}

/*
 * This function shows pagination in /dashboard/?page=action_logs
 * and display the page below
 */
function userLogsPagination($user)
{
    $con = connectMySQL();

    // * Per 1 page there is increase of 10
    // * 10 Rows per page.
    $rows_perpage = 10;
    $sql = "SELECT * FROM user_logs WHERE BINARY user = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $rows = $stmt->get_result()->num_rows;

    $pages = round($rows / $rows_perpage);
    for ($i = 1; $i <= $pages + 1; $i++) {
        echo "<li class='page-item'><a class='page-link' href='?page=action_logs&pagination=" . $i . "'>" . $i . "</a></li>";
    }
    $con->close();
}

<?php
$rootdir = dirname(__FILE__);

require_once $rootdir."/../connection.php";
require_once $rootdir."/insert.php";
require_once $rootdir."/get.php";

function updateContactId($user, $id, $alias, $phone, $email, $fname, $ptype, $nocheck)
{
    $con = connectMySQL();
    $alias = sanitizeReturn($alias, true);
    $phone = sanitizeReturn($phone, true);
    $email = sanitizeReturn($email, true);
    $fname = sanitizeReturn($fname, true);
    $ptype = sanitizeReturn($ptype, true);
    $user = sanitizeReturn($user, true);
    $id = sanitizeReturn($id, true);

    if ($nocheck == true) {
        if (checkContactId($user, $id)) {

            $sql = "UPDATE contacts SET alias = ?,phone = ?,email = ?,fullname = ?,phonetype = ? WHERE id = ? AND BINARY for_user = ?";

            // * Prepared statements and execute!
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssssss", $alias, $phone, $email, $fname, $ptype, $id, $user);

            if (checkContactAlias($alias, getLoggedUser()) == false) {
                if ($stmt->execute()) {
                    $con->close();
                    return true;
                } else {
                    $con->close();
                    logAction("Failed", "$alias failed to update.", getLoggedUser());
                    return false;
                }
            } else {
                return false;
            }

        } else {
            $con->close();
            return false;
        }
    } else {
        $sql = "UPDATE contacts SET alias = ?,phone = ?,email = ?,fullname = ?,phonetype = ? WHERE id = ? AND BINARY for_user = ?";

        // * Prepared statements and execute!
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssss", $alias, $phone, $email, $fname, $ptype, $id, $user);
        if ($stmt->execute()) {
            $con->close();
            return true;
        } else {
            $con->close();
            return false;
        }
    }
}

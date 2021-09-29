<?php

function deleteContact($user, $id) {
    $con = connectMySQL();
    
    $id = sanitizeReturn($id, true);

    $sql = "DELETE FROM contacts WHERE BINARY for_user = ? AND id = ?";
    
    // * Prepared statements and execute!
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $user, $id);
    
    if ($stmt->execute()) {
        $con->close();
        return true;
    } else {
        $con->close();
        return false;
    }
    $con->close();
}
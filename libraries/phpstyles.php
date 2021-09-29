<?php

function phpstyle_alert($message, $type) {
    # Sanitize inputs.
    $message = htmlspecialchars($message);
    $type = htmlspecialchars($type);
    if ($type == "danger") {
        return "<div class='alert alert-danger'>".$message."</div>";
    } else if ($type == "success") {
        return "<div class='alert alert-success'>".$message."</div>";
    } else if ($type == "secondary") {
        return "<div class='alert alert-secondary'>".$message."</div>";
    } else if ($type == "primary") {
        return "<div class='alert alert-primary'>".$message."</div>";
    } else {
        return "<div class='alert alert-danger'>".$message."</div>";
    }
}
?>
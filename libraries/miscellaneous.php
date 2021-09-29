<?php
function generateRandomSalt() {
    $contents = "abcdefghijklmnopqrstuvwy1234567890";
    $saltLength = 16;
    $randstr = "";
    for ($i = 0; $i < $saltLength; $i++) {
        $randstr .= $contents[random_int(0, strlen($contents))];
    }
    return $randstr;
}
?>
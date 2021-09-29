<?php
define("MYSQL_USERNAME", "contactbook");
define("MYSQL_PASSWORD", "E-jjmsHe[![.6zz0");
define("MYSQL_HOST", "127.0.0.1");
define("MYSQL_DATABASE", "contactbook");


function connectMySQL() {
    return mysqli_connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
}

if (!connectMySQL()) {
    die("No Connection.");
}
?>

<!-- @Gorpo Orko - 2020 -->

<?php
$host = "localhost";
$root = "root";
$root_password = "";
$db = "csc_site";

try {
    $dbh = new PDO("mysql:host=$host", $root, $root_password);

    $dbh->exec("CREATE DATABASE IF NOT EXISTS `$db`;");
    $dbh->exec("CREATE DATABASE IF NOT EXISTS `csc_chat`;");
}
catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}

?>
<?php
require("./includes\secret.php");
$host = '127.0.0.1';
$db = 'test';
$charset = 'utf8';
$dsn = "mysql: host=$host;dbname=$db;charset=$charset";



$options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$options[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
$options[PDO::ATTR_EMULATE_PREPARES] = false;
try {
$pdo = new PDO($dsn, $user, $pwd, $options);
} catch (PDOException $e) {
    echo $e->getMessage();
throw new PDOException($e->getMessage(), (int)$e->getCode());
}
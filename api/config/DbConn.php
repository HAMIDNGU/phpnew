<?php

class DbConn {
    private static $host, $user, $pass, $charset, $db, $pdo;    
    public static function init($host, $user, $pass, $charset, $db ="") {
        DbConn::$host = $host;
        DbConn::$user = $user;
        DbConn::$pass = $pass;
        DbConn::$charset = $charset;
        DbConn::$db = $db;
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $options[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
        $options[PDO::ATTR_EMULATE_PREPARES] = false;        
        DbConn::$pdo = new PDO($dsn, $user, $pass, $options);
    }

    public static function getPDO() {
        return DbConn::$pdo;
    }
}
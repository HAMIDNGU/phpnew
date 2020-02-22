<?php
require_once('i./ncludes/secret.php');

class Database{
$host = '127.0.0.1';
$db = 'communitain';
$charset = 'utf8';
$dsn = "mysql: host=$host;dbname=$db;charset=$charset";

$conn;

    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=".$this->host.";charset=".$this->charset.";dbname=".$this->$dbname, $this->username, $this->pwd);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: ".$exception->getMessage();
        }

        return $this->conn;
    }
}
?>


<?php
require_once('../includes/DbConn.php');
require_once('../includes/secret.php');
DbConn::init("127.0.0.1",$username,$pwd,'utf8mb4','communitain');
$pdo = DbConn::getPDO(); 
$query = $pdo->prepare("SELECT id,`name` FROM `category` ORDER BY `modified` DESC;");
$query->execute();
$qty = $query->rowCount();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    for($i = 0; $i < $qty; ++$i){
    $id = $row['id'];
    $name = $row['name'];
    echo "<div> <h4> $name </h4> <img src='categoryPhoto.php?id=$id />";
    }
}





?>
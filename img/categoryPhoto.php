<?php

require_once('../includes/DbConn.php');
require_once('../includes/secret.php');
DbConn::init("127.0.0.1",$username,$pwd,'utf8mb4','communitain');
$pdo = DbConn::getPDO(); 
$query = $pdo->prepare("SELECT * FROM `category` WHERE id = ?");
$query->bindParam(1, $_GET['id']);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
header("content-type:image/png");
echo $row['catImage'];
exit;

?>

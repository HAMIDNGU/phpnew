<?php
require_once('./includes/DbConn.php');
require_once('./includes/secret.php');
DbConn::init("127.0.0.1",$username,$pwd,'utf8mb4','communitain');
$pdo = DbConn::getPDO(); 
$query = $pdo->prepare("SELECT id,`name` FROM `category` ORDER BY `modified` DESC;");
$query->execute();
$qty = $query->rowCount();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    for($i = 0; $i < $qty; ++$i){
    $id = $row['id'];
    $name = $row['name'];
    if($i%2 == 0) {
    echo "<div>";
    echo "<img src='./img/categoryPhoto.php?id=$id />";
    echo '<h4><a href="../phpnew/?p=home">'. $name .'</a></h4>';
    echo "</div>";
    }

    }
}





?>
<?php

include('./includes\component\Menu.php');
include('./includes\DbConn.php');
include('./includes\secret.php');

DbConn::init("127.0.0.1",$user,$pwd,'utf8mb4','communitain');
$qGetVisit = DbConn::getPDO()->query('SELECT count(*) as submissions FROM submission');


$menuObj = new Menu("main-menu");
$menuObj->addItem("Home","default");
$menuObj->addItem("Map","map",1);
$menuObj->addItem("Buy Tarps","products",-1);
echo $menuObj->render();

while($row = $qGetVisit->fetch()) {
    echo "<br />{$row['submissions']}";
}

$menuObj->setDesc(false);
$menuObj->addItem("Emus","miniostriches",1);
echo $menuObj->render();



?>
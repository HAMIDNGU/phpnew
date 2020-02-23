<?php

include('./includes\component\Menu.php');
include('./api\config\DbConn.php');
require_once('./api\config\secret.php');
require_once("./includes\init.php");
DbConn::init("127.0.0.1",$username,$pwd,'utf8mb4','communitain');

$qGetMenuItems = DbConn::getPDO()->query('SELECT `title`, `page_key` FROM `menu`');


$menuObj = new Menu("main-menu");
$menuItems = [];
$menuKey = [];

while($row = $qGetMenuItems->fetch()) {
    array_push($menuItems, $row['title']);
    array_push($menuKey, $row['page_key']);
}

for ($i=0;$i < count($menuItems); ++$i) { 
        $menuObj->addItem($menuItems[$i],$menuKey[$i] );
}


echo $menuObj->render();

              echo "<h2>{$pageDetails['title']}</h2>";
              echo "<p>{$pageDetails['content']}</p>"





?>
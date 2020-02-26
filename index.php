<?php

include('./includes\class\Menu.php');
require_once('./includes\secret.php');
require_once("./includes\init.php");

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

include_once("./includes/static/header.php");
echo $menuObj->render();

?>
</header>
<main>
    <?php
            
            include('userManage.php');
        
              echo "<h2>{$pageDetails['title']}</h2>";
              echo eval('?> ' ."{$pageDetails['content']}".' <?php ');
include_once("./includes/static/footer.php");

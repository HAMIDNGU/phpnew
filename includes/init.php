<?php
 require_once('./api\config\DbConn.php');

$page = 'home';
DbConn::init("127.0.0.1",$username,$pwd,'utf8mb4','communitain');
$qPages = DbConn::getPDO()->query('SELECT `title`, `page_key` FROM `menu`');

$pages = [];

while ($row = $qPages->fetch()) {
    $pages[$row['page_key']] = $row['title'];
}

if(isset($_GET['p'])) {
    $tmp_page = strtolower($_GET['p']);
    if(array_key_exists($tmp_page,$pages)) {
        $page = $tmp_page;
    }
}

$pQuery =  DbConn::getPDO()->prepare('SELECT title, content FROM '.
        'menu WHERE page_key = ?');
$pQuery->execute([$page]);
$pageDetails = $pQuery->fetch();
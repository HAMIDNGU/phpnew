<?php
 require_once __DIR__ .('./DbConn.php');
 require_once __DIR__ .('./class/User.php');
 require_once __DIR__ .('./secret.php');

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

$res = null;
if(isset($_POST['username']) && isset($_POST['pass']) 
&& isset($_POST['action']) && $_POST['action'] === 'login') {
    $res = User::loginWithPassword($_POST['username'],$_POST['pass']);
} else if(isset($_COOKIE['ch']) && isset($_COOKIE['u'])){
    $res = User::loginWithCookie($_COOKIE['u'],$_COOKIE['ch']);
}

if(isset($res) && $res['status'] === true) {
    setcookie('ch',$res['cookie'], time()+60*60*24*3);
    setcookie('u', $res['user']['username'],time()+60*60*24*3);
}
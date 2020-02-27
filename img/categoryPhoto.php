<?php
require_once('./includes/init.php');
DbConn::init("127.0.0.1",$username,$pwd,'utf8mb4','category');
require_once('./includes/class/User.php');

$user = null;
if(isset($_REQUEST['u']))
{
    
    $user = strtolower(trim(strip_tags($_REQUEST['u'])));
    
    $photo = Category::getCategoryPhoto($user);
    if(isset($photo)) {
        header("content-type: {$photo['picType']}");
        echo base64_decode($photo['pic']);
    } else {
        header("content-type: image/png");
        require_once('../img/default.png');
    }
}

<?php
require_once __DIR__ .('./includes/init.php');

    if(isset($user)) {
        echo $user['msg'];
    }
    include __DIR__ .('/userManage.php');
    header("Location: ../?p=contribute");
   exit;
?>


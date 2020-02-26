<?php
require_once __DIR__ .('./includes/init.php');

    if(isset($user)) {
        echo $user['msg'];
    }
    include __DIR__ .('/userManage.php');
    header("Location: http://localhost:5000/projects/phpnew/?p=contribute");
   exit;
?>


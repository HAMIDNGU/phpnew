<?php
require_once __DIR__ .('./init.php');

    if(isset($res)) {
        echo $res['msg'];
    }
    include __DIR__ .('./userManage.php');
    header("Location: http://localhost:5000/projects/phpnew/?p=contribute");
   exit;
?>


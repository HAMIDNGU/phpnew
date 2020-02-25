<?php
require_once __DIR__ .('./init.php');

    if(isset($res)) {
        echo $res['msg'];
    }
       header("Location: http://localhost:5000/projects/phpnew/?p=contribute");
   exit;
?>


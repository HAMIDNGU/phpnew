<?php
require_once('./includes/init.php');
include('./userManage.php');

if(isset($_POST['username']) && isset($_POST['pass']) &&  isset($_POST['pass_re']) && 
        ($_POST['pass'] === $_POST['pass_re'])
    ) {
        $userult = User::create($_POST['username'],$_POST['pass']);
        echo $userult['msg'];
    } else {
    }
    header("Location: ./?p=login");
   exit;
?>

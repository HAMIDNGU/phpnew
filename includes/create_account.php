<?php
include __DIR__ .('./init.php');

            include __DIR__ .('./userManage.php');

        if(isset($user)) {
            echo $user['user']['name'].':'.$user['msg'];
        }
    if(isset($_POST['username']) && isset($_POST['pass']) && 
        isset($_POST['pass_re']) && 
        ($_POST['pass'] === $_POST['pass_re'])
    ) {

        $userult = User::create($_POST['username'],$_POST['pass']);

        echo $userult['msg'];
    } else {

?>
        <?php } ;
   exit;?>
        


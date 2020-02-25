<?php
include __DIR__ .('./init.php');


        if(isset($res)) {
            echo $res['username'].':'.$res['msg'];
        }
    if(isset($_POST['username']) && isset($_POST['pass']) && 
        isset($_POST['pass_re']) && 
        ($_POST['pass'] === $_POST['pass_re'])
    ) {

        $result = User::create($_POST['username'],$_POST['pass']);

        echo $result['msg'];
    } else {

?>
        <?php }        header("Location: http://localhost:5000/projects/phpnew/?p=contribute");
   exit;?>
        


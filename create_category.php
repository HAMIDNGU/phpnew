<?php
require_once('./includes/init.php');
include('./includes/class/category.php');

if(isset($_POST['category']) && isset($_POST['description'])
    ) {
        $cateult = Category::create($_POST['category'],$_POST['description']);
        echo $userult['msg'];
    } else {
        echo "whoops";
    }
   /* header("Location: ./?p=contribute");
   exit; */
?>

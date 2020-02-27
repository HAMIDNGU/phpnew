<?php
require_once('../inc/DbConn.php');
DbConn::init("127.0.0.1",'bob','62grI$BVupUc','utf8mb4','cisc');
require_once('../inc/User.php');

$user = null;
if(isset($_REQUEST['u']))
{
    
    $user = strtolower(trim(strip_tags($_REQUEST['u'])));
    
    $photo = User::getProfilePhoto($user);
    if(isset($photo)) {
        header("content-type: {$photo['picType']}");
        echo base64_decode($photo['pic']);
    } else {
        header("content-type: image/png");
        require_once('../img/default.png');
    }
}
// else {
//     header("content-type: image/png");
//     require_once('./img/default.png');
// }
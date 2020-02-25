<div id="login-control">
    <?php
    if(isset($user) && $user['status']) {
        echo "Logged in as: {$user['user']['username']} ".
        "<a href=\"?logout\">Logout</a>";
    } else {
?>
    Not logged in <a href="?p=login">Login</a>
    <?php } ?>
</div>
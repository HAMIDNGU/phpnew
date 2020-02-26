<div id="login-control">
    <?php
    if(isset($user) && $user['status']) {
        echo "Logged in as: {$user['user']['username']} ".
        "<a href=\"?logout\">Logout</a>";
    } else {
?>
    <p id="InOrOut">Not logged in <a href="?p=login">Login</a></p>
    <?php } ?>
</div>
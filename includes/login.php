<?php
require_once('./inc/init.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<?php 
if(isset($result)){
    echo $result['msg'];
}
?>
    <form action="login.php" method="post">
                <div>
                <div>Username: </div>
                <div>
                    <input type="text" name="username" />
                </div>
                <div>Password: </div>
                <div>
                    <input type="password" name="pass" />
                </div>
                </div>
                <input type="hidden" name="action" value="login"/>
                <input type="submit" value="Login" name="submit" />
            </div>
        </form>
</body>
</html>
<?php
include('init.php');
?>

        <h2>Sign Up!</h2>
        <?php
    if(isset($_POST['username']) && isset($_POST['pass']) && 
        isset($_POST['pass_re']) && 
        ($_POST['pass'] === $_POST['pass_re'])
    ) {

        $result = User::create($_POST['username'],$_POST['pass']);

        echo $result['msg'];
    } else {

?>
        <form action="create_account.php" method="post">
            <div>
                <div>Username: </div>
                <div>
                    <input type="text" name="username" />
                </div>
                <div>Password: </div>
                <div>
                    <input type="password" name="pass" />
                </div>
                <div>Re-enter Password: </div>
                <div>
                    <input type="password" name="pass_re" />
                </div>

                <input type="submit" value="Create" name="submit" />
            </div>
        </form>
        <?php } ?>

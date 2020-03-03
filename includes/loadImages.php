<?php
require_once("init.php");

DbConn::getPDO()->prepare('SELECT `name`,`catImagePath`,`description` FROM `category`');



?>
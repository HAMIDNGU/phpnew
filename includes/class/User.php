<?php

class User {

    static function isUser($username) {
        $pdo = DbConn::getPDO();
        // SELECT `userId` FROM `user` WHERE username = 'bob' 
        $q = $pdo->prepare("SELECT `userId` FROM `user` WHERE username = ?");
        $q->execute([$username]);
        if(!empty($q->rowCount())) {
            return true;
        }
        return false;
    }

    static function create($username, $password) {
        $pdo = DbConn::getPDO();
        // [msg,status]
        if(User::isUser($username)) {
            return ["msg" => "User <em>$username</em> already exists",
                    "status"=>false];
        } 
        $passHash = password_hash($password, PASSWORD_BCRYPT);
        $salt = '';
        

        $q = $pdo->prepare(
            "INSERT INTO `user` (`username`, `passHash`,`nacl`) VALUES (?, ?, ?); ");
        $q->execute([$username,$passHash,$salt]);
        if(!empty($q->rowCount())) {
            return ["msg" => "User <em>$username</em> created",
                    "status"=>true];
        }
    
        return ["msg" => "Could not create User <em>$username</em>",
            "status"=>false];
    }

    static function loginWithCookie($username, $cookie) {
        $pdo = DbConn::getPDO();
        $q = $pdo->prepare("SELECT username, cookieHash FROM user WHERE username = ?");
        $q->execute([$username]);

        if(!empty($q->rowCount())) {
            $row = $q->fetch();

            if(password_verify($cookie, $row['cookieHash'] )) {
              return ['msg'=>"$username logged in", 'status'=>true,'cookie'=>$cookie];  
            }
        }

        return ['msg'=>"Could not log in", 'status'=>false]; 
    }

    static function loginWithPassword($username, $password) {
        $pdo = DbConn::getPDO();
        $q = $pdo->prepare("SELECT username, passHash, nacl FROM user WHERE username = ?");

        $q->execute([$username]);

        if(!empty($q->rowCount())) {
            $row = $q->fetch();
           
            if(password_verify($password,$row['passHash'])) {
                $cookie = bin2hex(random_bytes(10));
                $cookieHash = password_hash($cookie,PASSWORD_BCRYPT);
                
                // UPDATE `user` SET `cookieHash` = 'x' WHERE username = 'x'; 
                $pdo->query("UPDATE `user` SET `cookieHash` = '$cookieHash' WHERE username = '$username';");

                return ['msg'=>"$username logged in", 'status'=>true,'cookie'=>$cookie];
            }
        }

        return ['msg'=>"Could not log in", 'status'=>false];      

    }

}
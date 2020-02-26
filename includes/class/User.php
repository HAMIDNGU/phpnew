<?php

class User {


    // returns true if $username exists in the user table
    static function isUser($username) {
        $pdo = DbConn::getPDO(); // get a reference to the database connection
        
        // prepare SQL to get a username
        $q = $pdo->prepare("SELECT `userId` FROM `user` WHERE username = ?");
        $q->execute([$username]); // execute with the provided $username
        if(!empty($q->rowCount())) { // check if there are any results/error
            return true; 
        }
        return false;
    }

    // creates a user in the user table, with the
    // specified $username and $password
    // returns an associative array with keys msg and status
    // status is true if the user was added
    static function create($username, $password) {
        $pdo = DbConn::getPDO();
        // [msg,status]
        // check to see if user exists
        if(User::isUser($username)) {
            return ["msg" => "User <em>$username</em> already exists",
                    "status"=>false];
        } 

        // generate a password hash (non-reversible 
        // transform from password)
        $passHash = password_hash($password, PASSWORD_BCRYPT);
        $salt = ''; // currently unused
        
        // prepare insert
        $q = $pdo->prepare(
            "INSERT INTO `user` (`username`, `passHash`,`nacl`) VALUES (?, ?, ?); ");
        // execute insert with values
        $q->execute([$username,$passHash,$salt]);
        
        if(!empty($q->rowCount())) { // check result
            return ["msg" => "User <em>$username</em> created",
                    "status"=>true];
        }
    
        // failed
        return ["msg" => "Could not create User <em>$username</em>",
            "status"=>false];
    }

    // login with cookie values
    static function loginWithCookie($username, $cookie) {
        $pdo = DbConn::getPDO();
        // get the user to check cookie "password" with
        $q = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $q->execute([$username]);

        if(!empty($q->rowCount())) {
            // if the user exists 
            $row = $q->fetch(); // get the first (only) row of data
            // check that the cookie matches the stored cookie hash
            // created at login
            if(password_verify($cookie, $row['cookieHash'] )) {
              return ['msg'=>"$username logged in", 'status'=>true,'cookie'=>$cookie,'user'=>$row];  
            }
        }
        // failed
        return ['msg'=>"Could not log in", 'status'=>false]; 
    }

    // login with unhashed password
    static function loginWithPassword($username, $password) {
        $pdo = DbConn::getPDO();
        // get the user to check password with
        $q = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $q->execute([$username]);

        if(!empty($q->rowCount())) {
            // if the user exists
            $row = $q->fetch(); // get the first (only) row of data
            
            // check that the password matches the stored password hash
            if(password_verify($password,$row['passHash'])) {

                // create a random cookie value and its hash
                $cookie = bin2hex(random_bytes(10));
                $cookieHash = password_hash($cookie,PASSWORD_BCRYPT);
               
                // update the record with the cookie
                // can only have persistent login from 1 client
                $pdo->query("UPDATE `user` SET `cookieHash` = '$cookieHash' WHERE username = '$username';");

                return ['msg'=>"$username logged in", 'status'=>true,'cookie'=>$cookie, 'user'=>$row];
            }
        }

        return ['msg'=>"Could not log in", 'status'=>false];      

    }

}
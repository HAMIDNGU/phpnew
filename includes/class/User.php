<?php



class User {

        static function setProfilePhoto($username, $data, $type) {
         $pdo = DbConn::getPDO(); 
         $r = $pdo->query("UPDATE `users` SET pic = '$data', picType='$type' WHERE username = '$username'");
         return ["result"=>$r];
    }

    static function getProfilePhoto($username) {
         $pdo = DbConn::getPDO(); 
         $r = $pdo->query("SELECT `pic`,`picType` FROM `users` WHERE username = '$username'");
         if(!empty($r->rowCount())) {
            $row = $r->fetch();
            if(isset($row['pic']) && isset($row['picType'])) {
                return $row;
            }
         }
         
    }

    // returns true if $username exists in the user table
    static function isUser($username) {
        $pdo = DbConn::getPDO(); // get a reference to the database connection
        
        // prepare SQL to get a username
        $q = $pdo->prepare("SELECT `userId` FROM `users` WHERE username = ?");
        $q->execute([$username]); // execute with the provided $username
        if(!empty($q->rowCount())) { // check if there are any results/error
            return true; 
        }
        return false;
    }

    // creates a user in the users table, with the
    // specified $username and $password
    // returns an associative array with keys msg and status
    // status is true if the user was added
    static function create($username, $password) {
        $pdo = DbConn::getPDO();
        $username = trim(strtolower($username));
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
            "INSERT INTO `users` (`username`, `passHash`,`nacl`) VALUES (?, ?, ?); ");
        // execute insert with values
        $q->execute([$username,$passHash,$salt]);
        
        if(!empty($q->rowCount())) { // check result
            
            User::uploadImage($username);
            return ["msg" => "User <em>$username</em> created",
                    "status"=>true,"username"=>$username];
        }
    
        // failed
        return ["msg" => "Could not create User <em>$username</em>",
            "status"=>false];
    }

    // login with cookie values
    static function loginWithCookie($username, $cookie) {
        $pdo = DbConn::getPDO();
        // get the user to check cookie "password" with
        $q = $pdo->prepare("SELECT * FROM users WHERE username = ?");
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
        $q = $pdo->prepare("SELECT * FROM users WHERE username = ?");
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
                $pdo->query("UPDATE `users` SET `cookieHash` = '$cookieHash' WHERE username = '$username';");

                return ['msg'=>"$username logged in", 'status'=>true,'cookie'=>$cookie, 'user'=>$row];
            }
        }

        return ['msg'=>"Could not log in", 'status'=>false];      

    }

    static function uploadImage($username) {
        if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

            $tmp_name = $_FILES['file']['tmp_name'];
            $fileInfo = new finfo(FILEINFO_MIME_TYPE);
            $type = $fileInfo->file($tmp_name);
            //echo $type;

            $ext = '';
            $fileResource = null;
            $imageFunc = "";

            switch ($type) {
                case 'image/png':
                    $ext = '.png';
                    $fileResource = imagecreatefrompng($tmp_name);
                $imageFunc = 'imagepng';
                break;
                case 'image/jpeg':
                    $ext = '.jpg';
                    $fileResource = imagecreatefromjpeg($tmp_name);
                    $imageFunc ='imagejpeg';
                break;
            }



            if($ext !== '') {
                $sourceProperties = getimagesize($tmp_name);
                $ratio = $sourceProperties[0]/$sourceProperties[1];
                $targetHeight = 250;
                $targetWidth = $targetHeight*$ratio;
                $targetWidth = $targetWidth > 3*$targetWidth ? 3*$targetWidth : $targetWidth;
                $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
                imagecopyresampled($targetLayer,$fileResource,0,0,0,0,$targetWidth,$targetHeight, $sourceProperties[0],$sourceProperties[1]);

                ob_start();
                call_user_func($imageFunc, $targetLayer);
                $fileContents = ob_get_contents();
                ob_end_clean();
                
                $fileContents = base64_encode($fileContents);
                User::setProfilePhoto($username,$fileContents,$type);            
            }
        }
    }

}
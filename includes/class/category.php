<?php

class Category {

        static function isCategory($category) {
        $pdo = DbConn::getPDO(); // get a reference to the database connection
        
        // prepare SQL to get a category
        $q = $pdo->prepare("SELECT `id` FROM `category` WHERE category = ?");
        $q->execute([$category]); // execute with the provided $category
        if(!empty($q->rowCount())) { // check if there are any results/error
            return true; 
        }
        return false;
    }

        static function setCategoryPhoto($name, $data, $type) {
         $pdo = DbConn::getPDO(); 
         $r = $pdo->query("UPDATE `category` SET catImage = '$data', picType='$type' WHERE name = '$name'");
         return ["result"=>$r];
    }

static function uploadImage($category) {
        if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

            $tmp_name = $_FILES['file']['tmp_name'];
            $fileInfo = new finfo(FILEINFO_MIME_TYPE);
            $type = $fileInfo->file($tmp_name);

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
                Category::setCategoryPhoto($category,$fileContents,$type);            
            }
        }
    }
     static function create($category, $description) {
        $pdo = DbConn::getPDO();
        $category = trim(strtolower($category));
        // [msg,status]
        // check to see if category exists
        if(Category::isCategory($category)) {
            return ["msg" => "Category <em>$category</em> already exists",
                    "status"=>false];
        }
        
        // prepare insert
        $q = $pdo->prepare(
            "INSERT INTO `category` (`name`, `description`) VALUES (?, ?); ");
        // execute insert with values
        $q->execute([$category,$description]);
        
        if(!empty($q->rowCount())) { // check result
            
            Category::uploadImage($category);
            return ["msg" => "Category <em>$category</em> created",
                    "status"=>true,"Category"=>$category];
        }
    
        // failed
        return ["msg" => "Could not create Category <em>$category</em>",
            "status"=>false];
    }

}

    
?>
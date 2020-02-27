   <?php

   class Category {

   
   static function setCategoryPhoto($catName, $data, $type) {
         $pdo = DbConn::getPDO(); 
         $r = $pdo->query("UPDATE `category` SET catImage = '$data', picType='$type' WHERE `name` = '$catName'");
         return ["result"=>$r];
    }

    static function getCategoryPhoto($catName) {
         $pdo = DbConn::getPDO(); 
         $r = $pdo->query("SELECT `pic`,`picType` FROM `category` WHERE name = '$catName'");
         if(!empty($r->rowCount())) {
            $row = $r->fetch();
            if(isset($row['pic']) && isset($row['picType'])) {
                return $row;
            }
         }
         
    }
     static function uploadImage($catName) {
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
                Category::setCategoryPhoto($catName,$fileContents,$type);            
            }
        }
    }
}
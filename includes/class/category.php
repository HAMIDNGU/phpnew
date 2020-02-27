<?php

//Store the upload form
$UploadForm = " <form id='idForm' action='upload.php' method='post' enctype='multipart/form-data'>
                    <input type='file' name='image'/><br/><br/>
                    <input id='BTN' type='submit' value='Upload'/><br/><br/>
            </form>";
//if logged in show the upload form
if($userid && $username){
    echo $UploadForm;
// Connect to database
$con = mysqli_connect('***', '***', '***', '***_dbimage');
// Check connection
if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

//file properties
if(isset($_FILES['image'])){
    $file = $_FILES['image']['tmp_name'];
}

//if image selected
if(isset($file) && $file != ""){
    $image = mysqli_real_escape_string($con,file_get_contents($_FILES['image']['tmp_name']));
    $image_name = addslashes($_FILES['image']['name']);
    $image_size = getimagesize($_FILES['image']['tmp_name']);

    if($image_size == FALSE){
        echo "That's not an image!";
        header( "refresh:2;url=upload.php" );
    }
    else{
        $qry = mysqli_query($con,"SELECT * FROM store WHERE name='$image_name'");
        $Nrows = $qry->num_rows;
        if( $Nrows == 0){
            if(!$insert = mysqli_query($con,"INSERT INTO store VALUES     ('','$image_name','$username','$image')")){
            echo "We had problems uploading your file!";
            header( "refresh:2;url=upload.php" );
        }
        else{
            echo "Image $image_name uploaded!";
            header( "refresh:2;url=upload.php" );
        }
    }
    else{
        echo "There is already an image uploaded with the name $image_name<br/>";
    }
}
}   
else{
    echo "Please select an image";
}
mysqli_close($con);
}
else{
    echo "You have to be logged in to upload!";
}
?>
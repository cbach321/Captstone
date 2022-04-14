<?php

if(isset($_POST['submit'])) {
    $file = $_FILES['file'];
  
     $fileName = $_FILES['file']['name'];
     $fileTmpName = $_FILES['file']['tmp_name'];
     $fileSize = $_FILES['file']['size'];
     $fileError = $_FILES['file']['error'];
     $fileType = $_FILES['file']['type'];
    
    $fileExt = explode('.', $fileName);
    $fileActual = strtolower(end($fileExt));
    
    $allow = array( 'pdf' ); 
    
    if (in_array($fileActual, $allow )) {
        if($fileError === 0){
            if($fileSize < 500000){
             $fileNewName = uniqid('', true).".".$fileActual;  
                $fileDest = 'Uploads/'.$fileNewName;
                move_uploaded_file($fileTmpName, $fileDest);
                header("Location: CreateProfile.html?uploadsuccess");
            } else {
                echo "Your file is too large to upload";
            }
            
        } else {
            echo "There was an error uploading your file";
        }
    } else {
        echo "You cannot upload this file type. Please try again";
    }
}



?>
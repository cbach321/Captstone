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
                
                //1. upload files API call
                $api_base_url = 'https://app.butlerlabs.ai/api';
                $api_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJhdXRoMHw2MjMzODU1OGJjNGI2ZTAwNzA4MGE4NzUiLCJlbWFpbCI6InNtd2lsc29uQG1haWwubWlzc291cmkuZWR1IiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImlhdCI6MTY0NzU0MzczOTYyOH0.4l3d5GUS32OJSESncLBP1pzNM1rzxuL7reLXjehPS48';
                $queue_id = '81d72737-49eb-4855-8974-8a3087935e48';
                $file_location = $fileDest; //this needs to be the path to the actual file that was uploaded, but unsure of how to get the exact path. 
                //2. Poll on the GET results endpoint (inside a while loop)
                $mimes = array( 
                  IMAGETYPE_JPEG => "image/jpg", 
                  IMAGETYPE_PNG => "image/png", 
                  PDF => "application/pdf" 
                ); 
                $image_type = exif_imagetype($image_path); 
                $mime_type = $mimes[$image_type]; 
                $info = pathinfo($file); 
                $name = $info['basename']; 
                $curl_file = new CURLFile($file, $mime_type, $name);
                
                $post_fields = $post_fields = [ 'files' => [ $curl_file ] ];

                $url = $api_base_url . '/queues/' . $queue_id . '/uploads';
                $ch = curl_init();
                curl_setopt_array($ch, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => TRUE,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => TRUE,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => $post_fields,
                  CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . 'Bearer ' . $api_key,
                    'Accept: */*',  //dont forget you added an extra line here, remove later 
                    'Content-Type: multipart/form-data',
                  ),
                )); 
                $result = curl_exec($ch);
                curl_close($ch); 

                //3. once results are retrieved, upload them to firebase 
                // Step 1 - Upload Files to Butler
                
                $upload_id = $result['uploadId'];
                $result_api_url = $url = $api_base_url . '/queues/' . $queue_id . '/uploads?uploadId=' . $upload_id;

// Poll on results until finished
/*$extraction_results = NULL;

while ($extraction_results == NULL) {
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $resp = curl_exec($curl);

  $file_results = $resp['items'][0];
  if ($file_results['documentStatus'] == 'Completed') { 
    // If results are finished, set extraction results and exit while loop 
    $extraction_results = $file_results;
  } else {
    // If results aren't finished, sleep for 5 sections
    sleep(5);
  }
  curl_close($curl);
} */


                
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
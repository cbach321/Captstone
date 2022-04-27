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
    error_log("hello");
    $allow = array( 'pdf' ); 
    
    if (in_array($fileActual, $allow )) {
        if($fileError === 0){
            if($fileSize < 500000){
            $fileNewName = uniqid('', true).".".$fileActual;  
            $fileDest = 'Uploads/'.$fileNewName;
                
                move_uploaded_file($fileTmpName, $fileDest);
               // header("Location: CreateProfile.html?uploadsuccess"); //pls add this back in after testing 
                //echo($fileDest);
                
                //1. upload files API call
                $api_base_url = 'https://app.butlerlabs.ai/api';
                $api_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJhdXRoMHw2MjMzODU1OGJjNGI2ZTAwNzA4MGE4NzUiLCJlbWFpbCI6InNtd2lsc29uQG1haWwubWlzc291cmkuZWR1IiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImlhdCI6MTY0NzU0MzczOTYyOH0.4l3d5GUS32OJSESncLBP1pzNM1rzxuL7reLXjehPS48';
                $queue_id = '81d72737-49eb-4855-8974-8a3087935e48';
                $file_location = $fileDest; //this needs to be the path to the actual file that was uploaded, but unsure of how to get the exact path. 
                //2. Poll on the GET results endpoint (inside a while loop)
                
                $mime_type = "application/pdf"; 
                //$info = pathinfo($file); 
                //$name = $info['basename']; 
                $curl_file = new CURLFile($fileDest, $mime_type, $fileName);
                
                //$post_fields = [ 'files' => [ $curl_file ] ];
                $post_fields = array ('files' => $curl_file);


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
                    //'Accept: */*',  //dont forget you added an extra line here, remove later 
                   //'Content-Type: multipart/form-data',
                      
                  ),
                )); 
                $result = curl_exec($ch);
                curl_close($ch); 

                //3. once results are retrieved, upload them to firebase 
                // Step 1 - Upload Files to Butler
                
                $upload_id = $result['uploadId'];
                error_log($result);
                //$result_api_url = $url = $api_base_url . '/queues/' . $queue_id . '/uploads?uploadId=' . $upload_id;

// Poll on results until finished
     $result_api_url = $api_base_url . '/queues/' . $queue_id . '/extraction_results?uploadId=' . $upload_id;


                     $extraction_results = NULL;

                while ($extraction_results == NULL) {
                $result_curl = curl_init();
                    
                curl_setopt_array($result_curl, array(
                CURLOPT_URL => $result_api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HEADER => false,
                CURLOPT_HTTPHEADER => array( 'Authorization: ' . 'Bearer ' . $api_key, ),
                CURLOPT_USERAGENT => 'curl/7.54'
                ));

                $response = json_decode(curl_exec($result_curl), true);

                var_dump($response);
                error_log($response);
                  // Get the extraction results from the API response

                $results = $response['items'][0];

                // If the extraction results API is finished, set the $extraction_results

                if ($results['documentStatus'] == 'Completed') {
                $extraction_results = $results;
                } else {

            // If they are still in progress, sleep for 5 seconds, then call again
            echo('Sleeping for 5 seconds. Status: ' . $results['documentStatus']); sleep(5);
                }

            }

            echo('Results: ' . $extraction_results);
            error_log($extraction_results);      
                
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
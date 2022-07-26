<?php
include_once 'config.php';
if (file_exists('/app/vendor/samayo/bulletproof/src/bulletproof.php')) {
    require_once('/app/vendor/samayo/bulletproof/src/bulletproof.php');
    require_once('/app/vendor/autoload.php');
} else {
    require_once(__DIR__ . '/../../../vendor/samayo/bulletproof/src/bulletproof.php');
    require_once(__DIR__ . '/../../../vendor/autoload.php');
}
require_once(__DIR__ . '/../../../lib/functions.php');
// $action = filter_var(trim($_REQUEST['action']), FILTER_SANITIZE_STRING);
$action = $_REQUEST['action'];
if ($action == 'upload') {
    error_log("Uploading file " . var_export($_FILES, true));
    $temp_name = $_FILES['image']['tmp_name'];
    error_log('Image: ' . $temp_name);
    //Create Bulletproof object
    $image = new Bulletproof\Image($_FILES);
    //set temp location to store image
    $image->setLocation('../Images/');
    //set name of image
    $image->setName('TempFile');
    //upload image
    if ($image['image']) {
        //if image uploaded successfully
        $upload = $image->upload();
        if ($upload) {
            $newPath = $image->getFullPath();
            $response['code'] = "200";
            if ($_FILES['image']['error'] != 4) {
                //set which bucket to work in
                $bucketName = "myshop_bucket";
                // get local file for upload testing
                $fileContent = fopen($temp_name, 'r');
                error_log("File content: " . var_export($fileContent, true));
                // NOTE: if 'folder' or 'tree' is not exist then it will be automatically created !
                $cloudPath = 'uploads/' . $_POST['name'];

                $isSucceed = uploadFile($bucketName, $fileContent, $cloudPath);

                if ($isSucceed == true) {
                    $response['msg'] = 'SUCCESS: to upload ' . $cloudPath . PHP_EOL;
                    flash("Uploaded image", "success");
                    // TEST: get object detail (filesize, contentType, updated [date], etc.)
                    $response['data'] = getFileInfo($bucketName, $cloudPath);
                } else {
                    $response['code'] = "201";
                    $response['msg'] = 'FAILED: to upload ' . $cloudPath . PHP_EOL;
                    flash("Error uploading image", "danger");
                }
            }
            header("Content-Type:application/json");
            echo json_encode($response);
            //Delete the temp file created by Bulletproof
            unlink($newPath);
            exit();
        } else {
            //flash error
            error_log("Error uploading image" . var_export($image->getError(), true));
            $e = $image->getError();
            die(json_encode(['error' => $e]));
            //flash("Error uploading image", "danger");
        }
    } else {
        error_log("Error uploading image" . var_export($image->getError(), true));
        $e = $image->getError();
        flash("$e", "danger");
        die(json_encode(['error' => $e]));
    }
}

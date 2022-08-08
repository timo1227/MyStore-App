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
error_log("Uploading file " . var_export($_FILES, true));
if ($action == 'upload') {
    // Check if image was uploaded 
    if ($_FILES['image']['name'] == "") {
        error_log("no image");
        //GET OLD IMAGE PATH FROM DB
        $id = $_REQUEST['id'];
        $db = getDB();
        $stmt = $db->prepare("SELECT image FROM RM_Items WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $oldImage = $result['image'];
        // Set Image Path to Post Image Path
        error_log("Setting Old Image Path Since None provided" . $oldImage);
        $_POST['image'] = $oldImage;
        $TABLE_NAME = "RM_Items";
        if (update_data($TABLE_NAME, $_POST["id"], $_POST)) {
            flash("Updated item", "success");
        }
        die();
    }
    //Create Bulletproof object
    $image = new Bulletproof\Image($_FILES);
    //upload image
    if ($image['image']) {
        //if image uploaded successfully
        $upload = $image->upload();
        if ($upload) {
            $newPath = $image->getPath();
            $response['code'] = "200";
            if ($_FILES['image']['error'] != 4) {
                //set which bucket to work in
                $bucketName = "myshop_bucket";
                // get local file for upload testing
                $sourceFile = __DIR__ . '/' . $newPath;
                $fileContent = fopen($sourceFile, 'r');
                error_log("File content: " . var_export($fileContent, true));
                // NOTE: if 'folder' or 'tree' is not exist then it will be automatically created !
                $cloudPath = 'uploads/' . $_POST['name'] . '.png';
                $type = $_FILES['image']['type'];
                error_log("Type: " . var_export($type, true));
                $isSucceed = uploadFile($bucketName, $fileContent, $cloudPath, $type);

                if ($isSucceed == true) {
                    $response['msg'] = 'SUCCESS: to upload ' . $cloudPath . PHP_EOL;
                    flash("Uploaded image", "success");
                    // TEST: get object detail (filesize, contentType, updated [date], etc.)
                    $response['data'] = getFileInfo($bucketName, $cloudPath);
                    $_POST['image'] = 'https://storage.googleapis.com/myshop_bucket/uploads/' . $_POST['name'] . '.png';
                    // set_metadata($bucketName, $response['data']['name'], $type);
                    error_log("File info: " . var_export($response['data'], true));
                } else {
                    $response['code'] = "201";
                    $response['msg'] = 'FAILED: to upload ' . $cloudPath . PHP_EOL;
                    flash("Error uploading image", "danger");
                }
            }
            // header("Content-Type:application/json");
            echo json_encode($response);
            //Delete the temp file created by Bulletproof
            unlink($newPath);
            //Update product
            $TABLE_NAME = "RM_Items";
            if (update_data($TABLE_NAME, $_POST["id"], $_POST)) {
                flash("Updated item", "success");
            }
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

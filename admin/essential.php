<?php
// this data is for froentnd purpose
define('SITE_URL','http://localhost:8080/hotelmanagement/
');
define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
define('USERS_IMG_PATH',SITE_URL.'images/users/');
define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');

// this data is used for backend upload process
define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/hotelmanagement/images/');
define('ABOUT_FOLDER', 'about/');
define('USERS_FOLDER', 'users/');
define('ROOMS_FOLDER','rooms/');



function adminLogin(){
    session_start();                                                                
    if(!(isset($_SESSION['adminlogin']) && $_SESSION['adminlogin']==true)){
        header("location: index.php"); 
    }
}

function redirect($url){
    echo"
   <script>
   window.location.href='$url';
   </script>";
}

function alert($type, $msg) {
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger"; // Corrected spelling

    return "<div class='alert $bs_class alert-dismissible fade show position-absolute top-0 end-0 m-3' role='alert'>
                $msg
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
}

function uploadimage($image, $folder) { 
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];       

       
    

    // ✅ Check if the file is empty
    if (empty($image['name'])) {
        return 'upload_failed';
    }

    $img_mime = $image['type'];

    // ✅ Validate file type
    if (!in_array($img_mime, $valid_mime)) {
        return 'invalid_image';
    }

    // ✅ Validate file size (limit: 2MB)
    if (($image['size'] / (1024 * 1024)) > 2) {
        return 'invalid_size';
    }

    // ✅ Generate a random filename
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);                             
    $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";                        
    $upload_dir = UPLOAD_IMAGE_PATH . $folder;                                           

    // ✅ Ensure the upload directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);                          
    }

    $img_path = $upload_dir . '/' . $rname;

    // ✅ Move the uploaded file
    if (move_uploaded_file($image['tmp_name'], $img_path)) {
        return $rname;
    } else {
        return 'upload_failed';
    }
}

function dl_image($image, $folder){
    if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
       return true;
    }
    else{
        return false;
    }
}

function uploaduserimage($image){
    if (empty($image['name'])) {
        return 'upload_failed - empty name';
    }

    if (!in_array($image['type'], ['image/jpeg', 'image/png', 'image/webp'])) {
        return 'invalid_image - ' . $image['type'];
    }

    if ($image['error'] !== 0) {
        return 'upload_failed - error code: ' . $image['error'];
    }

    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);                             
    $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";                        
    $upload_dir = UPLOAD_IMAGE_PATH . USERS_FOLDER;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);                          
    }

    $img_path = $upload_dir . '/' . $rname;

    if (move_uploaded_file($image['tmp_name'], $img_path)) {
        return $rname;
    } else {
        return 'upload_failed - move failed';
    }
}



?>

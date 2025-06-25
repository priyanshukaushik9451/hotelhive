
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('../admin/db_confg.php');
require('../admin/essential.php');
adminLogin();

if(isset($_POST['get_genral'])) {
    $q = "SELECT * FROM `settings` WHERE `sr_no.`=?";
    $values = [1];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    echo json_encode($data);        
}

if(isset($_POST['upd_genral'])) {
    $frm_data = filteration($_POST);
    $q = "UPDATE `settings` SET `site_title`=?, `site_about`=? WHERE `sr_no.`=1";
    $values= [$frm_data['site_title'], $frm_data['site_about']]; 

    $res = update($q, $values, 'ss');
    echo $res;
}

if (isset($_POST['upd_shutdown'])) {
    $frm_data = filteration($_POST);  
    $q = "UPDATE `settings` SET `shutdown`=? WHERE `sr_no.`=1";  // Wrapped in backticks
    $values = [$frm_data['upd_shutdown']];  // Use the received value directly
    $res = update($q, $values, 'i');
    echo $res;
}

if(isset($_POST['get_contacts'])) {
    $q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $values = [1];
    $res = select($q, $values, "i");

    if (!$res) {
        die("Query Failed: " . mysqli_error($success));
    }

    $data = mysqli_fetch_assoc($res);
    echo json_encode($data);
}

if (isset($_POST['upd_contact_modal'])) {
    $site_address = $_POST['site_address'] ?? '';
    $site_map = $_POST['site_map'] ?? '';
    $site_phn = $_POST['site_phn'] ?? '';
    $site_email = $_POST['site_email'] ?? '';
    $site_facebook = $_POST['site_facebook'] ?? '';
    $site_instagram = $_POST['site_instagram'] ?? '';
    $site_twitter = $_POST['site_twitter'] ?? '';
    $site_iframe = $_POST['site_iframe'] ?? '';

    // SQL query
    $q = "UPDATE contact_details SET 
           `address`=?,
            `gmap`=? ,
            `phn1`=?, 
            `email`=?, 
            `fb`=?, 
            `insta`=?, 
            `twitter`=?, 
           `iframe`=?
          WHERE sr_no = 1"; 

    $values = [$site_address, $site_map, $site_phn, $site_email, $site_facebook, $site_instagram, $site_twitter, $site_iframe];
    


    $res = update($q, $values, 'ssssssss'); 

    echo $res ? "1" : "Error updating contact details.";
}

if (isset($_POST['add_member'])) {
    $frm_data = filteration($_POST);          
    // var_dump($_FILES);
    // ✅ Check if file exists in $_FILES before calling uploadimage()
    if (!isset($_FILES['team_image']) || $_FILES['team_image']['error'] !== UPLOAD_ERR_OK) {
        die("upload_failed"); // Stop execution if no file uploaded
    }

    $img_r = uploadimage($_FILES['team_image'], ABOUT_FOLDER);

    // ✅ Handle upload result                                                                              
    if ($img_r == 'invalid_image' || $img_r == 'invalid_size' || $img_r == 'upload_failed') {
        echo $img_r; // Display specific error
    } else {
        $q = "INSERT INTO `team_details`(`name`, `position`, `picture`) VALUES (?,?,?)";
        $values = [$frm_data['name'], $frm_data['position'], $img_r];
        $res = insert($q, $values, 'sss');
        echo $res;
    }
}

if (isset($_POST['get_member'])) {

    $res = selectall('team_details');
    
    while ($row = mysqli_fetch_assoc($res)) {
        $path=ABOUT_IMG_PATH;
        echo <<<data
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
            <button type="button" onclick="delete_image($row[sr_no])" class="btn btn-danger btn-sm">Delete
            </button>
                <img src="$path$row[picture]" class="card-img-top" alt="Team Member Photo">
               
                <div class="card-body text-center">
                    <h6 class="card-title mb-1">$row[name]</h6>
                    <p class="text-muted mb-0">$row[position]</p>
                </div>
            </div>
        </div>
data;
    }
}
if(isset($_POST['delete_image'])){
    $frm_data= filteration($_POST);
    $pre_q= "SELECT * FROM `team_details` WHERE `sr_no`=?";  
    $values=[$frm_data['delete_image']];
    $res= select($pre_q, $values, 'i');
    $img= mysqli_fetch_assoc($res);       
    
    if (dl_image($img['picture'], ABOUT_FOLDER)){
    $q= "DELETE FROM `team_details` WHERE `sr_no`=?";
    $res= delete($q, $values, 'i');
    

    

    echo $res;
    }
    else{
        echo 0;
    }
}

        







?>

<?php
require('../admin/db_confg.php');
require('../admin/essential.php');
require('../admin/PHPMailer/src/PHPMailer.php');
require('../admin/PHPMailer/src/SMTP.php');
require('../admin/PHPMailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['register'])) {
    $data = filteration($_POST);

    if ($data['pass'] != $data['cpass']) {
        echo 'pass_mismatch';
        exit;
    }

    $u_exist = select("SELECT * FROM `user_crud` WHERE `email`=? OR `phone`=? LIMIT 1", 
                      [$data['email'], $data['phonenum']], "ss");

    if (mysqli_num_rows($u_exist) != 0) {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    $img = uploaduserimage($_FILES['profile']);
    if ($img == 'invalid_image') { echo 'inv_image'; exit; }
    else if ($img == 'upload_failed') { echo 'upd_failed'; exit; }

    $token = bin2hex(random_bytes(16));
    $enc_pass = password_hash($data['pass'], PASSWORD_DEFAULT);
    $t_expire = date("Y-m-d", strtotime("+1 day"));

    // Send verification email
    $verify_link = trim(SITE_URL) . "/ajax/verify.php?token=$token";

    $mail = new PHPMailer(true);
    try {
//         $mail->SMTPDebug = 2;  // Shows detailed debug info (remove later)
// $mail->Debugoutput = 'html';  // Optional, makes debug output readable

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Your SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'priyanshukaushik113@gmail.com';  // your email
        $mail->Password = 'nawcinygqjjxzwhr';     // your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;     

        $mail->setFrom('priyanshukaushik113@gmail.com', 'Hotel Management');    
        $mail->addAddress($data['email']);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification - Hotel Management';
        $mail->Body = "Click the following link to verify your email: <br><br>
                       <a href='$verify_link'>$verify_link</a>";

        $mail->send();

        $query = "INSERT INTO `user_crud`(`name`, `email`, `phone`, `address`, `profile`, `password`, `token`, `is_verified`, `t_expire`, `status`) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?, 1)";
        $values = [
            $data['name'],
            $data['email'],
            $data['phonenum'],
            $data['address'],
            $img,
            $enc_pass,
            $token,
            $t_expire
        ];

        $res = insert($query, $values, "ssssssss");    
        echo $res;

    } catch (Exception $e) {
        echo 'mail_failed '.$e->getMessage();
    }
}

if (isset($_POST['login'])) {

    $data = filteration($_POST);

    // Step 1: Query only by email
    $q = "SELECT * FROM `user_crud` WHERE `email` = ?";
    $val = [$data['email']];
    $res = select($q, $val, "s");  // returns mysqli_result object


    // Step 2: Check if user exists and fetch the row
      if ($res && $res->num_rows > 0) {
        $user = $res->fetch_assoc();   // ✅ now it's an associative array

        if($user['is_verified']==0){
            echo 'not_verified';
        }
        if($user['status']==0){
            echo 'inactive';
        }



        // Step 3: Verify hashed password
        if (password_verify($data['pass'], $user['password'])) {
            session_start();
            $_SESSION['login']=true;
            $_SESSION['uid']=$user['id'];
            $_SESSION['uname']=$user['name'];
            $_SESSION['upic']=$user['profile'];
            $_SESSION['uphone']=$user['phone'];    
            
            
            echo 1; // Success
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
}
if (isset($_POST['forgot'])) {
    $data = filteration($_POST);

    $q = "SELECT * FROM `user_crud` WHERE `email` = ?";
    $val = [$data['email']];
    $res = select($q, $val, "s");  // returns mysqli_result object

    if (mysqli_num_rows($res) == 0) {
        echo 'inv_mail';
        exit;
    }

    $u_fetch = mysqli_fetch_assoc($res);

    if ($u_fetch['is_verified'] == 0) {
        echo 'not_verified';
        exit;
    }

    if ($u_fetch['status'] == 0) {
        echo 'inactive';
        exit;
    }

    // Passed all checks — send reset link
    $token = bin2hex(random_bytes(16));
    $t_expire = date("Y-m-d", strtotime("+1 day"));
    $verify_link = trim(SITE_URL) . "/ajax/reset_pass.php?token=$token";

    // Save token & expiry in database
    update(
        "UPDATE `user_crud` SET `token`=?, `t_expire`=? WHERE `id`=?",
        [$token, $t_expire, $u_fetch['id']],
        "ssi"
    );

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'priyanshukaushik113@gmail.com';
        $mail->Password = 'wcstgsdcodroslys';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('priyanshukaushik113@gmail.com', 'Hotel Management');
        $mail->addAddress($data['email']);

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password - Hotel Management';
        $mail->Body = "Click the following link to reset your password: <br><br>
                       <a href='$verify_link'>$verify_link</a>";

        $mail->send();
        echo 'mail_sent';
    } catch (Exception $e) {
        echo 'mail_failed ' . $e->getMessage();
    }
}




?>

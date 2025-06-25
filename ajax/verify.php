<?php
require('../admin/db_confg.php');
require('../admin/essential.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $res = select("SELECT * FROM `user_crud` WHERE `token`=? AND `is_verified`=0", [$token], "s");

    if (mysqli_num_rows($res) == 1) {
        update("UPDATE `user_crud` SET `is_verified`=1 WHERE `token`=?", [$token], "s");
        echo "✅ Email verified successfully. You can now login.";
    } else {
        echo "❌ Invalid or already verified mail.";
    }
}
?>

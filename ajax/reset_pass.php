<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../admin/db_confg.php'); // Adjust path if needed
require('../admin/essential.php'); // For filteration()

if (isset($_GET['token'])) {
    $token = filteration($_GET)['token'];

    $q = "SELECT * FROM `user_crud` WHERE `token`=? AND `t_expire` >= ?";
    $res = select($q, [$token, date("Y-m-d")], "ss");

    if (mysqli_num_rows($res) == 1) {
        $user = mysqli_fetch_assoc($res);
        echo "you can change your password: " . $user['name'];  // TEMP message
        // Now close PHP so you can write HTML below
        ?>

        <!-- Show Reset Form -->
        <form method="POST">
            <h2>Reset Password</h2>
            <input type="password" name="password" required placeholder="Enter new password">
            <button type="submit" name="reset_pass">Change Password</button>
        </form>

        <?php
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}

if (isset($_POST['reset_pass'])) {
    $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $update = update("UPDATE `user_crud` SET `password`=?, `token`=NULL, `t_expire`=NULL WHERE `token`=?", [$new_pass, $token], "ss");

    if ($update) {
        echo " Password updated successfully. <a href='../index.php'>Login</a>";
        exit;
    } else {
        echo " Failed to update password. Try again.";
    }
}



?>

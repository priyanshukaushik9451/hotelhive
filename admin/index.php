<?php
require 'db_confg.php';
require 'essential.php';

    session_start();
    if(isset($_SESSION['adminlogin']) && $_SESSION['adminlogin']==true){
        header("location: dashboard.php");
    }


$message = ""; // Variable to store the message

if (isset($_POST['submit'])) {
    $frm_data = filteration($_POST); 

    $query = "SELECT * FROM `admin_cred` WHERE `name` = ? AND `pass` = ?";
    $values = [$frm_data['username'], $frm_data['password']];  

    $datatypes = "ss";  
    $res = select($query, $values, $datatypes);  

    if ($res->num_rows == 1) {
        $message = alert('success', "✅ Login successful!");
        $row= mysqli_fetch_assoc($res);
        
        $_SESSION['adminlogin']=true;
        $_SESSION['adminID']=$row['sr_no'];
        redirect('dashboard.php');                    

    } else {
        $message = alert('danger', "❌ Login failed - Invalid credentials!");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Grand Haven</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .admin-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Fixed width */
        }
        /* Message Box Styling */
        .message-box {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            background: #ffeb3b;
            color: #333;
            font-weight: bold;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<!-- Message Box (Alert) -->
<?php if ($message): ?>
    <?php echo $message; ?>
<?php endif; ?>

<div class="admin-form">
    <h3 class="text-center mb-4">Admin Login</h3>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100" name="submit">Login</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

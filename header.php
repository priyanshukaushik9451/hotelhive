<?php

session_start();

require('admin/db_confg.php');
require('admin/essential.php');


        $contact_q= "SELECT *FROM `contact_details` WHERE `sr_no`=?";
        $values= [1];
        $contact_r=  mysqli_fetch_assoc(select($contact_q,$values ,'i'));

        $contact_query= "SELECT *FROM `settings` WHERE `sr_no.`=?";
        $valuess= [1];   
        $contact_res=  mysqli_fetch_assoc(select($contact_query,$valuess ,'i'));   


  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $contact_res['site_title']?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<style>
  .reach-us {
    background-color: #f8f9fa;
    padding: 50px 0;
    border-radius: 10px;
  }
  .reach-us h4 {
    font-weight: bold;
  }
  .reach-us p {
    font-size: 18px;
    color: #333;
  }
  .social-links a {
    font-size: 24px;
    color: #007bff;
    transition: color 0.3s ease-in-out;
  }
  .social-links a:hover {
    color: #0056b3;
  }
</style>
</head>
<body>
<nav  id= "nav_bar" class="navbar navbar-expand-lg bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand me-5 fw-bold fs-3" href="#"><?php echo $contact_res['site_title']?></a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active me-2" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="rooms.php">Room</a>
        </li>
        <li class="nav-item">
            <a class="nav-link me-2" href="facilites.php">Facilites</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="contact.php">Contact US</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="aboutus.php">About</a>
          </li>
       
      </ul>
      <form class="d-flex" role="search">
      <?php


if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
   $path= USERS_IMG_PATH;
  $uname = $_SESSION['uname'];
    $uprofile = $_SESSION['upic'];
    echo <<<data
    <div class="dropdown">
        <button class="btn btn-outline-dark shadow dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="$path$uprofile" alt="Profile" width="30" height="30" class="rounded-circle me-2">
            $uname
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </div>
data;
}
?>

<?php
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  echo <<<data
  <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginmodal">
    Login
  </button>
  <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#registermodal">
    Register
  </button>
  data;
}
?>

      </form>
    </div>
  </div>
</nav>
<!-- modal login -->

<div class="modal fade" id="loginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <form action="" method= "POST" id="log_in" entype="multipart/form-data"> <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center" >
                <i class="bi bi-person-circle fs-3 me-2"></i>
                User Login</h5>
            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="mail" aria-describedby="emailHelp">
                
              </div>
              <div class="mb-4">
                <label for="exampleInputEmail1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputEmail" name="password" aria-describedby="emailHelp">
                
              </div>
              <div class="d-flex align-items-center justify-content-between mb-2"><button type=" submit"class="btn btn-dark shadow-none">Login</button>
              <button type="button" class="btn  text-secondary text-decoration-none shadow-none me-lg-2 me-3 p-0" data-bs-toggle="modal" data-bs-target="#forgotmodal" data-bs-dismiss="modal">
   Forget Passsword?
  </button>
            </div>
          </div>                                                               
         </form>
      </div>
    </div>
  </div>

  <!-- modal register -->

<!-- Registration Modal -->
<div class="modal fade" id="registermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Large modal -->
        <div class="modal-content">
            <form action="" method="POST" id="reg_form" enctype="multipart/form-data"> 
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-plus fs-3 me-2"></i>
                        User Registration
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                        Note: Your details must match with your ID (Aadhaar Card, PAN Card) that will be required during check-in.
                    </span>

                    <div class="row">
                        <!-- Left Column -->                  
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter your name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input  name="email" type="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input name="number" type="tel" class="form-control" placeholder="Enter your phone number" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input name="pass" type="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Profile Picture</label>
                                <input name="profile" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Enter your address" required></textarea>
                            </div>
                           
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input name="cpass" type="password" class="form-control" placeholder="Enter your confirm password" required>
                            </div>
                            
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark shadow-none">Register</button>
                    <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- forget -->
<div class="modal fade" id="forgotmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <form action="" method= "POST" id="forgot" entype="multipart/form-data"> <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center" >
                <i class="bi bi-person-circle fs-3 me-2"></i>
               Forgot Password</h5>
           
          </div>
          <div class="modal-body">
          <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                        Note:A link will be sent to your mail to reset your password!
                    </span>
            <div class="mb-4">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name= "mail" class="form-control" id="exampleInputEmail1" name="mail" aria-describedby="emailHelp">
                
              </div>
             
              <div class="d-flex align-items-center justify-content-between mb-2 tet-end"><button type=" submit"class="btn btn-dark shadow-none">Send Link</button>
              <button type="button" class="btn  text-secondary text-decoration-none shadow-none me-lg-2 me-3 p-0" data-bs-toggle="modal" data-bs-target="#loginmodal" data-bs-dismiss="modal">
   Cancel
  </button>
            </div>
          </div>                                                               
         </form>
      </div>
    </div>
  </div>


  <?php
  $setting_q= "SELECT * FROM `settings` WHERE `sr_no.`=?";
  $values= [1];
  $setting_r= mysqli_fetch_assoc(select($setting_q,$values, 'i'));

  if($setting_r['shutdown']){
    echo<<<alert
    <div class= 'bg-danger text-center p-2 fw-bold' style='position: sticky; top: 0; z-index: 1030;'>
    Bookings are temporarily closed!!
    </div>

alert;    
  }
  ?>

  <script>
    function chk_is_login($login,room_id){
      if($login){
        window.location.href= 'confirm_booking.php?id='+room_id;
      }
      else{
        alert('Please login with your credentials')
      }
    }
  </script>
 
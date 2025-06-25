<?php include 'header.php'; ?>

<?php
if (!isset($_GET['id'])) {
    redirect('rooms.php');
}
$data = filteration($_GET);
$room_res = select("SELECT * FROM rooms WHERE id=? AND status=? AND removed=?", [$data['id'], 1, 0], 'iii');

if (mysqli_num_rows($room_res) == 0) {
    redirect('rooms.php');
}
$room_data = mysqli_fetch_assoc($room_res);
?>

<!-- Rooms Section -->
<div class="container">
    <div class="row">

        <!-- Rooms Cards -->
        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold"><?php echo $room_data['name'] ?></h2>
            <div style="font-size:14px;">
                <a href="index.php">HOME</a>
                <span> > </span>
                <a href="rooms.php">ROOMS</a>
            </div>
        </div>

       
        <div class="col-lg-7 col-md-12 px-4">
            <div id="room_carousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#room_carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#room_carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#room_carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner">
                    <?php
                    $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                    $thumb_q = mysqli_query($success, "SELECT * FROM rooms_images WHERE room_id='$room_data[id]'");
                    echo mysqli_num_rows($thumb_q) . " images found.";

                    if (mysqli_num_rows($thumb_q) > 0) {
                        $active_class = 'active';
                        while ($thumb_res = mysqli_fetch_assoc($thumb_q)) {
                            echo "
                            <div class='carousel-item $active_class'>
                                <img src='" . ROOMS_IMG_PATH . $thumb_res['image'] . "' class='d-block w-100' alt='...'>
                            </div>";
                            $active_class = '';
                        }
                    } else {
                        echo "
                        <div class='carousel-item active'>
                            <img src='$room_thumb' class='d-block w-100' alt='...'>
                        </div>";
                    }
                    ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#room_carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#room_carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <?php
                    echo<<<price
                      <h4>₹$room_data[price]per night </h4>
                    price;

                     echo<<<price
                      <div class="rating">
                       <span class="badge rounded-pill bg-light">
                       <i class="bi bi-star-fill text-warning"></i>
                       <i class="bi bi-star-fill text-warning"></i>
                       <i class="bi bi-star-fill text-warning "></i>
                       <i class="bi bi-star-fill text-warning"></i></span>
                       </div>
                      price;

                      $room_id= $room_data['id'];
                        $room_dis= $room_data['description'];

                 $feature= mysqli_query($success,"SELECT f.name FROM `features` f INNER JOIN `room_features` rf ON f.id=rf.features_id WHERE rf.room_id='$room_id'");
                 $facility= mysqli_query($success,"SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rf ON f.sr_no=rf.facilities_id WHERE rf.room_id='$room_id'");
               
                $feature_data= "";
            while($feature_row= mysqli_fetch_assoc($feature)){
               $feature_data .= $feature_row['name']." " . "&nbsp";         
                  
            }
              $facility_data= "";
            while($facility_row= mysqli_fetch_assoc($facility)){
               $facility_data .=  $facility_row['name'] . " " . "&nbsp";

              
                 

            }  

             echo<<<features
                 <p class="mb-1"><strong>Features:</strong> $feature_data</p>
                <p class="mb-1"><strong>Facilities:</strong> $facility_data</p>
                </br>
               features;
               
               

            echo <<<guest
    <h4>Guests:</h4>
    <p class="mb-1">{$room_data['adult']} adults &nbsp {$room_data['children']} child </p>
    </br>
guest;

        echo<<<discription
         <h4>Description:</h4>
               <p class="card-text">$room_dis</p>
               </br>
        discription;

         $book_btn= "";
            if(!$setting_r['shutdown']){
                 $login= 0;
      if(isset($_SESSION['login']) && $_SESSION['login']==true){
        $login= 1;}
                $book_btn= "<button onclick='chk_is_login($login,$room_id)' class='btn btn-success me-2 w-100'>Book Now</button>";
            }
        echo<<<book
         $book_btn

        book;

               
                    ?>
                </div>
            </div>
        </div>
               

                      <div class="profile d-flex align-items-center p-4">
                  <img src="images/mypic.jpg" style="height: 100px; width: 100px; border-radius: 50px;" />
                  <h6 class="m-0 ms-2">Random User 1</h6>
              </div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo animi eveniet quasi labore magnam expedita quam optio, placeat voluptatem ratione!</p>
              <div class="rating">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
              </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>

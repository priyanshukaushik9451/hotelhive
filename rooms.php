<?php include 'header.php';?>

<!-- Rooms Section -->
<div class="container-fluid mt-5">
    <div class="row">
        <!-- Sidebar -->
       <aside class="col-md-3" style="position: sticky; top: 80px; z-index: 100; height: fit-content;">

            <div class="p-3 bg-light rounded shadow-sm ">
                <h5 class="mb-3">Filter Rooms</h5>
                <form>
                    <label class="form-label">Check In</label>
                    <input type="date" class="form-control mb-2">

                    <label class="form-label">Check Out</label>
                    <input type="date" class="form-control mb-2">

                    <label class="form-label">Facilities</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"> WiFi
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"> Air Conditioning
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"> TV
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"> Room Service
                    </div>

                    <label class="form-label mt-3">Guests</label>
                    <select class="form-select mb-2">
                        <option>1 Adult</option>
                        <option>2 Adults</option>
                        <option>3 Adults</option>
                    </select>
                    <select class="form-select mb-3">
                        <option>0 Children</option>
                        <option>1 Child</option>
                        <option>2 Children</option>
                    </select>

                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                </form>
            </div>
        </aside>

        <!-- Rooms Cards -->
        <div class="col-md-9">
            <h2 class="text-center mb-4">Our Rooms</h2>


        <?php
            $room_res= select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=?",[1,0],"ii");

            while($room_data= mysqli_fetch_assoc($room_res)){

                 $room_id = $room_data['id'];
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
            // for thumbnail 

            $room_thumb= ROOMS_IMG_PATH."thumbnail.jpg";
            $thumb_q =  mysqli_query($success, "SELECT * FROM `rooms_images` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");  

            if(mysqli_num_rows($thumb_q)>0){
                $thumb_res= mysqli_fetch_assoc($thumb_q);
                $room_thumb= ROOMS_IMG_PATH.$thumb_res['image'];
            }
            // print room card;
            $room_name= $room_data['name'];
            $room_dis= $room_data['description'];
            $room_adult= $room_data['adult']." ";
             $room_child= $room_data['children']." ";
             $room_price= $room_data['price'];

             $book_btn= "";
            if(!$setting_r['shutdown']){
                 
                 $login= 0;
      if(isset($_SESSION['login']) && $_SESSION['login']==true){
        $login= 1;}
        $book_btn= " <button onclick='chk_is_login($login,$room_id)' class='btn btn-success me-2'>Book Now</button>";

               
            }


echo <<<data
<!-- Room Card (repeat this as many times as needed) -->
<div class="card mb-4 shadow-sm">
    <div class="row g-0 align-items-center">
        <div class="col-md-5">
            <img src="$room_thumb" class="img-fluid rounded-start w-100" style="height: 250px; object-fit: cover;" alt="Room">
        </div>
        <div class="col-md-7">
            <div class="card-body">
                <h5 class="card-title">$room_name</h5>
                <p class="card-text">$room_dis</p>
                <p class="mb-1"><strong>Features:</strong>$feature_data</p>
                <p class="mb-1"><strong>Facilities:</strong> $facility_data</p>
                <p class="mb-2"><strong>Guests:</strong> $room_adult adult &nbsp $room_child children</p>
                <div class="d-flex justify-content-between align-items-center">
                    <strong class="text-success">₹$room_price per night</strong>
                    <div>
                        $book_btn
                        <a href="room_details.php?id=$room_data[id]" class="btn btn-outline-secondary">More Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
data;

            
            


            
        }
             ?> 

           

           

          

            <!-- Add more room cards if needed, just copy the structure above -->
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<?php include 'footer.php';?>

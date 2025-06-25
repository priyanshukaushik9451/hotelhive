<?php include 'header.php';?>
             
<div class="container-fluid">

    <!-- Swiper -->
  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <img src="images/IMG_62045.png" class="w-100 d-block"  />
      </div>
      <div class="swiper-slide">
        <img src="images/IMG_55677.png" class="w-100 d-block"  />
      </div>
      <div class="swiper-slide">
        <img src="images/IMG_40905.png" class="w-100 d-block"  />
      </div>
      <div class="swiper-slide">
        <img src="images/IMG_15372.png" class="w-100 d-block" />
      </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>
</div>

<!-- check availablility form -->

<div class="container availablility-form">
  <div class="row">
    <div class="col-lg-12 bg-white shadow p-4 rounded ">
      <h5 class="mb-4">Check Booking Availablility</h5>
      <form action="">
        <div class="row align-items-end">
          <div class="col-lg-3 mb-3">
            <label class="form-label" style="font-weight: 500;">Check In</label>
            <input type="date" class="form-control shadow-none">
          </div>
          <div class="col-lg-3 mb-3">
            <label class="form-label" style="font-weight: 500;">Check Out</label>
            <input type="date" class="form-control shadow-none">
          </div>
          <div class="col-lg-3 mb-3">
            <label class="form-label" style="font-weight: 500;">Adult</label>
            <select class="form-select shadow-none">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
          <div class="col-lg-2 mb-3 ">
            <label class="form-label" style="font-weight: 500;">Children</label>
            <select class="form-select shadow-none">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
          <div class="col-lg-1 mb-lg-3">
            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>


<!-- our rooms -->

<h2 class="mt-5 pt-4 mb-4 text-center">Our Rooms</h2>

<div class="container">
  <div class="row">
     <?php

     $room_q=  mysqli_query( $success, "SELECT * FROM `rooms` WHERE `status`=1 AND `removed`=0 ORDER BY `id` LIMIT 3");


    $book_btn= "";

  

     

while($room_res = mysqli_fetch_assoc($room_q)){
   $room_name= $room_res['name'];
   $room_id= $room_res['id'];
  if(!$setting_r['shutdown']){
     $login= 0;
     $book_btn=   "<button onclick= 'chk_is_login($login,$room_id)'  class='btn btn-success btn-primary shadow-none'>Book Now</button>";
     
      if(isset($_SESSION['login']) && $_SESSION['login']==true){
        $login= 1;
      }
     
      
    }
   
        $room_image_q= mysqli_query($success, "SELECT* FROM `rooms_images` WHERE room_id=$room_id AND `thumb`=1");
        $room_image_res= mysqli_fetch_assoc($room_image_q);
        $room_img_path = ROOMS_IMG_PATH . $room_image_res['image'];


        


  echo<<<room

    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
        <img src="$room_img_path" class="card-img-top" alt="...">
        <div class="card-body">
          <h5>$room_name</h5>
          <h6 class="mb-4">$250 per night</h6>

          <div class="features">
            <h6 class="mb-1">Features</h6>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">1 Room</span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">1 Bathroom</span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">1 Balcony</span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">1 Sofa</span>
          </div>

          <div class="facilities">
            <h6 class="mb-1">Facilities</h6>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">WiFi</span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">AC</span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">T.V</span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">Food delivery</span>
          </div>

          <div class="rating">
            <h6 class="mb-1">Rating</h6>
            <span class="badge rounded-pill bg-light">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
            </span>
          </div>

          <div class="d-flex justify-content-evenly mb-2 mt-2">
          $book_btn
            <a href="room_details.php?id=$room_res[id]" class="btn btn-sm btn-secondary shadow-none">More details</a>
          </div>
        </div>
      </div>
    </div>
room;
}
?>

    

    <div class="col-lg-12 text-center mt-5">
      <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More rooms</a>
    </div>
 
  </div>
</div>




<h2 class="mt-5 pt-4 mb-4 text-center">Our Facilites</h2>

<div class="container">
  <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
    <div class="col-lg-2 md-2  text-center bg-white rounded shadow py-4 my-3">
      <img src="images/IMG_43553.svg" width="80px" alt="">
      <h5 class="mt-3">WiFi</h5>
    </div>
    <div class="col-lg-2 md-2  text-center bg-white rounded shadow py-4 my-3">
      <img src="images/IMG_43553.svg" width="80px" alt="">
      <h5 class="mt-3">WiFi</h5>
    </div>
    <div class="col-lg-2 md-2  text-center bg-white rounded shadow py-4 my-3">
      <img src="images/IMG_43553.svg" width="80px" alt="">
      <h5 class="mt-3">WiFi</h5>
    </div>
    <div class="col-lg-2 md-2  text-center bg-white rounded shadow py-4 my-3">
      <img src="images/IMG_43553.svg" width="80px" alt="">
      <h5 class="mt-3">WiFi</h5>
    </div>
    <div class="col-lg-2 md-2  text-center bg-white rounded shadow py-4 my-3">
      <img src="images/IMG_43553.svg" width="80px" alt="">
      <h5 class="mt-3">WiFi</h5>
    </div>
  </div>
</div>


<h2 class="mt-5 pt-4 mb-4 text-center">Testimonials</h2>
<div class="container-fluid">  <!-- Use container-fluid for full width -->
  <div class="swiper mySwiper2">
      <div class="swiper-wrapper">
          <div class="swiper-slide bg-white p-4">
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
          <div class="swiper-slide bg-white p-4">
              <div class="profile d-flex align-items-center p-4">
                  <img src="images/mypic.jpg" style="height: 100px; width: 100px; border-radius: 50px;" />
                  <h6 class="m-0 ms-2">Random User 2</h6>
              </div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo animi eveniet quasi labore magnam expedita quam optio, placeat voluptatem ratione!</p>
              <div class="rating">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
              </div>
          </div>
          <div class="swiper-slide bg-white p-4">
              <div class="profile d-flex align-items-center p-4">
                  <img src="images/mypic.jpg" style="height: 100px; width: 100px; border-radius: 50px;" />
                  <h6 class="m-0 ms-2">Random User 3</h6>
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
      <div class="swiper-pagination"></div>
  </div>
</div> 

<!-- Reach Us Section -->
<?php                                                                                                     
$contact_q= "SELECT *FROM `contact_details` WHERE `sr_no`=?";                                       
$values= [1];                                                                                       
$contact_r=  mysqli_fetch_assoc(select($contact_q,$values ,'i'));                 
?>                                                                                
<section class="reach-us my-5">                                                                                 
  <div class="container">
    <h2 class="text-center mb-4">Reach Us</h2>
    <div class="row align-items-center">                                                      
      <!-- Map Section (50%) -->
      <div class="col-md-6">                                                                       
        <iframe
          src="<?php echo $contact_r['iframe']?>"                                                                   
          width="10%" height="400" style="border:0; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);" allowfullscreen="" loading="lazy"></iframe>
      </div>
      <!-- Contact & Social Media Section (50%) -->
      <div class="col-md-6 d-flex flex-column justify-content-center text-center">
        <h4 class="mb-3">Call Us</h4>
        <p><i class="bi bi-telephone"></i> <?php echo $contact_r['phn1']?></p>                 
        <h4 class="mt-4 mb-3">Follow Us</h4>                                                   
                                                                                               
        <div class="social-links">                                                             
        <?php                                                                                  
        if (!empty($contact_r['fb'])) {
          echo <<<DATA
          <a href="{$contact_r['fb']}" class="me-3"><i class="bi bi-facebook"></i></a>
          DATA;
        }
        ?>
         <?php
        if (!empty($contact_r['fb'])) {
          echo <<<DATA
           <a href="{$contact_r['insta']}" class="me-3"><i class="bi bi-instagram"></i></a>
          DATA;
        }
        ?>
         <?php
        if (!empty($contact_r['fb'])) {
          echo <<<DATA
           <a href="{$contact_r['twitter']}" class="me-3"><i class="bi bi-twitter"></i></a>
          DATA;
        }
        ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'footer.php';?>








<br><br><br>








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 3000, // Slide changes every 3 seconds
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    
    var swiper = new Swiper(".mySwiper2", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    loop: true,
    slidesPerView: 3, // Ensures all three testimonials are visible on large screens
    spaceBetween: 20, // Adjust spacing between slides
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,  
    },
    breakpoints: {
      320: { slidesPerView: 1 },  // 1 testimonial on mobile
      768: { slidesPerView: 2 },  // 2 testimonials on tablets
      1024: { slidesPerView: 3 }  // 3 testimonials on large screens (full width)
    }
  });
</script>
</body>
</html>
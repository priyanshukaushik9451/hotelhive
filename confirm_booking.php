<?php include 'header.php'; ?>

<?php

if (!isset($_GET['id']) || $setting_r['shutdown']){
    redirect('rooms.php');
}
else if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('rooms.php');
}
$data = filteration($_GET);
$room_res = select("SELECT * FROM rooms WHERE id=? AND status=? AND removed=?", [$data['id'], 1, 0], 'iii');

if (mysqli_num_rows($room_res) == 0) {
    redirect('rooms.php');
}
$room_data = mysqli_fetch_assoc($room_res);

$_SESSION['room']= [
    "id"=> $room_data['id'],
    "name"=> $room_data['name'],
    "price"=> $room_data['price'],
    "payment"=> null,
    "available"=> false
];
                              
 $user_res= select("SELECT *FROM `user_crud` WHERE `id`=? LIMIT 1", [$_SESSION['uid']], "i");
 $user_data= mysqli_fetch_assoc($user_res);



?>

<!-- Rooms Section -->
<div class="container">
    <div class="row">

        <!-- Rooms Cards -->
        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold">Confirm Booking></h2>
            <div style="font-size:14px;">
                <a href="index.php">HOME</a>
                <span> > </span>
                <a href="rooms.php">ROOMS</a>
            </div>
        </div>

       
        <div class="col-lg-7 col-md-12 px-4">
            <?php
             $room_thumb= ROOMS_IMG_PATH."thumbnail.jpg";
            $thumb_q =  mysqli_query($success, "SELECT * FROM `rooms_images` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");  

            if(mysqli_num_rows($thumb_q)>0){
                $thumb_res= mysqli_fetch_assoc($thumb_q);
                $room_thumb= ROOMS_IMG_PATH.$thumb_res['image'];
            }

           $room_name = $room_data['name'];
$room_price = $room_data['price'];

echo <<<data
    <div class="card p-3 shadow-sm rounded"> 
        <img src="$room_thumb" class="img-fluid rounded" alt="Room">
        <h5>$room_name</h5>
        <h6>₹$room_price</h6>
    </div>
data;
            ?>
           
        </div>

        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                   <form action="#" id="booking_form">
                    <h4>Booking Details</h4>
                    <div class="row">
                     <div class="col-md-6 md-3">
                     <label class="form-label">Name</label>
                    <input name="name" type="text" value="<?php echo $user_data['name']?>" class="form-control" placeholder="Enter your name" required>
                     </div>
                      <div class="col-md-6 md-3">
                     <label class="form-label">Phone NO.</label>
                    <input name="number" type="number" value="<?php echo $user_data['phone']?>" class="form-control" placeholder="Enter your name" required>
                     </div>
                     <div class="col-md-12 md-3">
                     <label class="form-label">Address</label>
                    <textarea name="address" type="number"  class="form-control" placeholder="Enter your name" required> <?php echo $user_data['address']?> </textarea>
                     </div>

                     <div class="col-md-6 md-3">
                     <label class="form-label">Check IN</label>
                   <input name="checkin" onchange="chk_avalibility()" type="date"  class="form-control" required>

                     </div>
                     <div class="col-md-6 md-3">
                     <label class="form-label">Check Out</label>
                    <input name="checkout" onchange="chk_avalibility()" type="date"  class="form-control"  required>
                     </div>
                     <div class="col-md-12">
                        <div class="spinner-border text-info d-none mb-3" id="info_loader" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
                        <h6 class= "mb-3 text-danger mt-3" id="pay-info">Provide check-in and check-out date</h6>
                      <button class="btn btn-success w-100 mb-1 mt-3" id="pay_now_btn" name="pay_now" disabled >Pay Now</button>
                                               
                     </div>
                     
                    </div>
                   </form>
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


<script>
 
 let booking_form=  document.getElementById('booking_form');
 let info_loader = document.getElementById('info_loader');
 let pay_info= document.getElementById('pay-info');
 let  payment=0;

 

 function chk_avalibility(){
    let checkin_val= booking_form.elements['checkin'].value
    let checkout_val= booking_form.elements['checkout'].value
    

    booking_form.elements['pay_now'].setAttribute('disabled',true);

    if(checkin_val!='' &&  checkout_val!=''){
        pay_info.classList.add('d-none');
        info_loader.classList.remove('d-none');
        
        let data= new FormData();
        data.append('chk_avalibility', '');
        data.append('checkin', checkin_val);
         data.append('checkout', checkout_val);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/confirm_booking.php", true); 

        xhr.onload = function(){
            let data=JSON.parse(this.responseText);
            payment= data.payment

            if(data.status=='chkin and checkout is equal'){
                pay_info.innerText= "You cannot checkout at the same day!";
            }
            else if(data.status=='chkout is earlier'){
                pay_info.innerText= "Checkout date is earlier than Checkin date!";
            }
             else if(data.status=='chkin is earlier'){
                pay_info.innerText= "Checkout date is earlier than today's date!";
            }

            else if(data.status=='unavailable'){
                pay_info.innerText= "Room is not available for this date";
            }

            else{
                pay_info.innerHTML= "No.of days: "+ data.days+ "<br> Total amount to Pay: Rs."+ data.payment;
                pay_info.classList.replace('text-danger','text-dark');
                booking_form.elements['pay_now'].removeAttribute('disabled');
            }

            pay_info.classList.remove('d-none');
            info_loader.classList.add('d-none');

            

        }
        xhr.send(data);
    }
 }

</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
let pay_now_btn = document.getElementById('pay_now_btn');

pay_now_btn.addEventListener('click', function (e) {
    e.preventDefault();

    let form = document.getElementById('booking_form');
    let formData = new FormData(form);
    formData.append('room_id', <?php echo $room_data['id']; ?>);
    formData.append('price', payment );


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/create_order.php", true);

    xhr.onload = function () {
        let response = JSON.parse(this.responseText);
        if (response.status === 'success') {
            let options = {
                "key": response.key,
                "amount": response.amount,
                "currency": "INR",
                "name": "Hotel Hive",
                "description": "Room Booking Payment",
                "order_id": response.order_id,
                "handler": function (razorpayRes) {
                    // Prepare data for verify_payment.php
                    let verifyData = new FormData();
                    verifyData.append('razorpay_payment_id', razorpayRes.razorpay_payment_id);
                    verifyData.append('razorpay_order_id', razorpayRes.razorpay_order_id);
                    verifyData.append('razorpay_signature', razorpayRes.razorpay_signature);
                    
                    // Append form values again
                    for (let pair of formData.entries()) {
                        verifyData.append(pair[0], pair[1]);
                    }

                    let xhr2 = new XMLHttpRequest();
                    xhr2.open("POST", "ajax/verify_payment.php", true);
                    xhr2.onload = function () {
                        alert(this.responseText);  // Show success message
                        location.reload(); // Optionally redirect
                    };
                    xhr2.send(verifyData);
                },
                "prefill": {
                    "name": form.elements['name'].value,
                    "email": "<?php echo $user_data['email']; ?>"
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            let rzp = new Razorpay(options);
            rzp.open();
        } else {
            alert("❌ Order creation failed");
        }
    };

    xhr.send(formData);
});
</script>


<?php
require('header.php');
require('db_confg.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Rooms</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Your existing CSS styles here */
        /* ... (keep all your existing styles) ... */
    </style>
</head>
<body>

<!-- Header included from header.php -->

<div class="main-content" id="main-content">
<div class="section" style="margin-left: -160px;">
        <h2>Rooms Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_room_modal">Add Room</button>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Area</th>
                        <th>Guests</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Add Image</th>
                        <th>Delete Room</th>
                    </tr>
                </thead>
                <tbody id="room-data">
                    <!-- Room data will be loaded here -->
                </tbody>
            </table>
        </div>

        <!-- Add Room Modal -->
        <div class="modal fade" id="add_room_modal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="add_room_form" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="roomName" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="roomName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomArea" class="form-label">Area (sq ft)</label>
                                    <input type="number" class="form-control" name="area" id="roomArea" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomPrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price" id="roomPrice" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomQuantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" name="quantity" id="roomQuantity" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomAdult" class="form-label">Max Adults</label>
                                    <input type="number" class="form-control" name="adult" id="roomAdult" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomChildren" class="form-label">Max Children</label>
                                    <input type="number" class="form-control" name="child" id="roomChildren" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Features</label>
                                    <div class="row">
                                        <?php
                                        $res = selectall('features');
                                        while($opt = mysqli_fetch_assoc($res)) {
                                            echo "<div class='col-md-3'>
                                                    <div class='form-check'>
                                                        <input class='form-check-input' type='checkbox' name='features[]' value='{$opt['id']}' id='feature_{$opt['id']}'>
                                                        <label class='form-check-label' for='feature_{$opt['id']}'>{$opt['name']}</label>
                                                    </div>
                                                </div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Facilities</label>
                                    <div class="row">
                                        <?php
                                        $res = selectall('facilities');
                                        while($opt = mysqli_fetch_assoc($res)) {
                                            echo "<div class='col-md-3'>
                                                    <div class='form-check'>
                                                        <input class='form-check-input' type='checkbox' name='facilities[]' value='{$opt['sr_no']}' id='facility_{$opt['sr_no']}'>
                                                        <label class='form-check-label' for='facility_{$opt['sr_no']}'>{$opt['name']}</label>
                                                    </div>
                                                </div>";
                                        }
                                        ?>
                                    </div>
                                </div>       
                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="desc" id="description" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Room</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit room modal -->
<div class="modal fade" id="edit_room_modal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoomModalLabel">Edit this Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="edit_room_form" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="roomName" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="roomName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomArea" class="form-label">Area (sq ft)</label>
                                    <input type="number" class="form-control" name="area" id="roomArea" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomPrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price" id="roomPrice" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomQuantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" name="quantity" id="roomQuantity" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomAdult" class="form-label">Max Adults</label>
                                    <input type="number" class="form-control" name="adult" id="roomAdult" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="roomChildren" class="form-label">Max Children</label>
                                    <input type="number" class="form-control" name="child" id="roomChildren" required>
                                </div>
                            
                                <div class="col-12">
                                    <label class="form-label">Features</label>
                                 <div class="row">
                                        <?php                                                  
                                        $res = selectall('features');
                                        while($opt = mysqli_fetch_assoc($res)) {       
                                            echo "<div class='col-md-3'>
                                                    <div class='form-check'>
                                                        <input class='form-check-input' type='checkbox' name='features_edit[]' value='{$opt['id']}' id='feature_{$opt['id']}'>
                                                        <label class='form-check-label' for='feature_{$opt['id']}'>{$opt['name']}</label>
                                                    </div>
                                                </div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Facilities</label>
                                    <div class="row">
                                        <?php
                                        $res = selectall('facilities');
                                        while($opt = mysqli_fetch_assoc($res)) {
                                            echo "<div class='col-md-3'>
                                                    <div class='form-check'>
                                                        <input class='form-check-input' type='checkbox' name='facilities_edit[]' value='{$opt['sr_no']}' id='facility_{$opt['sr_no']}'>
                                                        <label class='form-check-label' for='facility_{$opt['sr_no']}'>{$opt['name']}</label>
                                                    </div>
                                                </div>";
                                        }
                                        ?>
                                    </div>
                                </div>       
                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="desc" id="description" rows="3" required></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="row_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Room</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!-- add images modal -->
<div class="modal fade" id="room_image" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Room Name</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div>
      <form id="add_image_form" enctype="multipart/form-data" method="POST">

        <label class="form-label">Add Image</label>
        <input type="file" class="form-control" name="image" accept=".jpg, .png, .webp"  id="image_room_id">
        <br>
        <input type="hidden" name= "room_id">
        
        <button type="submit" class="btn btn-primary">Add button</button>
        <br>
        <br>
        </form>
      </div>
      <!-- table -->
      <div class="table-responsive-lg" style="height:350px;overflow-y:scroll;">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="60%">Image</th>
                        <th>Thumb</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="room-image-data">
                    <!-- Room data will be loaded here -->
                </tbody>
            </table>
        </div>
      </div>
     
    </div>
  </div>
</div>


<!-- Include scripts.php -->
<?php require('scripts.php'); ?>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>

<script>
    let add_room_form = document.getElementById('add_room_form');
    add_room_form.addEventListener('submit', function (e) {
        e.preventDefault();
        add_rooms();
    });                                

    function add_rooms() {
        let data = new FormData();

        console.log("Form data:", add_room_form.elements['name'].value);

        data.append('name', add_room_form.elements['name'].value);
        data.append('area', add_room_form.elements['area'].value);
        data.append('price', add_room_form.elements['price'].value);
        data.append('quantity', add_room_form.elements['quantity'].value);
        data.append('adult', add_room_form.elements['adult'].value);
        data.append('child', add_room_form.elements['child'].value);
        data.append('desc', add_room_form.elements['desc'].value);
        data.append('add_room', '');

        let features = [];
        let featureElements = document.querySelectorAll('input[name="features[]"]:checked');
        featureElements.forEach((el) => {
            features.push(el.value);
        });

        

            // Get checked features and facilities. we can also use this 
    // let features = Array.from(document.querySelectorAll('input[name="features[]"]:checked')).map(el => el.value);
    // let facilities = Array.from(document.querySelectorAll('input[name="facilities[]"]:checked')).map(el => el.value);

        let facilities = [];
        let facilityElements = document.querySelectorAll('input[name="facilities[]"]:checked');
        facilityElements.forEach((el) => {
            facilities.push(el.value);
        });

        data.append('features', JSON.stringify(features));
        data.append('facilities', JSON.stringify(facilities));

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../ajax/room.php", true);

        xhr.onload = function () {
            console.log("Response:", this.responseText);

            var mymodal = document.getElementById('add_room_modal');
            var modal = bootstrap.Modal.getInstance(mymodal);
            modal.hide();

            if (this.responseText ==1) {
                alert("Success: Room details uploaded successfully!");
                add_room_form.reset();
            } else {
                alert("Error: Failed to upload room details. Response: " + this.responseText);
            }
        };

        xhr.send(data);          
    }

     function get_rooms(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","../ajax/room.php",true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onload= function(){
            document.getElementById('room-data').innerHTML= this.responseText;
            
        }
        xhr.send('get_rooms=1');
     }

    



     function toggle_status(id,val){
        let xhr= new XMLHttpRequest();
        xhr.open("POST", "../ajax/room.php",true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload= function(){
            if(this.responseText==1){
                alert('sucess','status toggled');
                get_rooms();
            }  
            else{
                alert('server down');
            }
          
        }
        xhr.send('toggle_status='+id+'&value='+val);
     }   

     let form_data= document.getElementById('edit_room_form');
     
     function edit_details(id){ 

       let xhr= new XMLHttpRequest();
       xhr.open("POST", "../ajax/room.php", true);
       xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       xhr.onload= function(){
        console.log("Raw response:", this.responseText);
       let data = JSON.parse(this.responseText);
       console.log(data);
      console.log (data.roomdata.name);
      form_data.elements['name'].value= data.roomdata.name;
      form_data.elements['area'].value= data.roomdata.area;
      form_data.elements['price'].value= data.roomdata.price;
      form_data.elements['quantity'].value= data.roomdata.quantity;
      form_data.elements['adult'].value= data.roomdata.adult;
      form_data.elements['child'].value= data.roomdata.children;
      form_data.elements['desc'].value= data.roomdata.description;
      form_data.elements['row_id'].value= data.roomdata.id;
    
      document.querySelectorAll("input[name='facilities_edit[]']").forEach(el => {
    if (data.facilities.includes(Number(el.value))) {
        el.checked = true;
    }
    else {
        el.checked=false;
    }
});                                      
document.querySelectorAll("input[name='features_edit[]']").forEach(el => {
    if (data.features.includes(Number(el.value))) {
        el.checked = true;
    }
    else {
        el.checked=false;
    }
});
       }
       xhr.send('edit_details=1 & id=' + id);
       
       
     }
     let edit_room_form = document.getElementById('edit_room_form');
    edit_room_form.addEventListener('submit', function (e){
        e.preventDefault();
        submit_edit_rooms();
    });

     function submit_edit_rooms() {
        let data = new FormData();

        console.log("Form data:", edit_room_form.elements['name'].value);
        data.append('room_id',edit_room_form.elements['row_id'].value)
        data.append('name', edit_room_form.elements['name'].value);
        data.append('area', edit_room_form.elements['area'].value);
        data.append('price', edit_room_form.elements['price'].value);
        data.append('quantity', edit_room_form.elements['quantity'].value);
        data.append('adult', edit_room_form.elements['adult'].value);
        data.append('child', edit_room_form.elements['child'].value);
        data.append('desc', edit_room_form.elements['desc'].value);
        data.append('edit_room', '');

        let features = [];
        let featureElements = document.querySelectorAll('input[name="features_edit[]"]:checked');
        featureElements.forEach((el) => {
            features.push(el.value);
        });

            // Get checked features and facilities. we can also use this 
    // let features = Array.from(document.querySelectorAll('input[name="features[]"]:checked')).map(el => el.value);
    // let facilities = Array.from(document.querySelectorAll('input[name="facilities[]"]:checked')).map(el => el.value);

        let facilities = [];
        let facilityElements = document.querySelectorAll('input[name="facilities_edit[]"]:checked');
        facilityElements.forEach((el) => {
            facilities.push(el.value);
        });

        data.append('features', JSON.stringify(features));
        data.append('facilities', JSON.stringify(facilities));

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../ajax/room.php", true);

        xhr.onload = function () {
            console.log("Response:", this.responseText);

            var mymodal = document.getElementById('edit_room_modal');
            var modal = bootstrap.Modal.getInstance(mymodal);
            modal.hide();

            if (this.responseText ==1) {
                alert("Success: Room details  updated!");
                add_room_form.reset();
                get_rooms();
            } else {
                alert("Error: Failed to upload room details. Response: " + this.responseText);
            }
        };

        xhr.send(data);          
    }

    let add_image_form= document.getElementById('add_image_form');

    add_image_form.addEventListener('submit',function(e){
        e.preventDefault();
        add_image();
    })
     
    function add_image(){


        let imageFile = add_image_form.elements['image'].files[0];

    
    if (!imageFile) {
        alert("Please select an image before submitting.");
        return;
    }

        let data= new FormData();
        data.append('image',imageFile);
        data.append('room_id',add_image_form.elements['room_id'].value);
        data.append('add_image','');

        let xhr= new XMLHttpRequest();
        xhr.open("POST","../ajax/room.php",true);
        xhr.onload=function(){
            let res = this.responseText.trim();
            if(res==='invalid_image'){
                alert("error");
            }
            else if(res==='invalid_size'){
                alert("error");
            }
            else if(res==='upload_failed'){
                alert("error");
            }
            else{
                
                console.log(this.responseText);
                if(res=='success'){
                room_images(add_image_form.elements['room_id'].value,document.querySelector('#room_image .modal-title').innerText)
                alert('sucess,New Image added');
               
                add_image_form.reset();
                      
                }
                else{
                    alert("not uploaded")
                }
                
            }                                                              
        }
        xhr.send(data);
    }

    function room_images(id,rname){

        add_image_form.elements['room_id'].value= id;
        document.querySelector('#room_image .modal-title').innerText= rname;
       
        let xhr= new XMLHttpRequest();
        xhr.open("POST","../ajax/room.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            
           
            document.getElementById('room-image-data').innerHTML= this.responseText;      
        }
        xhr.send('get_room_image='+id);
    }

    function rem_images(img_id,room_id){
        let data= new FormData();
        data.append('img_id',img_id);
        data.append('room_id',room_id);
        data.append('rem_images','');

        let xhr= new XMLHttpRequest();
        xhr.open("POST","../ajax/room.php",true);
        xhr.onload= function(){
            console.log(this.responseText);
           if(this.responseText==1){
            alert("successfully Deleted");
            room_images(add_image_form.elements['room_id'].value,document.querySelector('#room_image .modal-title').innerText);
           }
           else{
            alert("Server Error");
           }
           
        }
        xhr.send(data);
    }

    function thumb_images(sr_no, id){
        let xhr= new XMLHttpRequest();
        xhr.open("POST","../ajax/room.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            console.log(this.responseText);
           if(this.responseText==1){
            room_images(add_image_form.elements['room_id'].value,document.querySelector('#room_image .modal-title').innerText);
           }
           else{
            alert("Error! Not Updated");
           }
                 
        }
        xhr.send('update_room_image='+sr_no+ '&room_id=' +id);
        
    }

    function Delete_room(id){
        let data= new FormData();
        data.append('delete_room',id);
        let xhr= new XMLHttpRequest();
        xhr.open("POST","../ajax/room.php",true);

        xhr.onload= function(){
            console.log(this.responseText);
            if(this.responseText==1){
                get_rooms();
                alert("Sucessfully Deleted");
            }
            else{
                alert("Server Error");
            }
        }
        xhr.send(data);
    }

     





     window.onload=function(){ 
        get_rooms();
        
    };


</script>



</body>
</html>
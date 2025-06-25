<?php
require('header.php'); 
require('scripts.php');       
require('db_confg.php');        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   

    <style>
        /* Sticky Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px; /* Below header */
            left: 0;
            height: calc(100vh - 56px);
            width: 250px;
            background-color: #212529;
            padding: 20px;
            transition: transform 0.3s ease-in-out;
            z-index: 1000; /* Sidebar stays on top */
        }

        /* Sidebar Hidden (Moves Sidebar Off-screen) */
        .sidebar.hidden {
            transform: translateX(-250px);
        }

        /* Main Content (Ensures Sidebar Pushes Content) */
        .main-content {
            margin-left: 250px;
            margin-top: 56px; /* Offset for header */
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        /* When Sidebar is Hidden, Expand Main Content */
        .main-content.full-width {
            margin-left: 0 !important;
        }

        /* Toggle Button */
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 10px;
            z-index: 1101; /* Ensure button is clickable */
            background-color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Mobile View Fix */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0; /* Prevent shifting */
            }
        }

        /* Features & Facilities Section Styles */
        .section {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .section h2 {
            margin-top: 0;
            display: inline-block;
            margin-right: 15px;
        }

        .section .add-btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }

        .section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .section th, .section td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .section th {
            background-color: #f2f2f2;
        }

        .section .delete-btn {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-content h3 {
            margin-top: 0;
        }

        .modal-content label {
            display: block;
            margin-bottom: 5px;
        }

        .modal-content input[type="text"],
        .modal-content input[type="file"],
        .modal-content textarea {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .modal-content textarea {
            resize: vertical;
        }

        .modal-content button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .modal-content button.cancel {
            background-color: #dc3545;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .facility-icon {
            max-width: 50px;
            max-height: 50px;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="header bg-dark text-light p-3 d-flex align-items-center justify-content-between" id="header">
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <h3 class="mb-0">Hi Admin!</h3>
    <a href="logout.php" class="btn btn-light btn-sm">LOG OUT</a>
</div>

<div class="sidebar hidden" id="sidebar">
    <h5 class="text-light">Dashboard</h5>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link text-light" href="dashboard.php">Home</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="features.php">Features & Facilities</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="manage_rooms.php">Manage Rooms</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="manage_bookings.php">Manage Bookings</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="setting.php">Settings</a></li>
    </ul>
</div>

<div class="main-content" id="main-content">
    <div class="section">
        <h2>Rooms</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_room_modal">Add Room</button>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Area</th>
                    <th>Guests</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <div id="add_room_modal" class="modal">
            <div class="modal-content">
                <form id="add_room_form" method="POST" action="../ajax/room.php">
                    <span class="close" id="closeAddRoomModal">&times;</span>
                    <h3>Add Room</h3>

                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <div style="flex: 1; min-width: 45%;">
                            <label for="roomName">Name</label>
                            <input type="text" name="name" id="roomName" placeholder="Enter room name">
                        </div>

                        <div style="flex: 1; min-width: 45%;">
                            <label for="roomArea">Area</label>
                            <input type="text" name="area" id="roomArea" placeholder="Enter area">
                        </div>

                        <div style="flex: 1; min-width: 45%;">
                            <label for="roomPrice">Price</label>
                            <input type="text" name="price" id="roomPrice" placeholder="Enter price">
                        </div>

                        <div style="flex: 1; min-width: 45%;">
                            <label for="roomQuantity">Quantity</label>
                            <input type="text" name="quantity" id="roomQuantity" placeholder="Enter quantity">
                        </div>

                        <div style="flex: 1; min-width: 45%;">
                            <label for="roomAdult">Adult (Max.)</label>
                            <input type="text" name="adult" id="roomAdult" placeholder="Enter max adults">
                        </div>

                        <div style="flex: 1; min-width: 45%;">
                            <label for="roomChildren">Children (Max.)</label>
                            <input type="text" name="child" id="roomChildren" placeholder="Enter max children">
                        </div>
                        
                        <!-- Features -->
                        <div style="flex: 1; min-width: 45%;">
                            <label for="roomFeatures">Features</label>
                            <div class="row">
                                <?php
                                $res = selectall('features');
                                while($opt = mysqli_fetch_assoc($res)) {
                                    echo "<div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='features[]' value='{$opt['id']}' class='form-check-input shadow'>
                                            {$opt['name']}
                                        </label>
                                    </div>";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div style="flex: 1; min-width: 45%;">
                            <label for="roomFacilities">Facilities</label>
                            <div class="row">
                                <?php
                                $res = selectall('facilities');
                                while($opt = mysqli_fetch_assoc($res)) {
                                    echo "<div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='facilities[]' value='{$opt['sr_no']}' class='form-check-input shadow'>
                                            {$opt['name']}
                                        </label>
                                    </div>";
                                }
                                ?>
                            </div>
                        </div>



                        <!-- discription -->
                        <div style="flex: 1 0 100%;">
                            <label for="roomFeatures">Description</label>
                            <textarea name="desc" id="description" placeholder="Enter about room "></textarea>
                        </div>

                        

                    <button type="submit">Add Room</button>
                    <button type="button" class="cancel" id="cancelAddRoom">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        sidebar.classList.toggle('hidden');
        mainContent.classList.toggle('full-width');
    }

    // Modal Logic
    document.getElementById('closeAddRoomModal').addEventListener('click', function() {
        document.getElementById('add_room_modal').style.display = 'none';
    });

    document.getElementById('cancelAddRoom').addEventListener('click', function() {
        document.getElementById('add_room_modal').style.display = 'none';
    });

    // To open modal
    document.querySelector('[data-bs-toggle="modal"]').addEventListener('click', function() {
        document.getElementById('add_room_modal').style.display = 'block';
    });
</script>








<script>
  let add_room_form = document.getElementById('add_room_form');
add_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_rooms();
});

function add_rooms() {
    let data = new FormData();

    // Log form data to debug
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

    let facilities = [];
    let facilityElements = document.querySelectorAll('input[name="facilities[]"]:checked');
    facilityElements.forEach((el) => {
        facilities.push(el.value);
    });

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    // // Log data before sending
    // console.log("Sending data:", data);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/room.php", true);

    xhr.onload = function () {
        console.log("Response:", this.responseText);

        var mymodal = document.getElementById('add_room_modal');
        var modal = bootstrap.Modal.getInstance(mymodal);
        modal.hide();
    
        if (this.responseText === "hello") {
            alert("Success: Room details uploaded successfully!");
            add_room_form.reset();
        } else {
            alert("Error: Failed to upload room details. Response: " + this.responseText);
        }
    };

    xhr.send(data);
}


</script>


</body>
</html>





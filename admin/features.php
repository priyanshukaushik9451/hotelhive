<?php
require('header.php'); 
require('scripts.php');          
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

<?php
require('scripts.php');
?>

    <!-- <div class="header bg-dark text-light p-3 d-flex align-items-center justify-content-between" id="header">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3 class="mb-0">Hi Admin!</h3>
        <a href="logout.php" class="btn btn-light btn-sm">LOG OUT</a>
    </div>

    <div class="sidebar hidden" id="sidebar">
        <h5 class="text-light">Dashboard</h5>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link text-light" href="dashboard.php">Home</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="features.php">Featurs & Facilites</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="manage_rooms.php">Manage Rooms</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="manage_bookings.php">Manage Bookings</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="setting.php">Settings</a></li>
        </ul>
    </div> -->

    <div class="main-content" id="main-content">
        <div class="section">
            <h2>Facilities</h2>
            <button id="addFacilityBtn" class="add-btn">Add</button>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><img src="uploads/wifi.png" alt="Wifi Icon" class="facility-icon"></td>
                        <td>Wifi</td>
                        <td>Lorem ipsum dolor sit amet...</td>
                        <td><button class="delete-btn">Delete</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><img src="uploads/ac.png" alt="AC Icon" class="facility-icon"></td>
                        <td>Air Conditioner</td>
                        <td>Temporibus incidunt odio...</td>
                        <td><button class="delete-btn">Delete</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><img src="uploads/tv.png" alt="TV Icon" class="facility-icon"></td>
                        <td>Television</td>
                        <td>Lorem ipsum dolor sit amet...</td>
                        <td><button class="delete-btn">Delete</button></td>
                    </tr>
                </tbody>
            </table>

            <div id="facilityModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeFacilityModal">&times;</span>
                    <h3>Add Facility</h3>
                    <label for="facilityName">Facility Name:</label>
                    <input type="text" id="facilityName" placeholder="Enter facility name">
                    <label for="facilityDescription">Description:</label>
                    <textarea id="facilityDescription" placeholder="Enter facility description"></textarea>
                    <label for="facilityIcon">Icon:</label>
                    <input type="file" id="facilityIcon" accept="image/*">
                    <button id="saveFacilityBtn">Save</button>
                    <button class="cancel" id="cancelFacilityBtn">Cancel</button>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Features</h2>
            <button id="addFeatureBtn" class="add-btn">Add Feature</button>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Swimming Pool</td>
                        <td><button class="delete-btn">Delete</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Gym</td>
                        <td><button class="delete-btn">Delete</button></td>
                    </tr>
                </tbody>
            </table>

            <div id="featureModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeFeatureModal">&times;</span>
                    <h3>Add Feature</h3>
                    <label for="featureName">Feature Name:</label>
                    <input type="text" id="featureName" placeholder="Enter feature name">
                    <button id="saveFeatureBtn">Save</button>
                    <button class="cancel" id="cancelFeatureBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let content = document.querySelector(".main-content");

            sidebar.classList.toggle("hidden");

            if (sidebar.classList.contains("hidden")) {
                content.style.marginLeft = "0";
            } else {
                content.style.marginLeft = "250px";
            }
        }

        // JavaScript to handle modal functionality
        const featureModal = document.getElementById("featureModal");
        const addFeatureBtn = document.getElementById("addFeatureBtn");
        const closeFeatureModal = document.getElementById("closeFeatureModal");

        addFeatureBtn.onclick = function() {
            featureModal.style.display = "block";
        }

        closeFeatureModal.onclick = function() {
            featureModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == featureModal) {
                featureModal.style.display = "none";
            }
        }

        const facilityModal = document.getElementById("facilityModal");
        const addFacilityBtn = document.getElementById("addFacilityBtn");
        const closeFacilityModal = document.getElementById("closeFacilityModal");

        addFacilityBtn.onclick = function() {
            facilityModal.style.display = "block";
        }

        closeFacilityModal.onclick = function() {
            facilityModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == facilityModal) {
                facilityModal.style.display = "none";
            }
        }

        // Feature Modal Cancel
        document.getElementById("cancelFeatureBtn").onclick = function() {
            featureModal.style.display = "none";
        }

        // Facility Modal Cancel
        document.getElementById("cancelFacilityBtn").onclick = function() {
            facilityModal.style.display = "none";
        }
    </script>

</body>
</html>

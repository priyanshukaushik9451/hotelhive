

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <style>
        /* Sticky Header */
        /* Sticky Header */
/* Sticky Header */
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
    margin-left: 0; /* Removed !important */
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



    </style>
</head>
<body>

<?php
require('scripts.php');
?>

    <!-- Header -->
    <div class="header bg-dark text-light p-3 d-flex align-items-center justify-content-between" id="header">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3 class="mb-0">W    Hii Admin!</h3>
        <a href="logout.php" class="btn btn-light btn-sm">LOG OUT</a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar hidden" id="sidebar">
        <h5 class="text-light">Dashboard</h5>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link text-light" href="dashboard.php">Home</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="features.php">Featurs & Facilites</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="manage_rooms.php">Manage Rooms</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="manage_bookings.php">Manage Bookings</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="setting.php">Settings</a></li>
        </ul>
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






    </script>

</body>
</html>

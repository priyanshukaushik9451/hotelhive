<?php
require('essential.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            transition: 0.3s ease-in-out;
        }

        /* Sidebar Hidden */
        .sidebar.hidden {
            left: -250px;
        }

        /* Sidebar Links */
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #343a40;
            border-radius: 5px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            margin-top: 56px; /* Offset for header */
            padding: 20px;
            transition: 0.3s ease-in-out;
        }

        /* When Sidebar is Hidden */
        .main-content.full-width {
            margin-left: 0;
        }

        /* Toggle Button */
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 10px;
            z-index: 1100;
            background-color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <?php
    require('header.php');?>

    <!-- Main Content -->
    <div class="main-content full-width" id="main-content">
        <h3>Welcome to Admin Panel</h3>
        <p>Select an option from the sidebar to manage the website.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget...</p>
        <p>More long content... 
            
        </p>
    </div>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let content = document.getElementById("main-content");

            sidebar.classList.toggle("hidden");
            content.classList.toggle("full-width");
        }
    </script>

</body>
</html>

<?php 
ob_start();
session_start();
include_once "db.php";
include_once "function.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <!-- Navbar start -->
        <nav class="navbar navbar-dark bg-info">
            <a class="navbar-brand" href="index.php">Job Test</a>
            <ul class="navbar-nav d-flex flex-row">
                <?php if(isset($_SESSION["user_name"])) { ?>
                    <li class="nav-item">
                        <a class="nav-link mr-2" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-2" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link mr-2" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-2" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- Navabar End -->
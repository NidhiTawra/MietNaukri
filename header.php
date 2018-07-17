<?php
$file = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/stylesheets/style.css">
    <script src="assets/scripts/script.js"></script>
    <link rel="stylesheet" href="assets/choosen/chosen.css">
    <script src="assets/choosen/chosen.jquery.js"></script>
</head>
<body>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a>
</div>

<nav class="navbar navbar-inverse" id="main">
    <div class="container-fluid">
        <div class="navbar-header">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()"  class="navbar-brand" >&#9776;</span>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="index.php">MIET JOB PORTAL</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="login.php">Home</a></li>
                    <?php
                    if($file == "dashboard.php") echo "<li><a href=\"apply.php\">Apply For Jobs</a></li>";
                    elseif($file == "empdash.php") echo "<li><a href='post.php'>Post Jobs</a></li>";
                    ?>
                <li><?php
                    if ($error_msg != '') echo $error_msg;
                    ?></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php

                if($file == "login.php")
                    echo "<li><a href=\"signup.php\"><span class=\"glyphicon glyphicon-user\"></span> Sign Up</a></li>";
                elseif($file == "signup.php")
                    echo "<li><a href=\"login.php\"><span class=\"glyphicon glyphicon-log-in\"></span> Login</a></li>";
                elseif($file == "index.php")
                    echo "<li><a href=\"signup.php\"><span class=\"glyphicon glyphicon-user\"></span> Sign Up</a></li><li><a href=\"login.php\"><span class=\"glyphicon glyphicon-log-in\"></span> Login</a></li>";
                else
                    echo "<li><a href=\"logout.php\"><span class=\"glyphicon glyphicon-log-in\"></span> Logout</a></li>";
                ?>

            </ul>
        </div>
    </div>
</nav>

<!--</span>-->
<!---->
<!---->
<!--</div>-->
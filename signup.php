<?php

session_start();
include_once 'includes/functions.php';
include_once 'includes/login_database.php';
$error_msg = '';

if(!empty($_SESSION['id'])) header("Location: dashboard.php");

if(isset($_POST['submit'])) {

    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['number']) && !empty($_POST['location']) && !empty($_FILES['resume'])) {

        $email = $_POST['email'];
        $query = "select id from student where email='$email'";
        $result = $conn->query($query);
if($result->num_rows == 0) {
//        echo $email;
if (check_email($email)) {

if(verify_email($conn,$email)) {
$name = $_POST['name'];
//            echo $name;
if (check_name($name)) {

$password = $_POST['password'];
//                echo $password;
if (!check_password($password)) {

$number = $_POST['number'];
//                    echo $number;
$password = hash('sha512', $password);
if (check_number($number)) {
$location_id = $_POST['location'];
//                            $result->close();
$resume = $_FILES['resume'];
if (check_file($resume)) {

$file_name = $resume['name'];
//                            echo $file_name;
$stmt = $conn->prepare("insert into student values (null,?,?,?,null,null,null,false ,false ,?,0,?)");
$stmt->bind_param('ssiis', $email, $password, $number, $location_id, $name);
$stmt->execute();
$id = $conn->insert_id;
mkdir("resume/$id/");
$file_name = time() . $file_name;
$stmt = $conn->prepare("update student set last_resume=? where id=?");
$stmt->bind_param('si', $file_name, $id);
$stmt->execute();
$file_parts = pathinfo($file_name);
$extension = $file_parts['extension'];
$file_name = time() . '.' . $extension;
move_uploaded_file($resume['tmp_name'], "resume/$id/$file_name");
$result = $conn->query("insert into resume values ('$file_name',$id,null)");
$conn->query("insert into locations values ($id,$location_id)");
$_SESSION['id'] = $id;
$_SESSION['type'] = 'Student';
header("Location: education.php"); //register=1

} else
$error_msg = "File can only be doc, docx, pdf or rtf";

} else
$error_msg = "Number is invalid";
} else
$error_msg = "Password should contain lower case, upper case and number";
} else
$error_msg = "Name is invalid";
}
else
$error_msg = "Email already in use";
} else
$error_msg = "Email is invalid";
}
else $error_msg = "Email already in use";

}else
$error_msg = "Some fields are empty";

}


include_once 'header.php';
?>


<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="main.js"></script>
  	<link rel="stylesheet" type="text/css" href="./assets/stylesheets/style.css">
</head>
<body>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#">About</a>
  <a href="#">Services</a>
  <a href="#">Clients</a>
  <a href="#">Contact</a>
</div>

<nav class="navbar navbar-inverse navbar-fixed-top" id="main">
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
        <li class="active"><a href="#">Sign-Up</a></li>
        <li><a href="index.php">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Page 1-1</a></li>
            <li><a href="#">Page 1-2</a></li>
            <li><a href="#">Page 1-3</a></li>
          </ul>
        </li>
        <li><a href="#">Page 2</a></li>
        <li><a href="#">Page 3</a></li>
          <li><?php

              echo $error_msg;

              ?></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="split sleft" id="left" >
  <div class="centered">
    <img src="assets/images/img_avatar.png" alt="SIGN-UP as Employee" onclick="ifleft()">
    <h2 onclick="ifleft()">SIGN UP AS A JOB SEEKER</h2>
  </div>
</div>

<div class="split sright" id="right">
  <div class="centered">
    <img src="doc.jpg" alt="Resume Upload" onclick="alert('NOTE: Registering With MietJobPortal will provide you ease of tracking your application for an applied job. But if You do not wish to register, that\'s fine, we understand.');ifright()">
    <h2 onclick="alert('NOTE: Registering With MietJobPortal will provide you ease of tracking your application for an applied job. But if You do not wish to register, that\'s fine, we understand.');ifright()">Upload Resume Without Signing In</h2>
  </div>
</div>

<div id="leftreplace" class="split sleft" style="display: none">
  <div class="centered">
    <span class="glyphicon glyphicon-remove" style="float: right" onclick="splitinit()"></span>
    <center><h3 style="font-family:serif ; color:black"><em><i>UPLOAD-RESUME</i></em></h3></center>
    <form method="post" action="#">
      <center>
        <em style="float:left; margin-left:10%; color:black; font-size: 20px">Upload Resume:</em>
        <input type="file" id="resume" class="file" style="float: center" required><br>
        <input type="submit" class="btn" value=" Register " style="margin-top:2px">
      </center>
    </form>
  </div>
</div>
     
<div id="rightreplace" class="split sright" style="display:none">
  <div class="centered">
    <span class="glyphicon glyphicon-remove" style="float: right" onclick="splitinit()"></span>
    <center><h3 style="font-family:serif ; color:black"><em><i>SIGN-UP</i></em></h3></center>
    <form method="post" action="signup.php" enctype="multipart/form-data">

       	<div>
	    	<center>
		    	<input type="text" name="name" id="name" placeholder="  Enter Name" class="ip" size="50%" required><br>
		        <input type="email" id="id" name="email" placeholder="  Enter Email-ID" size="50%" class="ip" required><br>
		        <input type="text" id="pass" name="password" size="50%" placeholder=" Enter Password" class="ip" required><br>
		        <input type="text" id="contact" name="number" size="50%" placeholder=" Enter Contact Number" class="ip" required><br>
                <select  class="simple-select" name="location">
                    <option value="-1">Location</option>
                    <!--          --><?php
          $json = json_decode(file_get_contents('assets/json_data/locations.json'),true);
//          print_r($json);
          foreach ($json as $item) {
              $id = $item['id'];
              $text = $item['text'];
              if(!empty($_POST['location']) && $_POST['location'] == $id)
                  echo "<option selected value='$id'>$text</option>";
                    else
                    echo "<option value='$id'>$text</option>";
                    }
                    //          ?>
                </select>
                <input type="file" id="resume" name="resume" class="file" style="float: center" required><br>
		        <input type="submit" name="submit" class="btn btn-success" value="Education Details">
		    </center>
        </div>

    <center>
<!--    	<input type="submit" name="submit" class="btn" value=" Register " style="margin-top:2px;display: none">-->
    </center>

    </form>
  </div>
</div>

<script src="assets/choosen/chosen.jquery.js"></script>
<script>
    $('.simple-select').chosen({width: "334px"});
</script>

</body>
</html> 

<?php

//session_start();
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

<div class="split sleft" id="left" >
  <div class="centered">
    <img src="assets/images/img_avatar2.png" alt="SIGN-UP as Student" onclick="ifleft()">
    <h2 onclick="ifleft()">SIGN UP AS A JOB SEEKER</h2>
  </div>
</div>

<div class="split sright" id="right">
  <div class="centered">
    <img src="assets/images/img_avatar.png" alt="SIGN-UP as Employer" onclick="ifright()">
    <h2 onclick="ifright()">SIGN UP AS A JOB PROVIDER</h2>
  </div>
</div>

<div id="leftreplace" class="split sleft" style="display: none">
  <div class="centered">
    <span class="glyphicon glyphicon-remove" style="float: right" onclick="splitinit()"></span>
    <center><h3 style="font-family:serif ; color:black"><em><i>SIGN-UP</i></em></h3></center>
    <form method="post" action="#">
      <center>
        <input type="text" id="name" placeholder="  Enter Name" class="ip" size="50%" required><br>
        <input type="email" id="id" placeholder="  Enter Email-ID" size="50%" class="ip" required><br>
        <input type="text" id="pass" size="50%" placeholder=" Enter Password" class="ip" required><br>
        <input type="text" id="contact" size="50%" placeholder=" Enter Contact Number" class="ip" required><br>
        <input type="text" id="location" size="50%" placeholder=" Enter Your City" class="ip" required><br><br>
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
      <center>
        <input type="text" id="name" name="name" placeholder="  Enter Name" class="ip" size="50%" required value="<?php if(!empty($_POST['name'])) echo $_POST['name'] ?>"><br>
        <input type="email" id="id" name="email" placeholder="  Enter Email-ID" size="50%" class="ip" required value="<?php if(!empty($_POST['email'])) echo $_POST['email'] ?>"><br>
        <input type="text" id="pass" name="password" size="50%" placeholder=" Enter Password" class="ip" required value="<?php if(!empty($_POST['password'])) echo $_POST['password'] ?>"><br>
        <input type="text" id="contact" name="number" size="50%" placeholder=" Enter Contact Number" class="ip" required value="<?php if(!empty($_POST['number'])) echo $_POST['number'] ?>"><br>
<!--        <input type="text" id="location" name="location" list="loc" size="50%" placeholder=" Enter Your City" class="ip" required><br><br>-->
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
        <em style="float:left; margin-left:10%; color:black; font-size: 20px">Upload Resume:</em>
        <input value="<?php if(!empty($_FILES['resume'])) echo $_FILES['resume'] ?>" type="file" id="resume" class="file" name="resume" style="float: center" required><br>
        <input type="submit" class="btn" value=" Register " name="submit" style="margin-top:2px">
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

<?php
session_start();
include_once 'includes/login_database.php';
include_once 'includes/functions.php';
$error_msg = '';

//destroy_session();

if(!empty($_SESSION['id'])) {
    if($_SESSION['type'] =='Student')
        header("Location: dashboard.php");
    else
        header("Location: empdash.php");

}
if(isset($_POST['submit'])) {

    if (!empty($_POST['unique-id']) && !empty($_POST['password'])) {

        $email = $_POST['unique-id'];
        $password = $_POST['password'];
        $password = hash('sha512', $password);
        $id = '';
        $stmt = $conn->prepare('select id from employer where unique_id=? and password=?');
        $stmt->bind_param('ss', $email,$password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {

            $_SESSION['id'] = $id;
            $_SESSION['type'] = 'Employer';
            header("Location: empdash.php");

        } else {

            $error_msg = 'ID/Password is invalid';

        }

    }

    elseif (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = hash('sha512', $password);
        $id = '';
        $stmt = $conn->prepare('select id from student where email=? and password=?');
        $stmt->bind_param('ss', $email,$password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {

            $_SESSION['id'] = $id;
            $_SESSION['type'] = 'Student';
            header("Location: dashboard.php");

        } else {

            $error_msg = 'Email/Password is invalid';

        }
    }else $error_msg = "Some fields are empty";
}

include_once "header.php";
?>
<div class="split lleft" id="left">
  <div class="centered">
   <img src="assets/images/img_avatar2.png" alt="Login as Employee" onclick="ifleft()">
   <h2 onclick="ifleft()">LOGIN AS A JOB SEEKER</h2>
  </div>
</div>


<div class="split lright" id="right">
  <div class="centered">
   <img src="assets/images/img_avatar.png" alt="Login as Employer" onclick="ifright()" >
    <h2 onclick="ifright()">LOGIN AS A JOB PROVIDER</h2>
  </div>
</div>

<div class="split lleft" id="leftreplace" style="display: none">
  <div class="centered">
    <span class="glyphicon glyphicon-remove" style="float: right" onclick="splitinit()"></span>
    <center><h3 style="font-family:serif ; color:yellow"><em><i>Login</i></em></h3></center>
    <form method="post" action="login.php">
      <center>
      <input type="text" id="logid" size="50%" name="unique-id" placeholder=" Enter Unique-ID" required><br>
      <input type="text" id="logpass" size="50%" name="password" placeholder=" Enter Password" required><br>
      <input type="submit" class="btn btn-danger" value="LOGIN" name="submit" style="margin-top:2px">
      </center>
    </form>
  </div>
</div>

<div class="split lright" id="rightreplace" style="display: none">
  <div class="centered">
    <span class="glyphicon glyphicon-remove" style="float: right" onclick="splitinit()"></span>
    <center><h3 style="font-family:serif ; color:red"><em><i>Login</i></em></h3></center>
    <form method="post" action="login.php">
      <center>
      <input type="email" id="logid" name="email" placeholder="  Enter Email-ID" size="50%" required><br>
      <input type="text" id="logpass" size="50%" name="password" placeholder=" Enter Password" required><br>
      <input type="submit" class="btn btn-danger" value="LOGIN" name="submit" style="margin-top:2px">
      </center>
    </form>
  </div>
</div>


</body>
</html> 

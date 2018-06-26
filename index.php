<?php
/**
 * Created by PhpStorm.
 * User: groot
 * Date: 6/20/18
 * Time: 3:24 PM
 */

session_start();
include_once 'includes/login_database.php';
$error_msg = '';

if(!empty($_SESSION['id'])) {

    header("Location: dashboard.php");

}
if(isset($_POST['submit'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        $id = '';
        $stmt = $conn->prepare('select id from student where email=? and password=?');
        $stmt->bind_param('ss', $_POST['email'], hash('sha512', $_POST['password']));
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {

            $_SESSION['id'] = hash('ripemd160', $id);
            header("Location: dashboard.php");

        } else {

            $error_msg = 'Email/Password is invalid';

        }
    }else $error_msg = "Some fields are empty";
}


?>

<html>

    <head>

        <title>Login</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

        <style>

            .form {

                margin-left: 50px;

            }

        </style>

        <script>

            function signup() {
                window.location.href = 'signup.php';
                return false;
            }

        </script>
    </head>


    <body>


    <!-- Textfield with Floating Label -->
    <div class="form">
    <form action="index.php" method="post">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="sample3" name="email" value="<?php if(!empty($_POST['email']))echo $_POST['email']; ?>">
            <label class="mdl-textfield__label" for="sample3">Email</label>
        </div>
        <br>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="password" id="sample3" name="password" value="<?php if(!empty($_POST['password'])) echo $_POST['password']; ?>">
            <label class="mdl-textfield__label" for="sample3">Password</label>
        </div>
        <br>
        <!-- Accent-colored raised button with ripple -->
        <button name="submit" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
            Login
        </button>

    </form>
        <button onclick="signup()" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
            Signup
        </button>

        <?php

        echo $error_msg;

        ?>


    </div><br>

    </body>


</html>
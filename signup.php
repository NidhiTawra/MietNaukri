<?php
/**
 * Created by PhpStorm.
 * User: groot
 * Date: 6/21/18
 * Time: 2:40 PM
 */

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

                if(verify_email($email)) {

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



?>

<html>

<head>

    <title>Signup</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script src="scripts/ajax_json.js"></script>

    <style>

        .form {

            margin-left: 50px;

        }

    </style>


</head>


<body>

<!-- Simple Textfield -->
<div class="form">
<form action="signup.php" method="post" enctype="multipart/form-data">
    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sample1" name="name" value="<?php if(!empty($_POST['name'])) echo $_POST['name'] ?>">
        <label class="mdl-textfield__label" for="sample1">Name</label>
    </div><br>

    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sample2" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email'] ?>">
        <label class="mdl-textfield__label" for="sample2">Email</label>
    </div><br>

    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" id="sample3" name="password" value="<?php if(!empty($_POST['password'])) echo $_POST['password'] ?>">
        <label class="mdl-textfield__label" for="sample3">Password</label>
    </div><br>

    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="sample4" name="number" value="<?php if(!empty($_POST['number'])) echo $_POST['number'] ?>">
        <label class="mdl-textfield__label" for="sample24">Contact Number</label>
        <span class="mdl-textfield__error">Input is not a number!</span>
    </div><br>

        Location: <select name="location" id="location" style="width:300px"></select><br><br>
    <!-- Accent-colored raised button with ripple -->
    Resume: <input type="file" name="resume"><br><br>

    <button type="submit" name="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
        Submit
    </button>

</form>
    <?php
    echo $error_msg;
    ?>
</div>


<script>

    $(document).ready(function () {
        $.ajax({
            url: 'json_data/locations.json',
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {

                json = JSON.parse(JSON.stringify(data));
                $('#location').select2({
                    data: json
                });
            },
        })
    })


</script>

</body>


</html>

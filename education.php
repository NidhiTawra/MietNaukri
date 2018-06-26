<?php
/**
 * Created by PhpStorm.
 * User: groot
 * Date: 6/24/18
 * Time: 11:06 PM
 */
session_start();

if(empty($_SESSION['id'])) header("Location: index.php");

include_once 'includes/login_database.php';
include_once 'includes/functions.php';
$error_msg = '';

if(isset($_POST['submit'])) {

    if(!empty($_POST['qualification']) && !empty($_POST['course']) && !empty($_POST['specialization']) && !empty($_POST['college']) && !empty($_POST['year'])) {

        if($_POST['qualification'] != -1) {

            if($_POST['course'] != -1) {

                if($_POST['specialization'] != -1) {

                    $specialization_id = $_POST['specialization'];
                    if(check_name($_POST['college'])) {

                        $college = $_POST['college'];
                        if(check_year($_POST['year'])) {
                            $id = $_SESSION['id'];
                            $year = $_POST['year'];
                            $stmt = $conn->prepare("insert into colleges values (?,?,?,?,null)");
                            $stmt->bind_param('siii',$college,$id,$year,$specialization_id);
                            $stmt->execute();
                            header("Location: dashboard.php");

                        }
                        else
                            $error_msg = "Invalid Year";

                    }
                    else
                        $error_msg = "Invalid College Name";

                }
                else
                    $error_msg = "Select Specialization";

            }
            else
                $error_msg = "Select course";

        }
        else
            $error_msg = "Select Highest Qualification";

    }
    else
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

    <style>

        .form {

            margin-left: 50px;
            margin-top: 150px;

        }

    </style>


</head>


<body>

<!--<datalist id="qualification"></datalist>-->
<!--<datalist id="course"></datalist>-->
<!--<datalist id="specialization"></datalist>-->

<div class="form">
<!-- Simple Textfield -->
<form action="education.php" method="post">

    Highest Qualification: <select id="qualification" name="qualification"></select><br><br>
    Course: <select name="course" id="course" style="width: 300px"></select><br><br>
    Specialization: <select name="specialization" style="width: 300px" id="specialization"></select><br><br>

    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sample1" name="college" value="<?php if(!empty($_POST['college'])) echo $_POST['college'] ?>">
        <label class="mdl-textfield__label" for="sample1">College</label>
    </div>
    <br>

    <!-- Numeric Textfield -->
        <div class="mdl-textfield mdl-js-textfield">
            <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" name="year" value="<?php if(!empty($_POST['year'])) echo $_POST['year']  ?>">
            <label class="mdl-textfield__label" for="sample2">Passing Year</label>
            <span class="mdl-textfield__error">Input is not a number!</span>
        </div><br>

    <?php
    $button = 'Add';
    if(isset($_GET['register'])) {
        include_once 'skills.php';
        $button = 'Submit';
    }

    ?>

    <button type="submit" name="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
        <?php echo $button; ?>
    </button>
</form>

    <?php echo $error_msg; ?>

</div>

<script>

    $(document).ready(function () {
        datalist = document.getElementById('qualification');
        $.ajax({
            url: 'json_data/qualifications.json',
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                json = JSON.parse(JSON.stringify(data));
                json.forEach(function (item) {
                    option = document.createElement('option');
                    option.text = item['text'];
                    option.value = item['id'];
                    datalist.add(option);
                })
            },
        })
    });

    $('#qualification').change(function () {
        datalist = document.getElementById('course');
        datalist.options.length = 0;
        e = document.getElementById("qualification");
        id = e.options[e.selectedIndex].value;
        $.ajax({
            url: 'ajax/course.php',
            type: 'GET',
            // url: 'json_data/'+id+'.json',
            dataType:'JSON',
            data: 'id='+id,
            success: function (data) {
                json = JSON.parse(JSON.stringify(data));
                json.forEach(function (item) {
                    option = document.createElement('option');
                    option.text = item['name'];
                    option.value = item['id'];
                    datalist.add(option);
                })

            },
            error: function (jqXHR,textStatus,errorThrown) {
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        })
    });

    $('#course').change(function () {
        datalist = document.getElementById('specialization');
        datalist.options.length = 0;
        e = document.getElementById("course");
        id = e.options[e.selectedIndex].value;
        $.ajax({
            url: 'ajax/specialization.php',
            type: 'GET',
            dataType: 'JSON',
            data: 'id='+id,
            success: function (data) {
                json = JSON.parse(JSON.stringify(data));
                json.forEach(function (item) {
                    option = document.createElement('option')
                    option.value = item['id']
                    option.text = item['name']
                    datalist.add(option);
                })
            },
            error: function (jqXHR,textStatus,errorThrown) {
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        })
    })


</script>

</body>
</html>

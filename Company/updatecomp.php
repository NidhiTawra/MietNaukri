<?php
/**
 * Created by PhpStorm.
 * User: groot
 * Date: 8/4/18
 * Time: 12:40 AM
 */

require_once 'header.php';
?>

<div class="container-fluid decor_bg" id="middle">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary" >
                <div class="panel-heading">
                    <h4>Update Company</h4>
                </div>
                <div class="panel-body">
                    <p class="text-warning"><i>Update Company</i><p>
                    <form action="updatecomp.php" method="POST">
                        <?php
                        if($error_msg != '') {
                            echo "<div class=\"alert alert-danger\" role=\"alert\">$error_msg</div><br>";
                        }
                        ?>
                        <div class="form-group">
                            <select name="origcomp" class="form-control name"><option></option></select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  placeholder="Name" name="name" >
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description" placeholder="Description" ></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  placeholder="Website" name="website">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="address" placeholder="Address"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control"  placeholder="Number" name="number">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control"  placeholder="Email" name="email">
                        </div>
                        <div class="form-group"> <select class="form-control simple-select" name="location">
                                <option></option>
                                <?php
                                $json = json_decode(file_get_contents('../assets/json_data/locations.json'), true);
                                //          print_r($json);
                                foreach ($json as $item) {
                                    $id = $item['id'];
                                    $text = $item['text'];
                                    if (!empty($_POST['location']) && $_POST['location'] == $id)
                                        echo "<option selected value='$id'>$text</option>";
                                    else
                                        echo "<option value='$id'>$text</option>";
                                }
                                //          ?>
                            </select></div>
                        <button type="submit" name="submit" class="btn btn-primary">Add</button><br><br>
                    </form><br/>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.simple-select').select2({placeholder: 'Location'})
    $('.name').select2({placeholder: 'Company'})
</script>

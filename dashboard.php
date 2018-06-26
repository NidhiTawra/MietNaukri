<?php
/**
 * Created by PhpStorm.
 * User: groot
 * Date: 6/20/18
 * Time: 4:04 PM
 */

session_start();

if(!empty($_SESSION['id'])) echo "Successfully Logged in";
else header("Location: login.php");
<?php
/**
 * Created by PhpStorm.
 * User: groot
 * Date: 6/20/18
 * Time: 4:04 PM
 */
include_once 'header.php';
session_start();
//echo "Successfully Logged in";
if(empty($_SESSION['id'])) header("Location: login.php");

?>

<table id="status-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" width="93%" style="background-color: #9b0a18">
    <thead>
    <tr>
        <th class="mdl-data-table__cell--non-numeric">Company Name</th>
        <th class="mdl-data-table__cell--non-numeric">Type</th>
        <th class="mdl-data-table__cell--non-numeric">Date</th>
        <th class="mdl-data-table__cell--non-numeric">Status</th>
    </tr>
    </thead>
    <tbody>
        <td class="mdl-data-table__cell--non-numeric">Some Company Name</td>
        <td class="mdl-data-table__cell--non-numeric">Some Skills or Position</td>
        <td class="mdl-data-table__cell--non-numeric">14 July 2018</td>
        <td class="mdl-data-table__cell--non-numeric">Applied</td>
    </tbody>
</table>

</body>
</html>

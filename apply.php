<?php
/**
 * Created by PhpStorm.
 * User: groot
 * Date: 7/15/18
 * Time: 2:49 PM
 */

include_once 'header.php';
include_once 'includes/login_database.php';

$result = $conn->query("select jobs.*,specialization.name from jobs,specialization where jobs.branch=34 and specialization.id=jobs.branch");

?>

<table id="status-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" width="93%" style="background-color: #9b0a18">
    <thead>
    <tr>
        <th class="mdl-data-table__cell--non-numeric">Company Name</th>
        <th class="mdl-data-table__cell--non-numeric">Title</th>
        <th class="mdl-data-table__cell--non-numeric">Branch</th>
        <th class="mdl-data-table__cell--non-numeric">Last Date</th>
    </tr>
    </thead>
    <tbody>

    <?php
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo "<td class=\"mdl-data-table__cell--non-numeric\">{$row['company_name']}</td>";
        echo "<td class=\"mdl-data-table__cell--non-numeric\">{$row['job_title']}</td>";
        echo "<td class=\"mdl-data-table__cell--non-numeric\">{$row['name']}</td>";
        echo "<td class=\"mdl-data-table__cell--non-numeric\">{$row['last_date_for_apply']}</td>";
        echo "<td class=\"mdl-data-table__cell--non-numeric\" style='color: #000;'><button>Apply</button></td>";
    }
    ?>

    </tbody>
</table>


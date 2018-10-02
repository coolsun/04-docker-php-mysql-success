<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$pressure_date = isset($_POST['newPressureDate']) ? $_POST['newPressureDate'] : false;
$pressure_value = isset($_POST['newPressureValue']) ? $_POST['newPressureValue'] : false;
$pressure_reason_ids = isset($_POST['newReasonIds']) ? $_POST['newReasonIds'] : false;
$uid = $_SESSION['userid'];

function record_replace($dbh, $user_id, $pressure_date, $pressure_value, $pressure_reason_ids)
{
    $delete_query_string = 'DELETE FROM `pressures` WHERE `user_id` = ? AND `date` = ?';
    $delete_query = $dbh->prepare($delete_query_string);
    $delete_query->execute(array(
        $user_id,
        $pressure_date
    ));

    $insert_query_string = "INSERT INTO `pressures`(`user_id`, `date`, `pressure_value`, `pressure_reasons`, `created_at`) (select ?, ?, ?, group_concat(`reason` separator ', '), ? FROM pressure_reasons WHERE `user_id` = ? AND id in ($pressure_reason_ids) group by `user_id`)";
    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array(
        $user_id,
        $pressure_date,
        $pressure_value,
        date("Y-m-d H:i:s"),
        $user_id
    ));

    return ($insert_query->rowCount() == 1);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($pressure_date && $pressure_value && $pressure_reason_ids)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_replace($dbh, $uid, $pressure_date, $pressure_value, $pressure_reason_ids))
            {
                $b_success = true;
            }
            else
            {
                $s_err_message = "Error: Can't insert data to database.";
            }
        }
        else
        {
            $s_err_message = "Error: Can't connect the database.";
        }
    }
    else
    {
        $s_err_message = "Error: Can't find the user.";
    }
}
else
{
    $s_err_message = "Error: Loss some params.";
}

$data = array('success' => $b_success, 'msg' => $s_err_message);
echo json_encode($data);

?>
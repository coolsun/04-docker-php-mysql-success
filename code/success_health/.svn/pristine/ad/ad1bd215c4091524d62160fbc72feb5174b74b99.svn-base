<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$sleep_date = isset($_POST['newSleepDate']) ? $_POST['newSleepDate'] : false;
$sleep_hours = isset($_POST['newSleepHours']) ? $_POST['newSleepHours'] : false;
$sleep_quality = isset($_POST['newSleepQuality']) ? $_POST['newSleepQuality'] : false;
$uid = $_SESSION['userid'];

function record_replace($dbh, $user_id, $sleep_date, $sleep_hours, $sleep_quality)
{
    $delete_query_string = 'DELETE FROM `sleepings` WHERE `user_id` = ? AND `date` = ?';
    $delete_query = $dbh->prepare($delete_query_string);
    $delete_query->execute(array(
        $user_id,
        $sleep_date
    ));

    $insert_query_string = "INSERT INTO `sleepings`(`user_id`, `date`, `sleep_hours`, `sleep_quality`, `created_at`) VALUES (?,?,?,?,?)";
    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array(
        $user_id,
        $sleep_date,
        $sleep_hours,
        $sleep_quality,
        date("Y-m-d H:i:s")
    ));

    return ($insert_query->rowCount() == 1);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($sleep_date && $sleep_hours && $sleep_quality)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_replace($dbh, $uid, $sleep_date, $sleep_hours, $sleep_quality))
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
<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$mood_date = isset($_POST['newMoodDate']) ? $_POST['newMoodDate'] : false;
$mood_value = isset($_POST['newMoodValue']) ? $_POST['newMoodValue'] : false;
$mood_performance = isset($_POST['newPerformance']) ? $_POST['newPerformance'] : false;
$uid = $_SESSION['userid'];

function record_replace($dbh, $user_id, $mood_date, $mood_value, $mood_performance)
{
    $delete_query_string = 'DELETE FROM `moods` WHERE `user_id` = ? AND `date` = ?';
    $delete_query = $dbh->prepare($delete_query_string);
    $delete_query->execute(array(
        $user_id,
        $mood_date
    ));

    $insert_query_string = "INSERT INTO `moods`(`user_id`, `date`, `mood_value`, `performance`, `created_at`) VALUES (?,?,?,?,?)";
    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array(
        $user_id,
        $mood_date,
        $mood_value,
        $mood_performance,
        date("Y-m-d H:i:s")
    ));

    return ($insert_query->rowCount() == 1);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($mood_date && $mood_value && $mood_performance)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_replace($dbh, $uid, $mood_date, $mood_value, $mood_performance))
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
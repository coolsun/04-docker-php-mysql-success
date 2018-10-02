<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$mood_id = isset($_POST['id']) ? $_POST['id'] : false;
$mood_value = isset($_POST['mood_value']) ? $_POST['mood_value'] : false;
$mood_performance = isset($_POST['performance']) ? $_POST['performance'] : false;
$uid = $_SESSION['userid'];

function record_update($dbh, $id, $user_id, $mood_value, $mood_performance)
{
    $update_query_string = "UPDATE `moods` SET `mood_value`=?, `performance`=? WHERE `id`=? AND `user_id`=?";
    $update_query = $dbh->prepare($update_query_string);
    $b_success = $update_query->execute(array(
        $mood_value,
        $mood_performance,
        $id,
        $user_id,
    ));

    return ($b_success);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($mood_id && $mood_value && $mood_performance)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_update($dbh, $mood_id, $uid, $mood_value, $mood_performance))
            {
                $b_success = true;
            }
            else
            {
                $s_err_message = "Error: Can't update data to database.";
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

if ($s_err_message)
{
  error_log($s_err_message);
}

$data = array('success' => $b_success, 'msg' => $s_err_message);
echo json_encode($data);

?>
<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$sleep_id = isset($_POST['id']) ? $_POST['id'] : false;
$sleep_hours = isset($_POST['hours']) ? $_POST['hours'] : false;
$sleep_quality = isset($_POST['quality']) ? $_POST['quality'] : false;
$uid = $_SESSION['userid'];

function record_update($dbh, $id, $user_id, $sleep_hours, $sleep_quality)
{
    $update_query_string = "UPDATE `sleepings` SET `sleep_hours`=?, `sleep_quality`=? WHERE `id`=? AND `user_id`=?";
    $update_query = $dbh->prepare($update_query_string);
    $b_success = $update_query->execute(array(
        $sleep_hours,
        $sleep_quality,
        $id,
        $user_id,
    ));

    return ($b_success);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($sleep_id && $sleep_hours && $sleep_quality)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_update($dbh, $sleep_id, $uid, $sleep_hours, $sleep_quality))
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

$data = array('success' => $b_success, 'msg' => $s_err_message);
echo json_encode($data);

?>
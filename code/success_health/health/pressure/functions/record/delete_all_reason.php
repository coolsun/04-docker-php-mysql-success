<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];

function record_delete($dbh, $user_id)
{
    $delete_query_string = 'DELETE FROM `pressure_reasons` WHERE `user_id` = ?';
    $delete_query = $dbh->prepare($delete_query_string);
    $b_success = $delete_query->execute(array(
        $user_id
    ));

    return ($b_success);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if (true)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_delete($dbh, $uid))
            {
                $b_success = true;
            }
            else
            {
                $s_err_message = "Error: Can't delete data.";
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
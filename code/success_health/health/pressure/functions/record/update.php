<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$pressure_id = isset($_POST['id']) ? $_POST['id'] : false;
$pressure_value = isset($_POST['pressure_value']) ? $_POST['pressure_value'] : false;
$uid = $_SESSION['userid'];

function record_update($dbh, $id, $user_id, $pressure_value)
{
    $update_query_string = "UPDATE `pressures` SET `pressure_value`=? WHERE `id`=? AND `user_id`=?";
    $update_query = $dbh->prepare($update_query_string);
    $b_success = $update_query->execute(array(
        $pressure_value,
        $id,
        $user_id,
    ));

    return ($b_success);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($pressure_id && $pressure_value)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_update($dbh, $pressure_id, $uid, $pressure_value))
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
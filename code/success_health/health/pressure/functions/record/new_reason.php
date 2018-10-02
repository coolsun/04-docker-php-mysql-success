<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$data = json_decode( $_POST['data'], true );
$s_reason = isset($data['reason']) ? $data['reason'] : false;
$uid = $_SESSION['userid'];

function new_reason($dbh, $user_id, $s_reason)
{
    $insert_query_string = "INSERT INTO `pressure_reasons`(`user_id`, `reason`, `sequence`, `created_at`) (SELECT ?,?, MAX(`sequence`) + 1, ? FROM `pressure_reasons` WHERE `user_id` = ?)";
    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array(
        $user_id,
        $s_reason,
        date("Y-m-d H:i:s"),
        $user_id
    ));

    return ($insert_query->rowCount() == 1);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($s_reason)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (new_reason($dbh, $uid, $s_reason))
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

$data = array('success' => $b_success, 'msg' => $s_err_message, 'id' =>  $dbh->lastInsertId());
echo json_encode($data);

?>
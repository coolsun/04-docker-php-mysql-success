<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$reason_ids = isset($_POST['ids']) ? $_POST['ids'] : false;
$uid = $_SESSION['userid'];

function record_update($dbh, $reason_ids, $user_id)
{
    foreach ($reason_ids as $index => $reason_id) {
      $update_query_string = "UPDATE `pressure_reasons` SET `sequence`=? WHERE `id`=? AND `user_id`=?";
      $update_query = $dbh->prepare($update_query_string);
      $b_success = $update_query->execute(array(
          $index + 1,
          $reason_id,
          $user_id
      ));
    }

    return ($b_success);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($reason_ids)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_update($dbh, $reason_ids, $uid))
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
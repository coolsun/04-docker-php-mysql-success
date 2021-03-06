<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];

$weight = $_POST['weight'];
$height = $_POST['height'];
$bmi = $_POST['bmi'];


function record_update($dbh, $uid, $weight, $height, $bmi)
{
  $b_success = false;
  $query_string = 'SELECT `id` FROM `bmis` WHERE `user_id`=?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  if (1 == count($records))
  {
    $update_query_string = "UPDATE `bmis` SET `weight`=?, `height`=?, `bmi`=? WHERE `user_id`=?";
    $update_query = $dbh->prepare($update_query_string);
    $update_query->execute(array(
      $weight, $height, $bmi, $uid
    ));
    $b_success = $update_query->errorCode() == '00000';
  }
  else
  {
    $delete_query_string = 'DELETE FROM `bmis` WHERE `user_id` = ?';
    $delete_query = $dbh->prepare($delete_query_string);
    $delete_query->execute(array(
      $uid
    ));

    $insert_query_string = 'INSERT INTO `bmis`(`user_id`, `weight`, `height`, `bmi`) VALUES (?, ?, ?, ?)';
    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array(
      $uid, $weight, $height, $bmi
    ));
    $b_success = $insert_query->errorCode() == '00000';
  }

  return ($b_success);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($weight && $height && $bmi)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_update($dbh, $uid, $weight, $height, $bmi))
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
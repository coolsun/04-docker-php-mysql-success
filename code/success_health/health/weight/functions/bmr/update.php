<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];

$sex = $_POST['sex'];
$year = $_POST['year'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$bmr = $_POST['bmr'];


function record_update($dbh, $uid, $sex, $year, $weight, $height, $bmr)
{
  $b_success = false;
  $query_string = 'SELECT `id` FROM `bmrs` WHERE `user_id`=?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  if (1 == count($records))
  {
    $update_query_string = "UPDATE `bmrs` SET `sex`=?, `year`=?, `weight`=?, `height`=?, `bmr`=? WHERE `user_id`=?";
    $update_query = $dbh->prepare($update_query_string);
    $update_query->execute(array(
      $sex, $year, $weight, $height, $bmr, $uid
    ));
    $b_success = $update_query->errorCode() == '00000';
  }
  else
  {
    $delete_query_string = 'DELETE FROM `bmrs` WHERE `user_id` = ?';
    $delete_query = $dbh->prepare($delete_query_string);
    $delete_query->execute(array(
      $uid
    ));

    $insert_query_string = 'INSERT INTO `bmrs`(`user_id`, `sex`, `year`, `weight`, `height`, `bmr`) VALUES (?, ?, ?, ?, ?, ?)';
    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array(
      $uid, $sex, $year, $weight, $height, $bmr
    ));
    $b_success = $insert_query->errorCode() == '00000';
  }

  return ($b_success);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($sex && $year && $weight && $height && $bmr)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_update($dbh, $uid, $sex, $year, $weight, $height, $bmr))
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
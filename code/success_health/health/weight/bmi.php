<?php
$uid = $_SESSION['userid'];
$dbh = connect_success_db('health');

$user_bmi_weight = '';
$user_bmi_height = '';
$user_bmi_value = '';

if ($dbh)
{
  $query_string = 'SELECT `weight`, `height`, `bmi` FROM `bmis` WHERE `user_id`=?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  if (1 == count($records))
  {
    $user_bmi = $records[0];

    $user_bmi_weight = $user_bmi['weight'];
    $user_bmi_height = $user_bmi['height'];
    $user_bmi_value = $user_bmi['bmi'];
  }
}

include('bmi_view.php');

?>
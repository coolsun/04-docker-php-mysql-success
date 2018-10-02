<?php
$uid = $_SESSION['userid'];
$dbh = connect_success_db('health');

$user_bmr_sex = 'm';
$user_bmr_year = 1975;
$user_bmr_weight = '';
$user_bmr_height = '';
$user_bmr_value = '';

if ($dbh)
{
  $query_string = 'SELECT `sex`, `year`, `weight`, `height`, `bmr` FROM `bmrs` WHERE `user_id`=?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  if (1 == count($records))
  {
    $user_bmr = $records[0];

    $user_bmr_sex = $user_bmr['sex'];
    $user_bmr_year = $user_bmr['year'];
    $user_bmr_weight = $user_bmr['weight'];
    $user_bmr_height = $user_bmr['height'];
    $user_bmr_value = $user_bmr['bmr'];
  }
}

include('bmr_view.php');

?>
<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];
$date = $_GET['date'];

$dbh = connect_success_db('health');
$records = Array();
if ($dbh)
{
  $query_string = 'SELECT `weight` FROM `user_weights` WHERE `user_id` = ? AND `date` <= ? ORDER BY `date` desc limit 1';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, $date ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );
}

echo json_encode($records);

?>




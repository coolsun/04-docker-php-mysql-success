<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];


$dbh = connect_success_db('health');
$records = Array();
if ($dbh)
{
  $query_string = 'SELECT * FROM `user_weight_plans` WHERE `user_id` = ?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );
}

echo json_encode($records);

?>




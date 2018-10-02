<?php

session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];


$dbh = connect_success_db('health');
$records = Array();
if ($dbh)
{
  $query_string = 'SELECT `id`, `reason`, `sequence` FROM `pressure_reasons` WHERE `user_id` = ? ORDER BY `sequence`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );
}

echo json_encode($records);

?>
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

//$ul_html = '';

//foreach ($records as $key => $value) {
  //$ul_html .= '<li><input type="checkbox" name="arr_pressure_edit[]" value="' . $value['id'] . '"><span>' . $value['reason'] . '</span></li>';
//}

//echo $ul_html;


echo json_encode($records);

?>
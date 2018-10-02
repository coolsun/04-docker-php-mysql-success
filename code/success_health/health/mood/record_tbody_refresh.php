<?php
session_start();
require "../config_health_conn.php";

$uid = $_SESSION['userid'];

$during_days = $_GET['range'];
$start_date = $_GET['recordStartDate'];

$_SESSION['moodSelect'] = isset($_GET['recordSelect']) ? $_GET['recordSelect'] : 7;
$record_select = $_GET['recordSelect'];

if (empty($start_date) || 'now' == $start_date)
{
  $start_date = date('Y/m/d');
}

if (!is_numeric($during_days))
{
  $during_days = 7;
}

$start_date = str_replace('/' , '-', $start_date);
$_SESSION['moodStartDate'] = $start_date;
$_SESSION['moodDuringDays'] = $during_days;
$_SESSION['moodSelect'] = $record_select;

$target_date = date('Y-m-d', strtotime( $start_date . " -$during_days day"));

$dbh = connect_success_db('health');
$records = Array();
if ($dbh)
{
  $query_string = 'SELECT  `id`, `user_id`, `date`, `mood_value`, `performance` FROM `moods` WHERE `user_id`=? AND `date` BETWEEN ? and ? ORDER BY `date` desc';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );
}

include('_partial_record_tbody.php');

?>
<?php

session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];

$during_days = $_GET['range'];
$start_date = $_GET['recordStartDate'];

$_SESSION['sleepSelect'] = isset($_GET['recordSelect']) ? $_GET['recordSelect'] : 7;
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
$_SESSION['sleepStartDate'] = $start_date;
$_SESSION['sleepDuringDays'] = $during_days;
$_SESSION['sleepSelect'] = $record_select;

$target_date = date('Y-m-d', strtotime( $start_date . " -$during_days day"));

$dbh = connect_success_db('health');
$chart_hours = Array();
$chart_quality = Array();
$chart_dates = Array();

if ($dbh)
{
  $query_string = 'SELECT  `id`, `user_id`, `date`, `sleep_hours`, `sleep_quality` FROM `sleepings` WHERE `user_id`=? AND `date` BETWEEN ? and ? ORDER BY `date`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  foreach ($records as $key => $value) {
    $chart_hours[] = $value['sleep_hours'];
    $chart_quality[] = $value['sleep_quality'];
    $chart_date_m_d = date('m/d',strtotime($value['date']));
    $chart_dates[] = "'$chart_date_m_d'";
  }
}

$data = array(
  'chart_hours' => join(', ', $chart_hours),
  'chart_quality' => join(', ', $chart_quality),
  'chart_dates' => join(', ', $chart_dates)

);

echo json_encode($data);

?>
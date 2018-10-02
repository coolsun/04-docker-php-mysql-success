<?php

session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];

$during_days = $_GET['range'];
$start_date = $_GET['pressureStartDate'];

$_SESSION['pressureSelect'] = isset($_GET['recordSelect']) ? $_GET['recordSelect'] : 7;
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
$_SESSION['pressureStartDate'] = $start_date;
$_SESSION['pressureDuringDays'] = $during_days;
$_SESSION['pressureSelect'] = $record_select;

$target_date = date('Y-m-d', strtotime( $start_date . " -$during_days day"));

$dbh = connect_success_db('health');
$chart_value = Array();
$chart_dates = Array();

if ($dbh)
{
  $query_string = 'SELECT `id`, `user_id`, `date`, `pressure_value` FROM `pressures` WHERE `user_id`=? AND `date` BETWEEN ? and ? ORDER BY `date`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  foreach ($records as $key => $value) {
    $chart_values[] = $value['pressure_value'];
    $chart_date_m_d = date('m/d',strtotime($value['date']));
    $chart_dates[] = "'$chart_date_m_d'";
  }
}

$data = array(
  'chart_values' => join(', ', $chart_values),
  'chart_dates' => join(', ', $chart_dates)

);

echo json_encode($data);

?>
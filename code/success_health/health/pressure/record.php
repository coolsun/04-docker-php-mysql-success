<?php
$record_select_options = array(
  array('value' => 7, 'name' => '前 7 天'),
  array('value' => 14, 'name' => '前 14 天'),
  array('value' => 30, 'name' => '前 30 天'),
  array('value' => 60, 'name' => '前 60 天')
);

$start_date = isset($_SESSION['pressureStartDate']) ? $_SESSION['pressureStartDate'] : '';
$during_days = isset($_SESSION['pressureDuringDays']) ? $_SESSION['pressureDuringDays'] : 7;
$record_select = isset($_SESSION['pressureSelect']) ? $_SESSION['pressureSelect'] : 7;

if (empty($start_date))
{
  $start_date = date('Y/m/d');
}

$start_date = str_replace('/' , '-', $start_date);
$_SESSION['pressureStartDate'] = $start_date;
$_SESSION['pressureDuringDays'] = $during_days;
$_SESSION['pressureSelect'] = $record_select;

$target_date = date('Y-m-d', strtotime( $start_date . " -$during_days day"));

$dbh = connect_success_db('health');
$records = Array();
if ($dbh)
{
  $query_string = 'SELECT `id`, `user_id`, `date`, `pressure_value`, `pressure_reasons` FROM `pressures` WHERE `user_id`=? AND `date` BETWEEN ? and ? ORDER BY `date` desc';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );
}

include('record_view.php');


?>
<?php
$record_select_options = array(
  array('value' => 7, 'name' => '前 7 天'),
  array('value' => 14, 'name' => '前 14 天'),
  array('value' => 30, 'name' => '前 30 天'),
  array('value' => 60, 'name' => '前 60 天')
);

$start_date = isset($_SESSION['exerciseStartDate']) ? $_SESSION['exerciseStartDate'] : '';
$during_days = isset($_SESSION['exerciseDuringDays']) ? $_SESSION['exerciseDuringDays'] : 7;
$record_select = isset($_SESSION['exerciseSelect']) ? $_SESSION['exerciseSelect'] : 7;

if (empty($start_date))
{
  $start_date = date('Y/m/d');
}

$start_date = str_replace('/' , '-', $start_date);
$_SESSION['exerciseStartDate'] = $start_date;
$_SESSION['exerciseDuringDays'] = $during_days;
$_SESSION['exerciseSelect'] = $record_select;

$target_date = date('Y-m-d', strtotime( $start_date . " -$during_days day"));

$dbh = connect_success_db('health');
$records = Array();

$chart_mins = Array();
$chart_kcal = Array();
$chart_dates = Array();

if ($dbh)
{
  $query_string = 'SELECT `id`, `user_id`, `date`, sum(`mins`) as sum_mins, sum(`kcal`) as sum_kcal FROM `exercises` WHERE `user_id`=? AND `date` BETWEEN ? and ? GROUP BY `date` ORDER BY `date`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  foreach ($records as $key => $value) {
    $chart_mins[] = $value['sum_mins'];
    $chart_kcal[] = $value['sum_kcal'];
    $chart_date_m_d = date('m/d',strtotime($value['date']));
    $chart_dates[] = "'$chart_date_m_d'";
  }

}


include('analytic_view.php');


?>
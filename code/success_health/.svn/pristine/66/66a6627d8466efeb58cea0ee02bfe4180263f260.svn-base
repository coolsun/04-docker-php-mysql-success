<?php
$record_select_options = array(
  array('value' => 7, 'name' => '前 7 天'),
  array('value' => 14, 'name' => '前 14 天'),
  array('value' => 30, 'name' => '前 30 天'),
  array('value' => 60, 'name' => '前 60 天')
);

$start_date = isset($_SESSION['moodStartDate']) ? $_SESSION['moodStartDate'] : '';
$during_days = isset($_SESSION['moodDuringDays']) ? $_SESSION['moodDuringDays'] : 7;
$record_select = isset($_SESSION['moodSelect']) ? $_SESSION['moodSelect'] : 7;

if (empty($start_date))
{
  $start_date = date('Y/m/d');
}

$start_date = str_replace('/' , '-', $start_date);
$_SESSION['moodStartDate'] = $start_date;
$_SESSION['moodDuringDays'] = $during_days;
$_SESSION['moodSelect'] = $record_select;

$target_date = date('Y-m-d', strtotime( $start_date . " -$during_days day"));

$dbh = connect_success_db('health');
$all_chart_data = Array('diet' => Array(), 'exercises' => Array(), 'sleepings' => Array(), 'moods' => Array());
if ($dbh)
{
  $query_string = 'SELECT `protein`, `lipid_tot`, `carbohydrt` FROM `meals` WHERE `user_id`=? AND `date` BETWEEN ? and ?';

  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  $pie_carbohydrt = 0;
  $pie_lipid_tot = 0;
  $pie_protein = 0;
  foreach ($records as $key => $value) {
    $pie_carbohydrt += $value['carbohydrt'];
    $pie_lipid_tot += $value['lipid_tot'];
    $pie_protein += $value['protein'];
  }

  $all_chart_data['diet'] = array(
    'carbohydrt' => $pie_carbohydrt,
    'lipid_tot' => $pie_lipid_tot,
    'protein' => $pie_protein
  );


  $chart_mins = Array();
  $chart_kcal = Array();
  $chart_dates = Array();

  $query_string = 'SELECT `date`, sum(`mins`) as sum_mins, sum(`kcal`) as sum_kcal FROM `exercises` WHERE `user_id`=? AND `date` BETWEEN ? and ? GROUP BY `date` ORDER BY `date`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  foreach ($records as $key => $value) {
    $chart_mins[] = $value['sum_mins'];
    $chart_kcal[] = $value['sum_kcal'];
    $chart_date_m_d = date('m/d',strtotime($value['date']));
    $chart_dates[] = "'$chart_date_m_d'";
  }

  $all_chart_data['exercises'] = array(
    'chart_mins' => join(', ', $chart_mins),
    'chart_kcal' => join(', ', $chart_kcal),
    'chart_dates' => join(', ', $chart_dates)
  );

  $chart_hours = Array();
  $chart_quality = Array();
  $chart_dates = Array();

  $query_string = 'SELECT `date`, `sleep_hours`, `sleep_quality` FROM `sleepings` WHERE `user_id`=? AND `date` BETWEEN ? and ? ORDER BY `date`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  foreach ($records as $key => $value) {
    $chart_hours[] = $value['sleep_hours'];
    $chart_quality[] = $value['sleep_quality'];
    $chart_date_m_d = date('m/d',strtotime($value['date']));
    $chart_dates[] = "'$chart_date_m_d'";
  }

  $all_chart_data['sleepings'] = array(
    'chart_hours' => join(', ', $chart_hours),
    'chart_quality' => join(', ', $chart_quality),
    'chart_dates' => join(', ', $chart_dates)
  );

  $chart_values = Array();
  $chart_performance = Array();
  $chart_dates = Array();

  $query_string = 'SELECT `date`, `mood_value`, `performance` FROM `moods` WHERE `user_id`=? AND `date` BETWEEN ? and ? ORDER BY `date`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  foreach ($records as $key => $value) {
    $chart_values[] = $value['mood_value'];
    $chart_performance[] = $value['performance'];
    $chart_date_m_d = date('m/d',strtotime($value['date']));
    $chart_dates[] = "'$chart_date_m_d'";
  }

  $all_chart_data['moods'] = array(
    'chart_values' => join(', ', $chart_values),
    'chart_performance' => join(', ', $chart_performance),
    'chart_dates' => join(', ', $chart_dates)
  );
}

include('complex_view.php');

?>


















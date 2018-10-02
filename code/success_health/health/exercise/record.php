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
$sports = Array();
$last_weight = '';
if ($dbh)
{
  $query_string = 'SELECT `exercises`.`id`, `exercises`.`user_id`, `exercises`.`date`, `exercises`.`sport_id`, `exercises`.`mins`, `exercises`.`kcal`, `sports`.`cht_descriptions` as `cht_descriptions` FROM `exercises` LEFT JOIN `sports` ON `exercises`.`sport_id` = `sports`.`id` WHERE `user_id`=? AND `date` BETWEEN ? and ? ORDER BY `exercises`.`date` desc, `exercises`.`sport_id`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, "$target_date", "$start_date" ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  $query_string = 'SELECT  `id`, `category`, `cht_descriptions` FROM `sports` order by `category`, `id`';
  $query = $dbh->prepare( $query_string );
  $query->execute();
  $sports = $query->fetchAll( PDO::FETCH_ASSOC );

  $sport_categories = array('室內', '居家', '戶外', '慢跑', '球類', '一般', '園藝', '維修', '農牧', '水上');

  $query_string = 'SELECT `weight` FROM `user_weights` WHERE `user_id` = ? ORDER BY `date` desc limit 1';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $weights = $query->fetchAll( PDO::FETCH_ASSOC );
  if (1 == count($weights))
  {
    $last_weight = $weights[0]['weight'];
  }
}

include('record_view.php');


?>
<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

function calculate_today_calory_diet($dbh, $uid, $today)
{
  $calory = 0;

  $query_string = 'SELECT SUM(`meals`.`energ_kcal`) AS `total_kcal` FROM `meals` WHERE `user_id`=? AND `date` = ?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, $today ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  $calory = $records[0]['total_kcal'] ? $records[0]['total_kcal'] : 0;

  return $calory;
};

function calculate_today_calory_exercise($dbh, $uid, $today)
{
  $query_string = 'SELECT SUM(`exercises`.`kcal`) AS `total_kcal` FROM `exercises` WHERE `user_id`=? AND `date` = ?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, $today ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  $calory = $records[0]['total_kcal'] ? $records[0]['total_kcal'] : 0;

  return $calory;
};

$uid = $_SESSION['userid'];
$dbh = connect_success_db('health');

$today_plan = Array(
  'bExist' => false,
  'weight' => 0,
  'today_weight' => 0,
  'would_weight' => 0,
  'today_calory' => 0,
  'today_calory_diet' => 0,
  'today_calory_exercise' => 0,
  'today_calory_left' => 0,
  'today_bmr' => 0
);

$weight_date_arr = Array();
$weight_value_arr = Array();

if ($dbh)
{
  $query_string = 'SELECT * FROM `user_weight_plans` WHERE `user_id` = ?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );
  $weight_plan = $records[0];

  if (!empty($weight_plan))
  {
    $today_plan['bExist'] = true;
    $sex = $weight_plan['sex'];
    $work_type = $weight_plan['work_type'];
    $birthdate = $weight_plan['birthdate'];
    $height = $weight_plan['height'];
    $weight = $weight_plan['weight'];
    $sex = $weight_plan['sex'];
    $work_type = $weight_plan['work_type'];
    $would_weight = $weight_plan['would_weight'];
    $would_date = $weight_plan['would_date'];
    $created_date = $weight_plan['created_date'];
    //$bmr = $weight_plan['bmr'];
    $updated_at = $weight_plan['updated_at'];


    $today_plan['weight'] = round($weight_plan['weight'], 1);
    $today_plan['would_weight'] = round($weight_plan['would_weight'], 1);

    $dt_today = new DateTime(date("Y-m-d 00:00:00"));
    $dt_birthdate = new DateTime($birthdate . " 00:00:00");
    $birthdate_year = $dt_birthdate->format('Y');
    $age = $dt_today->format('Y') - $birthdate_year;

    $query_string = 'SELECT `weight` FROM `user_weights` WHERE `user_id` = ? ORDER BY `date` desc limit 1';
    $query = $dbh->prepare( $query_string );
    $query->execute( array( $uid ) );
    $records = $query->fetchAll( PDO::FETCH_ASSOC );

    $last_weight = $records[0];
    if (!empty($last_weight))
    {
      $today_plan['today_weight'] = round($last_weight['weight'], 1);
    }

    $bmr = 0;

    if ('M' == $sex)
    {
        $bmr = round(13.7 * $today_plan['today_weight'] + 5.0 * $height - 6.8 * $age + 66);
    }
    else
    {
        $bmr = round(9.6 * $today_plan['today_weight'] + 1.0 * $height - 4.7 * $age + 655);
    }

    $today_plan['today_bmr'] = $bmr;

    $coefficient = 0;

    switch($work_type)
    {
      case "1":
        $coefficient = 1;
        break;
      case "2":
        $coefficient = 1.2;
        break;
      case "3":
        $coefficient = 1.375;
        break;
      case "4":
        $coefficient = 1.55;
        break;
      case "5":
        $coefficient = 1.725;
        break;
      case "6":
        $coefficient = 1.9;
        break;
    }

    $dt_created_date = new DateTime($created_date . " 00:00:00");
    $dt_would_date = new DateTime($would_date . " 00:00:00");

    $diff_days = date_diff($dt_would_date, $dt_today)->days;

    $daily_cal_cost = $today_plan['today_bmr'] * $coefficient;
    $daily_cal_budget = $daily_cal_cost - ((($today_plan['today_weight'] - $today_plan['would_weight']) / $diff_days) * 7700);
    $today_plan['today_calory'] = round($daily_cal_budget);


    $today_plan['today_calory_diet'] = round(calculate_today_calory_diet($dbh, $uid, $dt_today->format('Y-m-d')));
    $today_plan['today_calory_exercise'] = round(calculate_today_calory_exercise($dbh, $uid, $dt_today->format('Y-m-d')));
    $today_plan['today_calory_left'] = round($today_plan['today_calory'] - $today_plan['today_calory_diet'] + $today_plan['today_calory_exercise']);



    $begin = new DateTime($created_date);
    $end = new DateTime($would_date);
    $end = $end->modify('+1 day');

    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval ,$end);

    foreach($daterange as $date){
      array_push($weight_date_arr, $date);

      if ($date <= $dt_today)
      {
        $query_string = 'SELECT `weight` FROM `user_weights` WHERE `user_id` = ? and `date` <= ? ORDER BY `date` desc limit 1';
        $query = $dbh->prepare( $query_string );
        $query->execute( array( $uid, $date->format('Y-m-d')) );
        $records = $query->fetchAll( PDO::FETCH_ASSOC );

        if (0 == count($records))
        {
          array_push($weight_value_arr, null);
        }
        else
        {
          array_push($weight_value_arr, (double)$records[0]['weight']);
        }

        $records = null;
      }
    }
  }
}

echo json_encode(array(
  'today_plan' => $today_plan,
  'weight_value_arr' => $weight_value_arr,
  'dt_created_date_y' => (int)$dt_created_date->format('Y'),
  'dt_created_date_m' => (int)$dt_created_date->format('m'),
  'dt_created_date_d' => (int)$dt_created_date->format('d'),
  'dt_would_date_y' => (int)$dt_would_date->format('Y'),
  'dt_would_date_m' => (int)$dt_would_date->format('m'),
  'dt_would_date_d' => (int)$dt_would_date->format('d')
));

?>











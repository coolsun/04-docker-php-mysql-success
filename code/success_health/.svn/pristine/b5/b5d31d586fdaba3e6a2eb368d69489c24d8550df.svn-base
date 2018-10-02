<?php

session_start();
require "../config_health_conn.php";

$uid = $_SESSION['userid'];
$start_date = isset($_SESSION['dietStartDate']) ? $_SESSION['dietStartDate'] : '';
$start_date = isset($_GET['selectDate']) ? $_GET['selectDate'] : $start_date;

if (empty($start_date))
{
  $start_date = date('Y/m/d');
}

$start_date = str_replace('/' , '-', $start_date);
$_SESSION['dietStartDate'] = $start_date;

$dbh = connect_success_db('health');
$records = Array();
if ($dbh)
{
  $query_string = 'SELECT `meals`.`id`, `meals`.`user_id`, `meals`.`date`, `meals`.`food_id`, `meals`.`unit`, `meals`.`gram`, `meals`.`energ_kcal`, `meals`.`protein`, `meals`.`lipid_tot`, `meals`.`carbohydrt`, `meals`.`eng`, `foods`.`shrt_desc`, `foods`.`long_desc`, `foods`.`unit_name`, `foods`.`gram_per_unit` as `food_gram_per_unit`, `foods`.`energ_kcal` as `food_energ_kcal`, `foods`.`protein` as `food_protein`, `foods`.`lipid_tot` as `food_lipid_tot`, `foods`.`carbohydrt` as `food_carbohydrt` FROM `meals` LEFT JOIN `foods` ON `meals`.`food_id` = `foods`.`id` WHERE `user_id`=? AND `date` = ?';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, $start_date ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );
}

include('_partial_record_tbody.php');



?>
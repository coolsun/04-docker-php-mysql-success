<?php
/* Get all loan accounts */

session_start();
header( "Content-Type: application/json", true );
require "../../../../config_conn.inc.php";


/* Connect to DB */
$status = false;
$emsg = '';
$result = '';

try
{
    $dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
    error("Can't connect to database. ".$e->getMessage().' (Error 1021)' );
}


try
{
    $str_json_old_repayment_data = $_POST["old_repayment"];
    $str_json_new_repayment_data = $_POST["new_repayment"];
    $transfer_amount = $_POST["transfer_amount"];
    $reduce_budget = $_POST["reduce_budget"];

    $uid = $_SESSION['userid'];
    $datetime = date('Y-m-d H:i:s');

    $insert_query_string = 'INSERT INTO `repayment_plans` (`user_id`, `old_repayment_data`, `new_repayment_data`, `transfer_amount`, `reduce_budget`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $params = array( $uid, $str_json_old_repayment_data, $str_json_new_repayment_data, abs(floatval($transfer_amount)), floatval($reduce_budget), $datetime, $datetime );
    $insert_query = $dbh->prepare( $insert_query_string );
    $insert_query->execute( $params );
    $repayment_id = $dbh->lastInsertId();

    if ($repayment_id)
    {
        $result = '計畫儲存成功';
        $status = true;
    }
    else
    {
        $emsg = '計畫儲存失敗';
        $result = '計畫儲存失敗';
    }
}
catch (PDOException $e)
{
  echo $e->getMessage();
  exit();
}

$result = array('status' => $status, 'result' => $result, 'emsg' => $emsg);
echo json_encode ($result);

?>





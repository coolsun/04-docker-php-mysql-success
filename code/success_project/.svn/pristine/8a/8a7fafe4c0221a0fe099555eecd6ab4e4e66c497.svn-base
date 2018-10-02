<?php
/* Get all loan accounts */

session_start();
header( "Content-Type: application/json", true );
require "../../../../config_conn.inc.php";

/* Connect to DB */
$status = false;
$emsg = '';
$avbl_balances = array();

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
    $uid = $_SESSION['userid'];
    /* Get loan accounts data of the user */
    $query_string = 'SELECT  `account_id` as `aid`, `account_type` as `atype`,`account_name` as `aname`, `account_balance` as `balance` FROM `accounts` WHERE `user_id`=? AND (`account_type`=0 OR `account_type`=2) ORDER BY  `created`';
    $query = $dbh->prepare( $query_string );
    $query->execute( array( $uid ) );
    $avbl_balances = $query->fetchAll( PDO::FETCH_ASSOC );

    if ($avbl_balances)
    {
        $status = true;
    }


}
catch (PDOException $e)
{
  echo $e->getMessage();
  exit();
}

$result = array('status' => $status, 'result' => $avbl_balances, 'emsg' => $emsg);
echo json_encode ($result);

?>

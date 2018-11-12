<?php
session_start();
header('Content-Type: application/json');
require "../../../../config_conn.inc.php";

/*
 Connect to DB
*/
try {
  $dbh = new PDO($DB_connection_array['job']['driver_name'].':host='.$DB_connection_array['job']['host'].';dbname='.$DB_connection_array['job']['db_name'], $DB_connection_array['job']['user_name'], $DB_connection_array['job']['password']);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
  //$res = array('status' => 'Error.engine_restart.1');
  header("Location: " . '?dept=job&ma=engine');
  exit();
}

$delete_engine_result = $dbh->prepare('DELETE FROM `engine` WHERE `user_id`=?;'); 
$delete_engine_result->execute( array($_SESSION['userid']) );

ob_end_clean();
header("HTTP/1.1 301 Moved Permanently");
header("Location: ".$_SERVER['HTTP_REFERER']);
?>
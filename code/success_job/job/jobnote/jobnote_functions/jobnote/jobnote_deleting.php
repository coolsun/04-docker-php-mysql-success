<?php
session_start();
header('Content-Type:text/html; charset=utf-8');
require "../../../../config_conn.inc.php";


if( isset($_SERVER['HTTP_AJAX']) && $_SERVER['HTTP_AJAX'] == 'yes' ) {
		if( isset($_GET['jn']) && $_GET['jn'] != '' ) {
			$jobnote_id = trim( $_GET['jn'] );
			/*
			 Connect to DB
			*/
			try {
			  	$dbh = new PDO($DB_connection_array['job']['driver_name'].':host='.$DB_connection_array['job']['host'].';dbname='.$DB_connection_array['job']['db_name'], $DB_connection_array['job']['user_name'], $DB_connection_array['job']['password']);
			  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	$dbh->exec("SET NAMES 'utf8';");

				$delete_jobnote = $dbh->prepare('DELETE FROM `jobnotes` WHERE `jobnote_id`=? and `user_id`=?;'); 
				$delete_jobnote->execute( array( $jobnote_id, $_SESSION['userid'] ) );

				echo "success";
			}
			catch (PDOException $e) {
			  echo "Error.jobnote_deleting";
			  exit();
			}
			
		}
}
?>
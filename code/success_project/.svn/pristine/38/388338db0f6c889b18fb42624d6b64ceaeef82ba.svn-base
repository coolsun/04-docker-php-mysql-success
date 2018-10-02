<?php
$uid = $_SESSION['userid'];

try
{
	/* Get all accounts data of the user */
	$sql = 'SELECT `account_type`, `account_id`, `account_name`, `account_balance`, `year_rate`, `start_date`, `money`, `time_length`, `time_length_unit`, `description` FROM `accounts` WHERE `user_id`=?';
	$query = $dbh->prepare( $sql );
	$query->execute( array( $uid ) );
	$all_accounts = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_ASSOC );
}
catch (PDOException $e) {
	echo $e->getMessage();
	exit();
}
?>

<?php include_once('list_view.php'); ?>

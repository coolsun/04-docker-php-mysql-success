<?php
if ( 0 )
{
	ini_set('display_errors',1);
	error_reporting(E_ALL);
}

$uid = $_SESSION['userid'];


/* Post-Redirect-Session, avoid refresh ask re-post */
if ( isset($_POST) && count($_POST) )
{
	$_SESSION['post'] = $_POST;
	ob_end_clean();
    header("Location: http://" .  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}
else
{
	$_POST = $_SESSION['post'];
	unset($_SESSION['post']);
}

function encode_ch(&$value, $key)
{
	if( is_string($value) )
	{
		$value = urlencode($value);
	}
}

/* For sub page */
$ssas = array(
	'edit'  => '編列',
	'chart' => '圖表'
);
$ssa = 'index';
if ( isset( $_GET['ssa'] ) && in_array( $_GET['ssa'], array('edit', 'chart') ) )
{
	$ssa = $_GET['ssa'];
}


/* Check if user bills class is exist , if not , create it */
try
{
	$query_string = "SELECT `version`, `time_unit`, `class` FROM `bills_class` WHERE `user_id`=? LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$bills_class = $query->fetch( PDO::FETCH_ASSOC );

	if ( !$bills_class )
	{
		//echo "Warnning";
		$bills_class_version = 0;
		$time_unit = 1;
		$default_bills_class_json = file_get_contents('bills_class.json', 1);
		$bills_class = json_decode( $default_bills_class_json, true );
		$insert_query_string = "INSERT INTO `bills_class` (`user_id`, `time_unit`, `class`, `updated`, `created`) VALUES (?, ?, ?, ?, ?) ";
		$insert_query = $dbh->prepare( $insert_query_string );
		$datetime = date('Y-m-d H:i:s');

		$insert_query->execute( array($uid, $time_unit, $default_bills_class_json, $datetime, $datetime) );
	}
	else
	{
		$bills_class_version = $bills_class['version'];
		$time_unit = $bills_class['time_unit'];
		$bills_class = json_decode( $bills_class['class'], true );
	}

}
catch(PDOException $e)
{
	echo $e->getMessage();
	exit();
}

?>

<?php include_once('budgets_view.php'); ?>
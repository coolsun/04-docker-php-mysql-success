<?php // modify file ?>
<?php
session_start();
header( "Content-Type: application/json", true );
require "../../../../config_conn.inc.php";

ignore_user_abort(true); // Ignore user aborts and allow the script to run forever
set_time_limit(0); // disable php time limit

/* Check JSON string */
function is_JSON( $string )
{
	return is_object( json_decode( $string ) );
}

/* Avoid XSS */
function cleanXSS( $var )
{
    if( is_array( $var ) )
    {
        $temp = array();
        foreach ( $var as $key => $value )
        {
            $key = preg_replace('/[^\d\w_]/', '', $key);
            $temp[ $key ] = cleanXSS( $value );
        }
        return $temp;
    }
    return htmlspecialchars( $var );
}

$uid = $_SESSION['userid'];

if ( isset( $_POST['data'] ) && is_JSON( $_POST['data'] ) )
{
	$data = cleanXSS( json_decode( $_POST['data'], true ) );
}
else
{
	error('Unvalid data format. (Error 1100)');
}

/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch ( PDOException $e ) {
	error("Can't connect to database. ".$e->getMessage().' (Error 1101)' );
}

if ( !(isset($data['iname']) && strlen( trim($data['iname']) ) > 0) ) // Check null name
{
	error("投資項目名稱不能為空白.");
}
$data['iname'] = trim($data['iname']);
if ( !isset($data['marketcap']) || !is_numeric($data['marketcap']) )
{
	$data['marketcap'] = 0;
}
$data['marketcap'] = abs( floatval($data['marketcap']) );

try
{
  //$replace_query_string = 'REPLACE INTO `marketcaps` (`user_id`, `account_id`, `invest_name`, `price`) VALUES (?, ?, ?, ?)';
  $delete_query_string = 'DELETE FROM `marketcaps` WHERE `user_id` = ? AND `account_id` = ? AND `invest_name` = ?';
  $delete_query = $dbh->prepare($delete_query_string);
  $delete_query->execute(array(
    $uid, $data['aid'], $data['iname']
  ));

  $insert_query_string = 'INSERT INTO `marketcaps`(`user_id`, `account_id`, `invest_name`, `price`) VALUES (?, ?, ?, ?)';
  $insert_query = $dbh->prepare($insert_query_string);
  $insert_query->execute(array(
    $uid, $data['aid'], $data['iname'], $data['marketcap']
  ));


  $res = array("status"=>true);
}
catch ( PDOException $e )
{
  error_log($e->getMessage());
	error("Error - ".$e->getMessage().' (Error 1102)' );
}

echo json_encode($res);
?>

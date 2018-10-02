<?php
/**
 *	$uid from budgets.php
 *	$time_unit from budgets.php
 *	$bills_class_version from budgets.php
 *	$bills_class from budgets.php
 */
$bills_out_class = $bills_class[0];
//unset($bills_class);


/* Indices */
$time_units = array('每週', '每月', '每季');

if ( isset($_POST['tu']) && in_array( intval($_POST['tu']), array(0, 1, 2) ) )
{
	$time_unit = intval( $_POST['tu'] );
}

/* Update budgets */
$bugets = array();
$update_flag = false;
if ( isset($_POST) )
{
	foreach ( $_POST as $key => $value )
	{
		if ( preg_match('/^(\d+)-(\d+)$/', $key, $indices) )
		{
			if ( !isset( $budgets[ $indices[1] ] ) )
			{
				$budgets[ $indices[1] ] = array();
			}

			/*
			 |
			 | Only prevent error update budget after user update bills sub class item.
			 | If user update bills mian class item, it may cause error update budget item.
			 |
			 */
			if ( is_numeric( $value ) )
			{
				/*$budgets[ $indices[1] ][ $indices[2] ] = array(
					'name'   => $_POST[ $indices[0].':name' ],
					'budget' => floatval($value)
				);*/

				foreach ( $bills_class[0]['subclass'][ $indices[1] ]['subclass'] as $sid => $sclass )
				{
					if ( $sclass['name'] == $_POST[ $indices[0].':name' ] )
					{
						//echo '<div>'.$sclass['name'].'<->'.$_POST[ $indices[0].':name' ].'</div>';
						$bills_class[0]['subclass'][ $indices[1] ]['subclass'][ $sid ]['budget'] = floatval($value);
						$update_flag = true;
						break;
					}
				}
			}
			elseif ( trim($value) == '' )
			{
				/*$budgets[ $indices[1] ][ $indices[2] ] = array(
					'name'   => $_POST[ $indices[0].':name' ],
					'budget' => false
				);*/

				foreach ( $bills_class[0]['subclass'][ $indices[1] ]['subclass'] as $sid => $sclass )
				{
					if ( $sclass['name'] == $_POST[ $indices[0].':name' ] )
					{
						unset($bills_class[0]['subclass'][ $indices[1] ]['subclass'][ $sid ]['budget']);
						$update_flag = true;
						break;
					}
				}

			}

		}
	}
}

if ( $update_flag )
{
	if ( $_POST['version'] != $bills_class_version )
	{
		$_POST['version'] =	$bills_class_version;
		$_SESSION['post'] = $_POST;
		ob_end_clean();
    	header("Location: http://" .  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	}

	try
	{
		$update_query_string = "UPDATE `bills_class` SET `time_unit`=?, `class`=? WHERE `user_id`=?";
		$update_query = $dbh->prepare( $update_query_string );

		/*array_walk_recursive($bills_class, function(&$value, $key) {
		    if( is_string($value) )
		    {
		        $value = urlencode($value);
		    }
		});*/
		array_walk_recursive($bills_class, 'encode_ch');

		$update_query->execute( array( intval($time_unit), urldecode( json_encode($bills_class) ), $uid ) );
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		exit();
	}
}

?>

<?php include_once('index_view.php'); ?>
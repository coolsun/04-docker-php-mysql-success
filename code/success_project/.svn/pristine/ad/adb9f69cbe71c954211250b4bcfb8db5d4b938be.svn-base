<?php
/**
 *	$uid from budgets.php
 *	$time_unit from budgets.php
 *	$bills_class_version from budgets.php
 *	$bills_class from budgets.php
 */

/* Indices */
$durings = array('前30天', '前60天', '前半年', '前一年');
$durings_units = array( 30, 60, 183, 366);

/* Test data */
//$time_unit = 1;
//$_POST['selectedDuring'] = 1;
//$_POST['selfLastDate'] = '2014/08/30';

/* Selected During */
$selectedDuring = 0; // Default value
if( isset($_POST['selectedDuring']) && in_array( intval( $_POST['selectedDuring']), array( 0, 1, 2, 3 ) ) )
{
	$selectedDuring = intval($_POST['selectedDuring']);
}

/* selfLastDate */
$selfLastDate = date('Y-m-d');
if( isset($_POST['selfLastDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfLastDate']) )
{
	$selfLastDate = date('Y-m-d', strtotime($_POST['selfLastDate']));
}

/* Sum costs */
$budgets_costs = array();
$budgets_sub_costs = array();
$main_class_name = array();
$sub_class_name = array();

if ( $time_unit == 0 )
{
	$divideBy = 7;
}
elseif ( $time_unit == 1 )
{
	$divideBy = 30;
}
elseif ( $time_unit == 2 )
{
	$divideBy = 30;
}

foreach ( $bills_class[0]['subclass'] as $mid => $mclass )
{
	$main_class_name[] = "'".$mclass['name']."'";
	$main_class_budget = 0;
	foreach ( $mclass['subclass'] as $sid => $sclass )
	{
		if ( isset( $sclass['budget'] ) )
		{
			$main_class_budget += $sclass['budget'];
			$sub_class_name[] = "'".$sclass['name']."'";
			$budgets_sub_costs[ $sclass['name'] ] = array('budget' => $sclass['budget'] * ceil( $durings_units[ $selectedDuring ] / $divideBy ), 'cost' => 0);
		}
	}
	if ( $time_unit == 0 )
	{
		$budgets_costs[ $mclass['name'] ] = array('budget' => $main_class_budget * ceil( $durings_units[ $selectedDuring ] / $divideBy ), 'cost' => 0);
	}
	elseif ( $time_unit == 1 )
	{
		$budgets_costs[ $mclass['name'] ] = array('budget' => $main_class_budget * ceil( $durings_units[ $selectedDuring ] / $divideBy ), 'cost' => 0);
	}
	elseif ( $time_unit == 2 )
	{
		$budgets_costs[ $mclass['name'] ] = array('budget' => $main_class_budget * ceil( $durings_units[ $selectedDuring ] / $divideBy ), 'cost' => 0);
	}
	//$budgets_costs[ $mclass['name'] ] = $main_class_budget;
}
$main_class_name = join( ", ", $main_class_name );
$sub_class_name = join( ", ", $sub_class_name );


/* Get budgets */
if ( $sub_class_name )
{
	// $get_query_string = "SELECT `main_class_name` as `name`, SUM(`money`) as `cost` FROM `bills` WHERE `user_id`=? AND `bill_type`=0 AND `main_class_name` IN (".$main_class_name.") AND (`bill_date` BETWEEN ? AND ? ) GROUP BY `main_class_name`";
	$get_query_string = "SELECT `sub_class_name` as `name`, SUM(`money`) as `cost` FROM `bills` WHERE `user_id`=? AND `bill_type`=0 AND `sub_class_name` IN (".$sub_class_name.") AND (`bill_date` BETWEEN ? AND ? ) GROUP BY `sub_class_name`";
	$params = array($uid);
	$params[] = date('Y-m-d', strtotime($selfLastDate.' -'.$durings_units[ $selectedDuring ].' day'));
	$params[] = $selfLastDate;
	$get_query = $dbh->prepare( $get_query_string );
	$get_query->execute( $params );
	$bills_out_list = $get_query->fetchAll( PDO::FETCH_ASSOC );
}
else
{
	$bills_out_list = array();
}

// foreach ( $bills_out_list as $main_class_cost )
// {
// 	if ( isset( $budgets_costs[ $main_class_cost['name'] ] ) )
// 	{
// 		$budgets_costs[ $main_class_cost['name'] ][ 'cost' ] = $main_class_cost['cost'];
// 	}
// }
foreach ( $bills_out_list as $sub_class_cost )
{
	if ( isset( $budgets_sub_costs[ $sub_class_cost['name'] ] ) )
	{
		$budgets_sub_costs[ $sub_class_cost['name'] ][ 'cost' ] = $sub_class_cost['cost'];

	}
}



$dataset = array( array(), array() );
$names = array();
foreach ( $budgets_sub_costs as $name => $bc )
{
	if ( floatval($bc['budget']) == 0 )
	{
		continue;
	}
	$dataset[0][] = floatval($bc['budget']);
	$dataset[1][] = floatval($bc['cost']);
	$names[] = $name;
}

/*array_walk_recursive($names, function(&$value, $key) {
    if( is_string($value) )
    {
        $value = urlencode($value);
    }
});*/
array_walk_recursive($names, 'encode_ch');
$names = urldecode( json_encode($names) );

// echo date('Y-m-d', strtotime($selfLastDate.' -'.$durings_units[ $selectedDuring ].' day'));
// echo '>>'.$selfLastDate;
// echo $durings_units[ $selectedDuring ].'/'.$time_unit."->";
// echo ceil( $durings_units[ $selectedDuring ] / 30 );

?>

<?php include_once('chart_view.php'); ?>
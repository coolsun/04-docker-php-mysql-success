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


/* Test data */
//$_POST['selectedDuring'] = 3;
//$_POST['selectedBillType'] = 0;
//$_POST['selfLastDate'] = '2014/08/30';


/* Indices */
$bill_types = array(
	0 => array( 0 => '支出', 1 => '收入'),
	1 => array( 0 => '刷卡', 1 => '繳款' ),
	3 => array( 0 => '減少', 1 => '增加' ),
	4 => array( 0 => '增加', 1 => '減少' ),
);
$durings = array( '前30天', '前60天', '前半年', '前一年' );
$durings_units = array( 30, 60, 183, 366);


/* Get all accounts id */
try
{
	/* Get accounts data of the user */
	$query_string = 'SELECT  `account_type`, `account_id`, `account_name` FROM `accounts` WHERE `user_id`=? AND `account_type` <> 2 AND `account_type` <> 3 ORDER BY `account_type`, `created`';
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$all_accounts = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_ASSOC );
	if ( !$all_accounts )
	{
		echo "請先至帳戶管理新增帳戶";
		exit();
	}
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}

/* Check selected account id */
$in_accounts_flag = false;

if (isset($_SESSION['bills_selected_atype']) && isset($_SESSION['bills_selected_aid']))
{
  $selected_atype = $_SESSION['bills_selected_atype'];
  $selected_aid = $_SESSION['bills_selected_aid'];
}

if ( isset($_POST['account']) && preg_match('/^(\d)+-(\d+)$/', $_POST['account'], $match) ) // check post account is in account list
{
	$selected_atype = $match[1];
	$selected_aid   = $match[2];
}

if (isset($selected_aid))
{
  foreach ( $all_accounts[ $selected_atype ] as $i => $account )
  {
    if ( $account['account_id'] == $selected_aid )
    {
      $in_accounts_flag = true;
      break;
    }
  }
}

if ( !$in_accounts_flag ) // if not use first account as default
{
	foreach ( $all_accounts as $atype => $accounts )
	{
		foreach ( $accounts as $i => $account ) {
			$selected_atype = $atype;
			$selected_aid   = $account['account_id'];
			$in_accounts_flag = true;
			break;
		}
		break;
	}
}

$_SESSION['bills_selected_atype'] = $selected_atype;
$_SESSION['bills_selected_aid'] = $selected_aid;

/* Selected During */
$selectedDuring = 0; // Default value
if( isset($_POST['selectedDuring']) && in_array( intval( $_POST['selectedDuring']), array( 0, 1, 2, 3 ) ) )
{
  $selectedDuring = intval($_POST['selectedDuring']);
}
else if( isset($_SESSION['selectedDuring']) && in_array( intval( $_SESSION['selectedDuring']), array( 0, 1, 2, 3 ) ) )
{
  $selectedDuring = intval($_SESSION['selectedDuring']);
}

$_SESSION['selectedDuring'] = $selectedDuring;

//echo $selectedDuring.' : ';

/* selfLastDate */
$selfLastDate = date('Y-m-d');
if( isset($_POST['selfLastDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfLastDate']) )
{
	$selfLastDate = date('Y-m-d', strtotime($_POST['selfLastDate']));
}

/* SelectedBillTyoe */
$selectedBillType= 0; // Default value
if( isset($_POST['selectedBillType']) && in_array( intval( $_POST['selectedBillType']), array( 0, 1 ) ) )
{
	$selectedBillType = intval($_POST['selectedBillType']);
}
else if( isset($_SESSION['selectedBillType']) && in_array( intval( $_SESSION['selectedBillType']), array(0, 1 ) ) )
{
  $selectedBillType = intval($_SESSION['selectedBillType']);
}

$_SESSION['selectedBillType'] = $selectedBillType;

/* Check if user bills class is exist , if not , create it */
try
{
	$query_string = "SELECT `time_unit`, `class` FROM `bills_class` WHERE `user_id` = ? LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$bills_class = $query->fetch( PDO::FETCH_ASSOC );

	if ( !$bills_class )
	{
		$time_unit = 1;
		$default_bills_class_json = file_get_contents('bills_class.json', 1);
		$insert_query_string = "INSERT INTO `bills_class` (`user_id`, `time_unit`, `class`, `updated`, `created`) VALUES (?, ?, ?, ?, ?) ";
		$insert_query = $dbh->prepare( $insert_query_string );
		$datetime = date('Y-m-d H:i:s');
		$insert_query->execute( array($uid, $time_unit, $default_bills_class_json, $datetime, $datetime) );

		$bills_class =  json_decode( $default_bills_class_json, true );
	}
	/*else
	{
		$time_unit = $bills_class['time_unit'];
		$bills_class = json_decode( $bills_class['class'], true );
	}*/

}
catch(PDOException $e)
{
	echo $e->getMessage();
	exit();
}

/* Get bills */
try
{
	//$get_query_string  = "SELECT `bill_id`, `bill_date`, `bill_type`, `main_class_id` AS `m`, `sub_class_id` AS `s`, `main_class_name` AS `mn`, `sub_class_name` AS `sn`, `payee`, `money`, `balance`, `description` ";
	$get_query_string  = "SELECT `bill_id`, `bill_date`, `bill_type`, `main_class_name` AS `mn`, `sub_class_name` AS `sn`, `payee`, `money`, `balance`, `description` ";
	$get_query_string .= "FROM `bills` WHERE `user_id`=? AND `account_id`=? AND `bill_type`=? ";
	$params = array($uid, $selected_aid, $selectedBillType);
	if ( $selectedBillType != -1 )
	{
		$get_query_string .= "AND `bill_type`=? ";
		$params[] = $selectedBillType;
	}
	$get_query_string .= "AND (`bill_date` BETWEEN ? AND ? ) ";
	$params[] = date('Y-m-d', strtotime($selfLastDate.' -'.$durings_units[ $selectedDuring ].' day'));
	//echo date('Y-m-d', strtotime($selfLastDate.' -'.$durings_units[ $selectedDuring ].' day'));
	//echo '>>'.$selfLastDate;
	$params[] = $selfLastDate;
	$get_query_string .= "ORDER BY `bill_date` DESC, `created` ASC";
	$get_query = $dbh->prepare( $get_query_string );
	$get_query->execute( $params );
	$bills_list = $get_query->fetchAll( PDO::FETCH_ASSOC );

	if ( !$bills_list )
	{
		$bills_list = array();
	}

	$bills_list_json = array();
	$bills_list_main_class = array();
	foreach ( $bills_list as $bill )
	{
		$bills_list_main_class[ $bill['mn'] ] += $bill['money'];

		if( !isset( $bills_list_json[ urlencode($bill['mn']) ] ) )
		{
			$bills_list_json[ urlencode($bill['mn']) ] = array();
		}

		$bills_list_json[ urlencode($bill['mn']) ][] = array(
			'date'  => str_replace('-', '/', $bill['bill_date']),
			'payee' => $bill['payee'],
			'class' => $bill['mn'].":".$bill['sn'],
			'description' => $bill['description'],
			'atype' => intval($bill['bill_type']),
			'money' => floatval($bill['money']),
			'balance' => floatval($bill['balance'])
		);
	}
	/*array_walk_recursive($bills_list_json, function(&$value, &$key) {
	    if( is_string($value) )
	    {
	        $value = urlencode($value);
	    }
	});*/
	array_walk_recursive($bills_list_json, 'encode_ch');
	$bills_list_json = urldecode( json_encode($bills_list_json) );

	//print_r($bills_list_main_class);
	/*array_walk_recursive($bills_list, function(&$value, $key) {
	    if( is_string($value) )
	    {
	        $value = urlencode($value);
	    }
	});
	$bills_list = urldecode( json_encode($bills_list) );*/

	$count = 0;
	$pie_data = array();
	foreach ( $bills_list_main_class as $mn => $sum )
	{
		$pie_data[] = array( 'name' => $mn, 'y' => $sum, 'id' => $count );
		$count++;
	}
	/*array_walk_recursive($pie_data, function(&$value, $key) {
	    if( is_string($value) )
	    {
	        $value = urlencode($value);
	    }
	});*/
	array_walk_recursive($pie_data, 'encode_ch');
	$pie_data = urldecode( json_encode($pie_data) );


	$bar_item_names = array();
	$bar_data = array();
	foreach ( $bills_list_main_class as $mn => $sum )
	{
		$bar_item_names[] = $mn;
		$bar_data[] = array( 'y'=> $sum, 'p' => round( $sum / array_sum($bills_list_main_class) ) );
	}
	/*array_walk_recursive($bar_item_names, function(&$value, $key) {
	    if( is_string($value) )
	    {
	        $value = urlencode($value);
	    }
	});*/
	array_walk_recursive($bar_item_names, 'encode_ch');
	$bar_data = json_encode($bar_data);
	$bar_item_names = urldecode( json_encode($bar_item_names) );

}
catch(PDOException $e)
{
	echo $e->getMessage();
	exit();
}

?>

<script src="js/charts/highstock.js"></script>
<script src="js/charts/accounting.min.js"></script>

<script type="text/javascript">
var bills = <?=$bills_list_json?>;
var pie_dataset = <?=$pie_data?>;
var bar_dataset = <?=$bar_data?>;
var bar_names = <?=$bar_item_names?>;

function randomHexColorCode() {
    return '#' + Math.floor(Math.random()*16777215).toString(16);
}

function piechart( chartDivId, datasetName, dataset, sumName, isMoney ) {
	//Default 10 Colors
	var sliceColors = ['#DE5314', '#E9C018', '#8BC200', '#397DC8', '#BF54C3',
        	    	   '#ABABAC', '#953329', '#50AF72', '#E17D14', '#7D7D7D'];
    //If data items more than 10, random create not repeated colors
    if( dataset.length > 10 ) {
    	for( var i = 0 ; i < dataset.length - 10 ; i++ ) {
    		var tempColorCode = randomHexColorCode();
    		//alert(tempColorCode + ' => ' + sliceColors.indexOf( tempColorCode ));
    		if( $.inArray( tempColorCode, sliceColors ) > -1 ) {2
    			i--;
    		}
    		else {
    			sliceColors.push( tempColorCode );
    		}
    	}
    }
    //Transform to gradient color data structure
    var chartColors = [];
    for( var i in sliceColors ) {
    	chartColors.push(
    		{
    		        radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
    		        stops: [
    		            [0, Highcharts.Color( sliceColors[i] ).brighten(  0.3 ).get('rgb')],
    		            [1, Highcharts.Color( sliceColors[i] ).brighten( -0.2 ).get('rgb')] // darken
    		        ]
    		}
    	);
    }

    /*
     Sum of dataset
    */
    var sum = 0;
    for( var i in dataset ) {
    	sum += dataset[i].y;
    }
    dataset.push( {name: sumName, y: 0.0, color: '#CCCCCC'} );

    /*
     Highcharts Settings
    */
	chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            type: 'pie',
            events: {
                load: function(event) {
                   $('#'+chartDivId).find('.item:not(:last):odd').css('background-color', '#CDE5FF');
                   $('#'+chartDivId).find('.item:last').css('background-color', '#CCCCCC');
                   $('#'+chartDivId).find('.item:last .sumIconMask').css('border-width', parseFloat($('#'+chartDivId).find('.item:last').css('height'))/2 +'px' );
                   var valueMaxWidth = 0;
                   $('#'+chartDivId).find('.item').each(function(){
                   		if( parseInt( $(this).find('span:eq(1)').css('width') ) > valueMaxWidth ) {
                   			valueMaxWidth = parseInt( $(this).find('span:eq(1)').css('width') );
                   		}
                   });
                   $('#'+chartDivId).find('.item').each(function(){
                   			$(this).find('span:eq(1)').css('width', valueMaxWidth+'px');
                   });
                   if( navigator.userAgent.match(/Windows NT/i) || navigator.userAgent.match(/msie/i) ) {
                        //$('#'+chartDivId).find('.last-item').css('padding-top', '1px');
                        $('#'+chartDivId).find('.last-item div.item-name-sum').css('padding-top', '1px');
                        $('#'+chartDivId).find('.last-item div.item-value').css('padding-top', '1px');
                        $('#'+chartDivId).find('.last-item div.item-percent').css('padding-top', '1px');
                        //$('#'+chartDivId).find('div.item-name').css('padding-top', '2px');
                   }
                }
            },
            //height: 300,
            //width: 640
        },
        credits:{
            enabled: false
        },
        title: {
            text: ''
        },
        colors : chartColors,
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            y: 40,
			borderWidth: 1,
            margin: 120,
            useHTML: true,
            itemStyle: {
                "fontWeight" : "normal"
            },
			labelFormatter: function() {
                if( this.name == sumName ) {
                	var tempSum;
                	if( isMoney ) {
                		tempSum = accounting.formatMoney( sum,'$',0 );
                	}
                	else {
                		tempSum = sum.toFixed(2);
                	}
                    return ['<div id="sum" class="item last-item" style=" height: 18px;">',
                                '<div class="sumIconMask" style="position: absolute; top: 0; left: -22px; height: 18px; width: 24px; background-color: #ccc;">&nbsp;</div>',
                                '<div class="item-name-sum" style="display: inline-block; padding:0px 5px; width: 60px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px;">',this.name,'</div>',
                                '<div class="item-value" style="display: inline-block; width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px;">',tempSum,'</div>',
                                '<div class="item-percent" style="display: inline-block; width: 45px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px; text-align: right; padding:0px 5px;">100%</div>',
                            '</div>'].join('');
                    //return '<div id="sum" class="item last-item" style="width: 220px; height: 18px; padding: 1px 0px;"><div class="sumIconMask" style="position: absolute; top: 0; left: -21px; height: 18px; width: 24px; background-color: #ccc; font-size: 12px;">&nbsp;</div><div style="display: inline-block; padding: 0; width:60px; height: 18px; line-height; 18px; padding-left: 5px; font-size: 12px; font-family:\'\\9ED1\\4F53\';"><div class="item-name-sum" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px;  padding-top: 3px\\9;">' + this.name + '</div></div><div style="display: inline-block; padding: 0; width: 120px; height: 16px; line-height; 16px;"><div style="font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' + tempSum + '</div></div><div style="display: inline-block; padding: 0; padding-right: 3px; width: 40px; height: 16px; line-height; 16px; text-align: right;"><div style="font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">100%</div></div></div>';
                    //return '<div id="sum" class="item" style="width: 220px; font-size: 12px; "><div class="sumIconMask" style="position: absolute; top: 0; left: -21px; height: 18px; width: 24px; background-color: #ccc; ">&nbsp;</div><div style="display: inline-block; vertical-align: middle; padding: 0; width:60px; height: 18px;  padding-left: 5px; font-family:\'\\9ED1\\4F53\'; font-size: 12px; padding-top: 1px; padding-top: 3px\\9;">' + this.name + '</div><div style="display: inline-block; vertical-align: middle; padding: 0; width: 120px; height: 18px; line-height: 18px;">' + tempSum + '</div><div style="display: inline-block; vertical-align: middle; padding: 0; padding-right: 3px; width: 40px; height: 18px; line-height: 18px; text-align: right;">100%</div></div>';
                }
                var tempValue;
                if( isMoney ) {
                		tempValue = accounting.formatMoney( this.y,'$',0 );
               	}
               	else {
                		tempValue = this.y;
                }
                return ['<div id="sum" class="item last-item" style=" height: 18px;">',
                            '<div class="item-name-sum" style="display: inline-block; padding:0px 5px; width: 60px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:16px;">',this.name,'</div>',
                            '<div class="item-value" style="display: inline-block; width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px;">',tempValue,'</div>',
                            '<div class="item-percent" style="display: inline-block; width: 45px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px; text-align: right; padding:0px 5px;">',Math.round( this.percentage ),'%</div>',
                        '</div>'].join('');
				//return '<div class="item" style="width: 220px; height: 18px; font-size: 12px;"><div style="display: inline-block; vertical-align: middle; padding: 0; width:60px; height: 18px; line-height: 18px; padding-left: 5px; font-family:\'\\9ED1\\4F53\'; font-size: 12px; padding-top: 1px\\9;"><div class="item-name" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding-top: 1px\\9; font-size: 12px;">' + this.name + '</div></div><div style="display: inline-block; vertical-align: middle; padding: 0; width: 120px; height: 18px; line-height: 18px;"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px;">' + tempValue + '</div></div><div style="display: inline-block; vertical-align: middle; padding: 0; padding-right: 3px; width: 40px; height: 18px; line-height: 18px; text-align: right; font-size: 12px;"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px;">' + Math.ceil( this.percentage ) + '%</div></div></div>';
                //return '<text class="item" style="width: 220px;">' + this.name + ' ' + tempValue + ' ' + Math.ceil( this.percentage ) + '%</text>';
			}
        },
        plotOptions: {
        	series: {
        		point: {
	        		events: {
	            		click: function(event) {
	            			get_bills(bills[this.name]);
	            			setPosition(event.chartX,event.chartY);
	            		}
	            	}
            	}
        	},
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                borderWidth: 0,
                size: 260,
                center: [110, 145],
                dataLabels: {
                    enabled: false,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                    }
                },
                states : {
                    hover: {
                        // enabled: false,
                        halo: {
                            size: 0
                        },
                        marker: {
                            enabled: false
                        }
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: datasetName,
            data: dataset,
            startAngle: -90,
            animation: {
                duration: 2000
            }
        }],
        exporting: {
            url: 'export-chart/index.php'
        }
    });

    return chart;
}

function costbarchart( chartDivId, datasetName, dataset, xAxisNames, yAxisTitle, chartTitle, costName, proportionName, barMaxNum, isMoney )
{

    /*
     Highcharts Settings
    */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };

    //Max bar numbers in view
    var isScrollable = true;
    var titleShift = -30;
    if( dataset.length == barMaxNum || dataset.length < barMaxNum ) {
        //alert(dataset.length+'x'+barMaxNum);
        barMaxNum = dataset.length;
        isScrollable = false;
        titleShift = 0;
    }
    barMaxNum -= 1;

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            height: 300,
            //width: 640,
            marginTop: 20,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            //text: chartTitle,
            text: '',
            verticalAlign: 'bottom',
            y: titleShift
        },
        scrollbar:{
                enabled:isScrollable
        },
        colors: [
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#5408A1'],
                  [0.4, '#9C59DE'],
                  [0.6, '#9C59DE'],
                  [1, '#5408A1']
                ]
            }
        ],
        xAxis: {
            categories: xAxisNames,
            min: 0,
            max: barMaxNum,
            events:{
                afterSetExtremes:function() {

                    var chart = this.chart;

                    chart.yAxis[0].update({
                        min: 0,
                        max: yMax
                    });
                }
            }
        },
        yAxis: {
            lineWidth: 1,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            },
            labels: {
                formatter: function() {
                    var maxElement = this.axis.max;
                    if (maxElement > 1000) {
                        return (this.value / 1000) + " K";
                    }
                    else {
                        return this.value;
                    }
                }
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 1,
            margin: 60,
        },
        tooltip: {
            formatter: function() {
                    var tempValue;
                    if( isMoney ) {
                            tempValue = accounting.formatMoney( this.y,'$',0 );
                    }
                    else {
                            tempValue = this.y;
                    }
                    var tip = '<b>'+ this.series.name +':</b> '+ this.x +'<br/><b>'+ costName +': </b>' + tempValue;
                    if( this.point.p ) {
                        tip += '<br><b>'+ proportionName +': </b>' + this.point.p;
                    }
                    return tip;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                pointWidth: 26,
                borderWidth: 0
            }
        },
        series: [{
            type: 'column',
            name: datasetName,
            data: dataset,
            xAxis: 0
        }]
    });

    return chart;
}

$(function(){
	var pie = piechart( 'pie', '支出', pie_dataset, '總計', true );
	var bar = costbarchart( 'bar', '支出', bar_dataset, bar_names, '(單位: 千元)', null, '支出', '比例', 6, true );
});

<?php include_once('statics_view.php'); ?>
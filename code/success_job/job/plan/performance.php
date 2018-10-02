<?php
/*
 Indexs
*/
$job_status_weights = array(0, 0.7, 1, 0.5);
$job_priorities_weights = array(10, 8, 6);
$job_status = array('未開始',  '執行中', '已完成', '延遲');
//$jobs_status_count = array( '未開始' => 0, '執行中' => 0, '已完成' => 0, '延遲' => 0 );

$durings = array('前7天' => 7, '前14天' => 14, '前30天' => 30, '前60天' => 60);
$sdurings = array('7天' => 7, '14天' => 14, '30天' => 30, '60天' => 60);

// Post-Redirect-Session
if( isset($_POST['selectedDuring']) ) {
    $_SESSION['selectedDuring'] = $_POST['selectedDuring'];
    if(  isset($_POST['selfLastDate']) ) {
        $_SESSION['selfLastDate'] = $_POST['selfLastDate'];
    }
    // Redirect to this page.
    ob_end_clean();
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
else {
    $_POST['selectedDuring'] = $_SESSION['selectedDuring'];
    unset( $_SESSION['selectedDuring'] );

    if( isset($_SESSION['selfLastDate']) ) {
        $_POST['selfLastDate'] = $_SESSION['selfLastDate'];
        $_POST['selfLastDate'] = str_replace('/', '-', $_POST['selfLastDate']);

        unset( $_SESSION['selfLastDate'] );
    }
}

$query_jobs_sql = 'SELECT `job_id`, `job_title`, `job_priority`, `job_status` FROM `jobs` WHERE `user_id` = ? ';
$query_jobs_params = array($_SESSION['userid']);

$backDays = 0;
if( isset($durings[ $_POST['selectedDuring'] ]) || isset($sdurings[ $_POST['selectedDuring'] ])) {
    

    if( isset($_POST['selfLastDate']) ) {
        $backDays = $sdurings[ $_POST['selectedDuring'] ];
        if( !trim($_POST['selfLastDate']) ) { $_POST['selfLastDate'] = date( 'Y-m-d'); }
        // Self define during
        /*
        $query_jobs_sql .= 'AND (`job_start_date` BETWEEN ? AND ?) OR (`job_end_date` BETWEEN ? AND ?) OR (`job_start_date` < ? AND `job_end_date` > ? ) ';
        $earliestDate = date( 'Y-m-d', strtotime($_POST['selfLastDate'].' -'. $backDays .' day') );
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, $_POST['selfLastDate']);
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, $_POST['selfLastDate']);
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, $_POST['selfLastDate']);
        */
        //echo $earliestDate.'<br>';
        $query_jobs_sql .= 'AND (`created_datetime` BETWEEN ? AND ? )  ';
        $earliestDate = date( 'Y-m-d 00:00:00', strtotime($_POST['selfLastDate'].' -'. $backDays .' day') );
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, date( 'Y-m-d 23:59:59', strtotime($_POST['selfLastDate']) ) );

        unset($_POST['selectedDuring']);
    }
    else {
        $backDays = $durings[ $_POST['selectedDuring'] ];
        // Selection During
        /*
        $query_jobs_sql .= 'AND ((`job_start_date` BETWEEN ? AND \''.date('Y-m-d').'\') OR (`job_end_date` BETWEEN ? AND \''.date('Y-m-d').'\') OR (`job_start_date` < ? AND `job_end_date` > ? )) ';
        $earliestDate = date( 'Y-m-d', strtotime('-'. $backDays .' day') );
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, date('Y-m-d'));
        //echo $earliestDate.'<br>';
        */
        $query_jobs_sql .= 'AND (`created_datetime` BETWEEN ? AND ? )  ';
        $earliestDate = date( 'Y-m-d 00:00:00', strtotime('-'. $backDays .' day') );
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, date('Y-m-d 23:59:59'));
    }
}
else {
    // Default backDays = 14 days
    /*
    $query_jobs_sql .= 'AND (`job_start_date` BETWEEN ? AND \''.date('Y-m-d').'\') OR (`job_end_date` BETWEEN ? AND \''.date('Y-m-d').'\') OR (`job_start_date` < ? AND `job_end_date` > ? ) ';
    $earliestDate = date( 'Y-m-d', strtotime('-14 day') );
    array_push($query_jobs_params, $earliestDate);
    array_push($query_jobs_params, $earliestDate);
    array_push($query_jobs_params, $earliestDate);
    array_push($query_jobs_params, date('Y-m-d'));
    */
    $query_jobs_sql .= 'AND (`created_datetime` BETWEEN ? AND ? )  ';
    $earliestDate = date( 'Y-m-d 00:00:00', strtotime('-14 day') );
    array_push($query_jobs_params, $earliestDate);
    array_push($query_jobs_params, date('Y-m-d 23:59:59'));
}

$query_jobs = $dbh->prepare( $query_jobs_sql );
$query_jobs->execute( $query_jobs_params );

$job_dataset = $query_jobs->fetchAll(PDO::FETCH_ASSOC);

//print_r($job_dataset);

$job_ids = '';
if( count($job_dataset) ) {
    foreach( $job_dataset as $job ) {
        $job_ids .= $job['job_id'] .",";
    }
    $job_ids = substr($job_ids, 0, strlen($job_ids)-1);


    $query_subjobs = $dbh->prepare('SELECT `subjob_id`, `parent_job_id`, `subjob_title`, `subjob_priority`, `subjob_status` FROM `subjobs` WHERE `user_id` = ? AND `parent_job_id` IN ( '. $job_ids .' )');
    $query_subjobs->execute(array($_SESSION['userid']));
    $subjob_dataset = $query_subjobs->fetchAll(PDO::FETCH_ASSOC);  

    $dataRows += count( $subjob_dataset );

    $temp_subjob_dataset = array();
    foreach( $subjob_dataset as $index => $subjob ) {
        if( isset( $temp_subjob_dataset[ $subjob['parent_job_id'] ] ) ) {
            $temp_subjob_dataset[ $subjob['parent_job_id'] ][] = $subjob;
        }
        else {
            $temp_subjob_dataset[ $subjob['parent_job_id'] ] = array( $subjob );
        }
    }
    $subjob_dataset = $temp_subjob_dataset;
    unset( $temp_subjob_dataset );
}
//print_r($subjob_dataset);

$jobs_weights_dataset = array();
$jobs_status_count = array( 0 => 0, 1 => 0, 2 => 0, 3 => 0);
$sum = 0;
$amount = count( $job_dataset );
foreach( $job_dataset as $job ) {
	$tempScore = 0;
	if( isset($subjob_dataset[ $job['job_id'] ]) ) {
		foreach( $subjob_dataset[ $job['job_id'] ] as $subjob ) {
				$tempScore += $job_status_weights[ $subjob['subjob_status'] ] * $job_priorities_weights[ $subjob['subjob_priority'] ];
				$jobs_status_count[ $subjob['subjob_status'] ] += 1;
		}
		$tempScore /= count( $subjob_dataset[ $job['job_id'] ] );
	}
	else {
		$tempScore = $job_status_weights[ $job['job_status'] ] * $job_priorities_weights[ $job['job_priority'] ];
		$jobs_status_count[ $job['job_status'] ] += 1;
	}
	$jobs_weights_dataset[] = array( 'title' => $job['job_title'], 'score' => $tempScore);
	$sum += $tempScore;
}
if( $amount > 0 ) {
	$averageScore = sprintf("%.1f", ($sum / $amount ));
}
else {
	$averageScore = 0;
}
/*echo $earliestDate.'<br>';
echo $averageScore.'<br>';
print_r($jobs_status_count);*/
//print_r( $jobs_weights_dataset );

?>
<style type="text/css">
@-moz-document url-prefix() {
    div.item > div:nth-child(2) {
        padding-top: 2px;
    }
}
</style>

<script type="text/javascript">
$(function(){
	var average_performance = <?php echo $averageScore; ?>;
	var status = [ <?php foreach( $job_status as $i => $status ) {
		echo "'".$status."'";
		if( $i != 3 ) { echo ", "; }
	} ?> ];
	var status_count = [ <?php foreach( $jobs_status_count as $i => $count ) {
		echo $count;
		if( $i != count($jobs_status_count) - 1 ) { echo ", "; }
	} ?> ];
	var titles = [ <?php $i=0; foreach( $jobs_weights_dataset as $i => $title ) {
		echo "'".$title['title']."'";
		if( $i != count($jobs_weights_dataset) - 1 ) { echo ", "; }
		$i++;
	} ?> ];
	var scores = [ <?php $i=0; foreach( $jobs_weights_dataset as $i => $score ) {
		echo $score['score'];
		if( $i != count($jobs_weights_dataset) - 1 ) { echo ", "; }
		$i++;
	} ?> ];

	work_performance( 'work-performance', average_performance );
	status_percentage( 'status_percentage', status, status_count );
	barchart( 'works-performance', scores, titles, '相對指數', '執行效能分析', 6, 42 );
	barchart( 'status-count', status_count, status, '數量', '狀態分析', 6, 24 );
});
</script>

<script src="js/charts/highstock.js"></script>
<script src="js/charts/highcharts-more.js"></script>
<script src="js/charts/chartslib.js"></script>

<table cellspacing='0' class="performance_table data_table center" style="width: 873px; border-radius: 3px 3px 0 0; border-collapse: separate; border-spacing: 0;">
	<thead>
		<tr>
			<td colspan="2" style="border-radius: 3px 0 0 0;">
				<form method="post">
					<select name="selectedDuring" onChange=" if( $(this).val() != $(this).find('option:last').text() ) {$(this).parent().submit();} else { selfDuring(); $(this).find('option:first').prop('selected', true); } ">
	                    <option>期間</option>
	                <?php 
	                foreach( $durings as $during => $days ) {
	                ?>
	                    <option <?php if($_POST['selectedDuring'] == $during) echo "selected"; ?> ><?php echo $during; ?></option>
	                <?php
	                }
	                ?>
	                    <option>自訂</option>
	                </select>
                </form>
			</td>
			<td colspan="3" style="border-radius: 0 3px 0 0; text-align: right;">
			<?php 
            foreach( $sas[ $ma ] as $subaction => $subaction_name ) {
            ?>
                <a href="?dept=job&ma=plan&sa=<?php echo $subaction; ?>" class="<?php if($sa == $subaction) echo 'on'; ?> button"><?php echo $subaction_name; ?></a>
            <?php
            }
            ?>
			</td>
		</tr>
	</thead>
</table>
<div style="text-align: right; padding: 8px 10px;"><a href="javascript:;" onClick=" $('#performance-explanation').show(300); " style="color: #2c5dc3;">說明事項</a></div>
<div id="performance-explanation" class="explanation-wrap inlinebox" style="display: none; right: 35px; top: 120px;">
	<div style="text-align: right;">
		<div class="inlinebox" style="float: left; padding-left: 8px; margin-top: 5px;"><b>說明事項</b></div>
		<a href="javascript:;" onClick="$(this).parent().parent().stop().hide();" class="closex"><!--<img src="job/img/closex.png" border="0" />--></a>
	</div>
	<div class="explanation-content">
		<table>
			<tbody>
				<tr>
					<td><p style="font-size: 12px;">1.&nbsp;</p></td><td><p style="font-size: 12px;">請務必填寫計劃欄裡每項工作的『重要性』與『狀態』才能進一步作分析。</p></td>
				</tr>
				<tr>
					<td><p style="font-size: 12px;">2.&nbsp;</p></td><td><p style="font-size: 12px;">此效能乃根據每項工作的重要性及狀態做相對加成分析其結果僅供參考並無絕對。</p></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div id="charts" style="text-align: right;">
	<div id="work-performance" class="inlinebox" style="height: 280px; width: 280px;"></div>
</div>
<div>
	<div id="status_percentage" class="inlinebox" style="height: 320px; width: 500px; margin-left: 190px;"></div>
</div>
<div>
	<div id="works-performance" class="inlinebox" style="height: 320px; width: 560px; margin-left: 12px;"></div>
</div>
<div>
	<div id="status-count" class="inlinebox" style="height: 320px; width: 380px; margin-left: 115px;"></div>
</div>

<script type="text/javascript">
	var ie_gauge_y_shift = 0; 
	//alert(navigator.userAgent);
	if(navigator.userAgent.match(/msie/i) || navigator.userAgent.match(/Windows NT/i)){
        ie_gauge_y_shift = -215;
    }
</script>

<script type="text/javascript">
//Selecte during
function selfDuring() {
    var selfDuring = ['<form id="selfDuring" method="post" class="inlinebox" style="width: 100%;">',
                          '<div style="text-align: left; padding-left: 24px;">',
                            '<div class="inlinebox" style="width: 24px;"">從</div>',
                            '<input type="text" name="selfLastDate" class="date-pick" style="width: 120px; text-align: center;" readonly />',
                          '</div>',
                          '<div style="text-align: left; padding-left: 24px; margin-top: 10px;">',
                            '<div class="inlinebox" style="width: 64px;">往前返回</div>',
                            '<select name="selectedDuring" style="width: 82px;">',
                                '<option>7天</option>',
                                '<option>14天</option>',
                                '<option>30天</option>',
                                '<option>60天</option>',
                            '</select>',
                          '</div>',
                     '</form>'].join('');
    $.confirm({
        'title'     : '<b class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 12px; height: 18px;">期間</b>',
        'content'   : selfDuring,
        'width'     : '240',
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() { datepickers(); },
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'action': function(){
                    $('#selfDuring').submit();
                    return true;
                }
            }
        }
    });
}

function datepickers() {

	Date.firstDayOfWeek = 0;
    Date.format = 'yyyy/mm/dd';
    // Default start date
    $('.date-pick').each(function() {
        var sDate = '1900/01/01';
        $(this).datePicker({startDate: sDate, clickInput:true, createButton: false, showYearNavigation: false, horizontalOffset: 130});
    });
}

function work_performance( chartDivId, performance ) {
	
	var BarGradient = { x1: 0, y1: 1, x2: 0, y2: 0 };

	chart = new Highcharts.Chart({
		chart: {
            renderTo: chartDivId,
            type: 'gauge',
            height: 280,
            width: 280,
            marginBottom: 50
        },
        credits:{
            enabled: false
        },
        title : {
        	text: '工作效能',
        	verticalAlign: 'bottom',
        	y: 0
        },
        pane: {
	        startAngle: -130,
	        endAngle: 130,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#DDD']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '100%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 0.9 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 0,
	            innerRadius: '101%',
	            outerRadius: '111%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 0.9 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 1,
	            innerRadius: '111%',
	            outerRadius: '120%'
	        }, {
	            backgroundColor: '#777',
	            borderWidth: 0,
	            outerRadius: '104%',
	            innerRadius: '102%'
	        }]
	    },
	    yAxis: [{
	    	min: 0,
	    	max: 10,
	    	lineWidth: 0,

	    	labels: {
                y: 5,
                formatter: function() {
                	if( this.value % 2 == 0 ) {
                		return '';
                	}
                    return this.value;
                }
            },

	    	minorTickInterval: 0.1,
	        minorTickWidth: 1.5,
	        minorTickLength: 8,
	        minorTickPosition: 'inside',
	        minorTickColor: '#333',

	    	tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 15,
	        tickColor: '#333',
	        
	        tickPositioner: function(min, max) {

	            var pos,
	                tickPositions = [],
	                tickStart = min;
	            //tickStart = 1;
	            
	            for (pos = tickStart; pos <= max; pos += 1) {
	                tickPositions.push(pos);
	            }
	            return tickPositions;
	              
	        },

	    	plotBands: [{
	            from: 0,
	            to: 10,
	            //color: '#F7A954',
	            color: {
	                linearGradient: [100, 50, 280, 100],
	                stops: [
	                    [0, 'rgba(255, 255, 255, 1)'],
	                    [0.6, 'rgba(247, 169, 84, 1)'],
	                    [1, 'rgba(220, 3, 0, 1)']
	                ]
	            },
	            outerRadius: '102%',
	            innerRadius: '79%'
	        }/*,{
	            from: 2.6,
	            to: 7.4,
	            color: 'rgba(225, 225, 255, 0.3)',
	            outerRadius: '98%',
	            innerRadius: '75%'
	        }*/]
	    }],
	    plotOptions: {
	    	gauge: {
	    		dial: {
	    			backgroundColor: 'red',
	    			topWidth: 2,
	    			baseWidth: 5,
	    			rearLength: '15%'
	    		},
	    		pivot: {
	    			backgroundColor: '#333',
					radius: 8
				},
				dataLabels : {
					y: 60 + ie_gauge_y_shift,
					verticalAlign: 'middle',
					borderWidth: 0,
					color: '#333',
					formatter: function() {
	                    return '<font style="font-size: 32px;">' +
	                        this.y +'</font>';
	                }
				}
	    	}
	    },
	    tooltip: {
	    	enabled: false
	    },
        series: [{
	        name: 'Performance',
	        data: [performance]
	    }]
	});
}

function status_percentage( chartDivId, status, status_count ) {

	var sliceColors = ['#E9C018', '#397DC8', '#8BC200', '#DE5314'];

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

	var data = [];
	for( var i in status ) 
	{
		if ( status_count[ i ] == 0 )
		{
			data.push( [ status[ i ], null ] );
		}
		else
		{
			data.push( [ status[ i ], status_count[ i ] ] );
		}		
	}
	console.log(data);

	/** Code to Smoothen Pie Borders **/
    Highcharts.wrap(Highcharts.seriesTypes.pie.prototype, 'drawPoints', function (proceed) {
        if (this.options.borderWidth == 0) {
            Highcharts.each(this.points, function (point) {
            	var strokeWidth = 1;
            	if ( !point.y )
            	{
            		strokeWidth = 0;
            		// point.pointAttr[''].fill.stops[1] = '#ffffff';
            		// point.pointAttr['hover'].fill.stops[1] = '#ffffff';
            		// point.pointAttr['select'].fill.stops[1] = '#ffffff';
            	}
                point.pointAttr['']['stroke-width'] = strokeWidth;
                point.pointAttr[''].stroke = point.pointAttr[''].fill;
                point.pointAttr['hover']['stroke-width'] = strokeWidth;
                point.pointAttr['hover'].stroke = point.pointAttr['hover'].fill;
                point.pointAttr['select']['stroke-width'] = strokeWidth;
                point.pointAttr['select'].stroke = point.pointAttr['select'].fill;
                // console.log( point );
                // console.log(point.pointAttr['select'].fill);
            });
        }
        proceed.apply(this);
    });
    /** End of Code **/

	chart = new Highcharts.Chart({
		chart: {
            renderTo: chartDivId,
            type: 'pie',
            events: {
                load: function(event) {
                	$('#'+chartDivId).find('.item:odd').css('background-color', '#CDE5FF');
                	if( navigator.userAgent.match(/Windows NT/i) && !navigator.userAgent.match(/msie/i) ) {
                        $('#'+chartDivId).find('div.item-name').css('padding-top', '2px');
                        $('#'+chartDivId).find('div.item').css('padding-top', '2px');
                        $('#'+chartDivId).find('div.item').css('height', '16px');
                        //$('#'+chartDivId).find('div.item > div').css('margin-bottom', '6px');
                        //$('#'+chartDivId).find('div.item > div').css('height', '14px');
                        //$('#'+chartDivId).find('div.item > div').css('line-height', '14px');
                   }
                   // for ( var i in this.series[0].data )
                   // {
                   // 		if ( !this.series[0].data[i].y )
                   // 		{
                   // 			this.series[0].data[i].setVisible(false);	
                   // 		}
                   // }
                }
            }
        },
        credits:{
            enabled: false
        },
        colors : chartColors,
        title : {
        	text: '圓餅圖',
        	verticalAlign: 'bottom',
        	x: -108,
        	y: -10
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
			borderWidth: 1,
			useHTML: true,
			margin: 100,
			y: -20,
			labelFormatter: function() {
				return '<div class="item" style="height: 16px; padding-top: 2px\\9;"><div class="inlinebox item-name" style="width: 60px; padding-left: 5px; vertical-align: top; padding-top: 2px\\9; font-size: 12px;  font-family: Arial;">'+ this.name + '</div><div class="inlinebox" style="width: 60px; padding-right: 5px; font-size: 12px; text-align: right; vertical-align: top; -moz-padding-top: 5px; font-family: Arial;">' + parseFloat(Math.round(this.percentage*100))/100 + '%</div></div>';
			}
        },
        plotOptions: {
            pie: {
                allowPointSelect: false,
                cursor: 'pointer',
                showInLegend: true,
                borderWidth: 0,
                size: 242,
                center: [120, 110],
                dataLabels: {
                    enabled: false
                }/*,
                point: {
				    events: {
				        legendItemClick: function () {
				            return false; // <== returning false will cancel the default action
				        }
				    }
				}*/
            }
        },
        tooltip: {
	    	enabled: false
	    },
        series: [{
        	ignoreHiddenPoint: true,
	        name: '比例',
	        data: data,
	        startAngle: -90,
            animation: {
                duration: 2000
            }
	    }]
	});
}

function barchart( chartDivId, dataset, xAxisNames, yAxisTitle, chartTitle, barMaxNum, titleXshift ) {
    
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
            text: chartTitle,
            verticalAlign: 'bottom',
            x: titleXshift,
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
            },
            labels: {
                y: 25,
                useHTML: true,
                style: {
					//fontWeight: 'bold',
					fontSize: '12px'
				},
				formatter: function() {
                    return '<div class="inlinebox" style="width:65px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'+
                        this.value +'</div>';
                }
            }
        },
        yAxis: {
            lineWidth: 1,
            startOnTick: true,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            },
            labels: {
                y: 5
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
        	//enabled: false
        },
        legend: {
            enabled: false,
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                pointWidth: 22,
                borderWidth: 0
            }
        },
        series: [{
            type: 'column',
            name: yAxisTitle,
            data: dataset,
            xAxis: 0
        }]
    });
    
}
</script>
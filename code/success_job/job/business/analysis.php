<?php
$business_status = array( '報價', '開案', '出貨', '流標' );
$classPoC = array('產品', '客戶');
$rclassPoC = array('客戶', '產品');

$classes = array('business_product_proposal_standard', 'business_client_name');
$rclasses = array('business_client_name', 'business_product_proposal_standard');

$sdate = date('Y-m-d 00:00:00', strtotime($_POST['sdate']));
$edate = date('Y-m-d 23:59:59', strtotime($_POST['edate']));

try {
    $getList_query = 'SELECT `'.$rclasses[$_POST['classPoC']].'` AS `name`, `business_product_price` AS `price`, `business_product_require_amount` AS `amount`, `business_product_cost` AS `cost` FROM `businesses` WHERE `user_id`=? AND `business_status`=? AND `'.$classes[$_POST['classPoC']].'`=? AND (`created_datetime` BETWEEN ? AND ? )  ';
    $getList_params = array( $_SESSION['userid'], $_POST['selectedStatus'], $_POST['namePoC'], $sdate, $edate );
    $getList = $dbh->prepare( $getList_query );
    $getList->execute( $getList_params );
    $list = $getList->fetchAll(PDO::FETCH_ASSOC);
}
catch (PDOException $e) {
    ob_end_clean();
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
/*
 Group by name
*/
$PoC_list = array();
foreach( $list as $PoC ) {
	if( !isset( $PoC_list[ $PoC['name'] ] ) ) {
		$PoC_list[ $PoC['name'] ] = array( 'total_turnover' => $PoC['price']*$PoC['amount'],
										   'total_cost' => $PoC['cost']*$PoC['amount'] );
		$PoC_list[ $PoC['name'] ]['total_net'] = $PoC_list[ $PoC['name'] ]['total_turnover'] - $PoC_list[ $PoC['name'] ]['total_cost'];
		continue;
	}
	$PoC_list[ $PoC['name'] ]['total_turnover'] += $PoC['price']*$PoC['amount'];
	$PoC_list[ $PoC['name'] ]['total_cost'] += $PoC['cost']*$PoC['amount'];
	$PoC_list[ $PoC['name'] ]['total_net'] += $PoC_list[ $PoC['name'] ]['total_turnover'] - $PoC_list[ $PoC['name'] ]['total_cost'];

}

function changeNumberUnit( $num ) {
    /*if( $num > 999 && $num < 1000000 ) {
        return ($num / 1000).'k';
    }
    elseif( $num > 999999 ) {
        return ($num / 1000000).'m';   
    }*/
    //return substr(money_format('%.0n', $num), 1);
    return number_format($num);;
}
?>

<script type="text/javascript">
$(function(){
	var PoCnames = [ <?php 
		$i = 0;
		foreach( $PoC_list as $name => $PoC ) { echo "'".$name."'"; if( $i != count($PoC_list)-1 ) { echo ","; } $i++; } 
	?> ];
	var PoCturnovers = [ <?php 
		$i = 0;
		foreach( $PoC_list as $name => $PoC ) { echo $PoC['total_turnover']; if( $i != count($PoC_list)-1 ) { echo ","; } $i++; } 
	?> ];
	var PoCcosts = [ <?php 
		$i = 0;
		foreach( $PoC_list as $name => $PoC ) { echo $PoC['total_cost']; if( $i != count($PoC_list)-1 ) { echo ","; } $i++; } 
	?> ];
	var PoCnets = [ <?php 
		$i = 0;
		foreach( $PoC_list as $name => $PoC ) { echo $PoC['total_net']; if( $i != count($PoC_list)-1 ) { echo ","; } $i++; } 
	?> ];
    <?php if( count($list) > 0 ) { ?>
    sales_ratio( 'sales_ratio', PoCnames, PoCturnovers );

	if( PoCnames.length < 3 ) {
		for(var i=0 ; i< 3-PoCnames.length ; i++) {
			PoCnames.push(' ');
			PoCturnovers.push(0);
			PoCcosts.push(0);
		}
	}
	profitchart( 'sales_analysis', ['營業額', '成本', '淨利'], [PoCturnovers, PoCcosts], PoCnames, '(單位：千元）', '<?php echo $rclassPoC[ $_POST['classPoC'] ];?>銷售分析', 3, true );
    <?php } ?>    
});
</script>

<table cellspacing='0' class="business_table data_table center" style="width: 873px; border-radius: 3px 3px 0 0;">
	<thead>
		<tr>
			<td style="border-radius: 3px 0 0 0; width: 172px; padding-left: 27px;">
				<?php echo $classPoC[ $_POST['classPoC'] ]; ?> : <?php echo $_POST['namePoC']; ?> <!--<input type="text" style="width: 94px; height: 21px; line-height: 21px; border: 1px solid #c3c3c3; text-align: center;" value="<?php echo $_POST['namePoC']; ?>" readonly/>-->
			</td>
            <td style="width: 398px;">
            	狀態 : <?php echo $business_status[ $_POST['selectedStatus'] ]; ?>
                &nbsp;&nbsp;
                日期 : 
                <?php 
                	echo $_POST['sdate'].' ~ '.$_POST['edate'];
                ?>
            </td>
			<td style="border-radius: 0 3px 0 0; width: 302px; text-align: right;">
			<?php 
            foreach( $sas[ $ma ] as $subaction => $subaction_name ) {
                if( $subaction != 'opportunities' ) {
            ?>
                <a href="javascript:;" class="<?php echo $subaction; if($sa == $subaction) echo ' on'; ?> button"><?php echo $subaction_name; ?></a>    
            <?php
                    continue;
                }
            ?>
                <a href="?dept=job&ma=business&sa=<?php echo $subaction; ?>" class="<?php if($sa == $subaction) echo 'on'; ?> button"><?php echo $subaction_name; ?></a>
            <?php
            }
            ?>
			</td>
		</tr>
	</thead>
</table>
<?php if( count($list) > 0 ) { ?>
<div>
    <div id="sales_ratio" class="inlinebox" style="height: 320px; width: 460px; margin-left: 190px; margin-top: 30px;"></div>
</div>
<div>
    <div id="sales_analysis" class="inlinebox" style="height: 320px; width: 600px; margin-left: 40px;"></div>
</div>
<div style="width: 800px; border: 1px solid #a3a3a3; margin-left: 55px;">
    <table id="PoC-table">
    	<thead>
    		<tr>
    			<td><div><?php echo $rclassPoC[ $_POST['classPoC'] ]; ?></div></td>
    			<td><div>售價</div></td>
    			<td><div>數量</div></td>
    			<td><div>成本</div></td>
    			<td><div>利潤</div></td>
    			<td><div>淨利</div></td>
    			<td><div>營業額</div></td>
    		</tr>
    	</thead>
    	<tbody>
    	<?php
    	foreach( $list as $PoC ) {
    	?>
    	<tr>
    		<td><div><?php echo $PoC['name']; ?></div></td>
    		<td><div title="<?php echo $PoC['price']; ?>"><?php echo changeNumberUnit( $PoC['price'] ); ?></div></td>
    		<td><div title="<?php echo $PoC['amount']; ?>"><?php echo changeNumberUnit( $PoC['amount'] ); ?></div></td>
    		<td><div title="<?php echo $PoC['cost']; ?>"><?php echo changeNumberUnit( $PoC['cost'] ); ?></div></td>
    		<td><div><?php printf("%.1f", (($PoC['price']-$PoC['cost'])/$PoC['price'])*100 ); echo "%"; ?></div></td>
    		<td><div title="<?php echo ($PoC['price']-$PoC['cost'])*$PoC['amount']; ?>"><?php echo changeNumberUnit( ($PoC['price']-$PoC['cost'])*$PoC['amount'] ); ?></div></td>
    		<td><div title="<?php echo $PoC['price']*$PoC['amount']; ?>"><?php echo changeNumberUnit( $PoC['price']*$PoC['amount'] ); ?></div></td>
    	</tr>
    	<?php
    	}
    	?>
    	</tbody>
    </table>
</div>
<div style="text-align: center; width: 560px; margin-top: 15px; margin-left: 55px;"><?php echo $rclassPoC[ $_POST['classPoC'] ];?>銷售總表</div>

<script src="js/charts/highstock.js"></script>
<script src="js/charts/highcharts-more.js"></script>
<script src="js/charts/chartslib.js"></script>
<?php }
      else {
?>
<div style="margin-top: 48px; text-align:center; font-size: 16px;">沒有符合條件的資料可用來統計分析</div>
<?php
      } 
?>
<script type="text/javascript">
$(function() {
    $('.search').on('click', function() { search(); });
    $('.analysis').on('click', function() { analysis(); });
});
</script>

<script type="text/javascript">
function search() {
    var title = '<div class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 14px; height: 24px;"><b>查詢商機</b></div>';
    var form = $.ajax({
        type: 'GET',       
        url: "job/business/business_cpts/search_form.html",
        dataType: 'html',
        global: false,
        async:false,
        success: function(data) {
            return data;
        }
    }).responseText;

    var result;

    $.confirm({
        'title'     : title,
        'content'   : form,
        'width'     : '330',
        'position'  : 'absolute',
        'offset'    : (document.body.offsetWidth / 2) - 105,
        'voffset'   : 300,
        'unmask'    : false,
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() {
            $('.start-date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 22, horizontalOffset: 0 });
            $('.end-date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 22, horizontalOffset: 0 });
            $('.start-date').on( 'dpClosed', function(e, selectedDates) {
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        $('.end-date').dpSetStartDate(d.addDays(0).asString());
                    }
            });
            $('.end-date').on( 'dpClosed', function(e, selectedDates) {
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        $('.start-date').dpSetEndDate(d.addDays(0).asString());
                    }
            });
        },
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'nextAction' : function() { showSearchSearchResult( result ); /*alert( result.resultTable );*/ },
                'action': function(){
                    var params = [];
                    var test = '';
                    $('#search-form input').each(function() {
                        var tclass = $(this).prop('class').split(/\s+/);
                        tclass = tclass[0].replace(/search-/,'');
                        var tvalue = $.trim( $(this).val() );

                        params.push( { 'name': tclass, 'value': tvalue } );
                    });
                    params.push( { 'name': 'status', 'value': $('#search-form .search-status').val() } );
                    $.ajax({
                        type: 'POST',       
                        url: "job/business/business_functions/opportunities/opportunities_searching.php",
                        data: params,
                        dataType: 'json',
                        global: false,
                        async:false,
                        success: function(data) {
                            result = data;
                            return data;
                        }
                    });
                    return true;
                }
            }
        }
    });
}

function showSearchSearchResult( result ) {
    var title = '<div class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 14px; height: 24px;"><b>查詢結果</b></div><div class="inlinebox" style="position: relative; top: 4px; left:65px; font-size: 14px; height: 24px;"><b>共計 '+result.num+' 筆</b></div>';
    $.confirm({
        'title'     : title,
        'content'   : result.resultTable,
        'width'     : 750,
        'position'  : 'absolute',
        'offset'    : (document.body.offsetWidth / 2) - 256,
        'voffset'   : 280,
        'unmask'    : false,
        //'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() {
            $('.search-results .data-row').on('click', function() {
                var form = ['<form id="searchFor" method="post" action="?dept=job&ma=business&sa=opportunities">','<input type="hidden" name="searchFor" value="',$(this).find('.b_no').text(),'" />','</form>'].join('');
                $('body').append(form);
                $('#searchFor').submit();
            });
        },
        'buttons'   : false
    });

}

function analysis() {
    var title = '<div class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 14px; height: 24px;"><b>銷售分析</b></div>';
    var form = $.ajax({
        type: 'GET',       
        url: "job/business/business_cpts/analysis_form.html",
        dataType: 'html',
        global: false,
        async:false,
        success: function(data) {
            return data;
        }
    }).responseText;

    $.confirm({
        'title'     : title,
        'content'   : form,
        'width'     : '330',
        'position'  : 'absolute',
        'offset'    : (document.body.offsetWidth / 2) - 105,
        'voffset'   : 300,
        'unmask'    : false,
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() {
            $('.start-date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 22, horizontalOffset: 0 });
            $('.end-date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 22, horizontalOffset: 0 });
            $('.start-date').on( 'dpClosed', function(e, selectedDates) {
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        $('.end-date').dpSetStartDate(d.addDays(0).asString());
                    }
            });
            getListOfPoC(0, 0);
        },
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'action': function(){
                    if( $.trim($('.list').val()) == '' || $.trim( $('.start-date').val() ) == '' || $.trim( $('.end-date').val() ) == '' ) {
                        $('.warningbox').fadeOut(50).fadeIn(100);
                        return false;
                    }
                    var form = ['<form id="analysisFor" method="post" action="?dept=job&ma=business&sa=analysis">',
                                    '<input type="hidden" name="selectedStatus" value="',$.trim($('.selectedStatus').val()),'" />',
                                    '<input type="hidden" name="classPoC" value="',$.trim($('.classPoC').val()),'" />',
                                    '<input type="hidden" name="namePoC" value="',$.trim($('.list').val()),'" />',
                                    '<input type="hidden" name="sdate" value="',$.trim($('.start-date').val()),'" />',
                                    '<input type="hidden" name="edate" value="',$.trim($('.end-date').val()),'" />',
                                '</form>'].join('');
                    $('body').append(form);
                    $('#analysisFor').submit();
                    return true;
                }
            }
        }
    });
}

function changeList() {
    var selectedStatus = $('.selectedStatus').val();
    var classPoC = $('.classPoC').val();
    getListOfPoC( selectedStatus, classPoC );
}

// Get list of Product or Client
function getListOfPoC( selectedStatus, classPoC ) {
    $.ajax({
        type: 'POST',       
        url: "job/business/business_functions/opportunities/opportunities_analysis.php",
        data: { 'status': selectedStatus, 'class': classPoC },
        dataType: 'json',
        global: false,
        async:false,
        success: function(data) {      
            $('.list').html('');   
            for( var key in data.list ) {
                $('.list').append('<option>'+data.list[key].name+'</option>');
            }
            return true;
        }
    });
}
<?php if( count($list) > 0 ) { ?>
function sales_ratio( chartDivId, PoCname, PoCvalue ) {

	//Default 10 Colors
	var sliceColors = ['#DE5314', '#E9C018', '#8BC200', '#397DC8', '#BF54C3', 
        	    	   '#ABABAC', '#953329', '#50AF72', '#E17D14', '#7D7D7D'];
	//If data items more than 10, random create not repeated colors
    if( PoCvalue.length > 10 ) {
    	for( var i = 0 ; i < PoCvalue.length - 10 ; i++ ) {
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

	var data = [];
	for( var i in PoCname ) {
		data.push( [ PoCname[ i ], PoCvalue[ i ] ] );
	}

	chart = new Highcharts.Chart({
		chart: {
            renderTo: chartDivId,
            type: 'pie',
            events: {
                load: function(event) {
                	$('#'+chartDivId).find('.item:odd').css('background-color', '#CDE5FF');
                	if( navigator.userAgent.match(/Windows NT/i) && !navigator.userAgent.match(/msie/i) ) {
                        $('#'+chartDivId).find('div.item-name').css('padding-top', '2px');
                   }
                }
            }
        },
        credits:{
            enabled: false
        },
        colors : chartColors,
        title : {
        	text: '<?php echo $rclassPoC[ $_POST['classPoC'] ];?>銷售比例',
        	verticalAlign: 'bottom',
        	x: -80,
        	y: -20
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
			borderWidth: 1,
			useHTML: true,
			margin: 50,
			y: -20,
			labelFormatter: function() {
				return '<div class="item"><div class="inlinebox item-name" style="width: 60px; padding-left: 5px; height: 18px; line-height; 18px; vertical-align: middle; padding-top: 3px\\9; font-size: 12px; font-family:\'\\9ED1\\4F53\';">'+ this.name + '</div><div class="inlinebox" style="width: 60px; padding-right: 5px; height: 18px; line-height; 18px; font-size: 12px; text-align: right; vertical-align: middle;">' + parseFloat(Math.round(this.percentage*100))/100 + '%</div></div>';
			}
        },
        plotOptions: {
            pie: {
                allowPointSelect: false,
                cursor: 'pointer',
                showInLegend: true,
                borderWidth: 0,
                size: 220,
                center: [120, 110],
                dataLabels: {
                    enabled: false
                }
            }
        },
        tooltip: {
	    	enabled: false
	    },
        series: [{
	        name: '比例',
	        data: data,
	        startAngle: -90,
            animation: {
                duration: 2000
            }
	    }]
	});
}
<?php } ?>
</script>
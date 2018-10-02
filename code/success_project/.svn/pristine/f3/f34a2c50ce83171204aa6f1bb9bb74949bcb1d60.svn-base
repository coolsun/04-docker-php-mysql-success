<?php
/*
 Some variables you can use.

 1. $account_types = array( '銀行帳戶', '信用卡', '投資帳戶', '資產', '貸款' );
 	The index of each element of this array are the params for backend.

 2. $months_last_dates = array( (int)time, ... );
    If $d as the element of $months_last_dates, you can use it with date(), ex: date('Y/m/t', $d).

 3. $all_accounts = array(
 		// account type index
 		0 => array(
 			// account id index
 			1 => array( 'aname' => 'XX銀行', 'balances' => array( '--', 5000, ... ) ),
 			9 => array( ... ),
 		),
 		1 => ...
 	);
 	All accounts of this user and some column values for this page.

 4. $p_subtotal_monthly = array( 12345, '--', 150.9, ... );
    Subtotal of bank/invest/asset account types.

 5. $n_subtotal_monthly = array( 111, 222, '--', ... );
    Subtotal of credit/loan account types.

 6. $sum_monthly = array( 12234, -222, 150.9, ... );
    Total of all account types.

 */
?>

<div style="display:none;">
	<a id="selfLastDate_trigger" href="#selfLastDate_dialog" style="display:none;" >#</a>
	<div id="selfLastDate_dialog">
        <div class='page-outer' style='width: 250px; height: 120px; overflow: hidden;'>
            <div class='normal-inner'>
            	<form id="user_form" actino="?dept=finance&ma=accounts&sa=details" method="post">
                <table class='distance-table' style="height:90px;">
                <input id="ac_id_0" type="hidden" value="">
                <tr>
                    <td>
                        <div class="fancy_input_name">開始日期</div>
                        <input class="input-numbers pick-Date" type="text" value="" id="user_selfLastDate" name="selfLastDate" style="width: 85px;"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">往前返回</div>
                        <select id="user_selectedDuring" name="selectedDuring" style="width: 85px;">
                            <option value="0">一年</option>
                            <option value="1">半年</option>
                        </select>
                    </td>
                </tr>
                </table>
                <input type="hidden" id="user_interval" name="interval" value="">
                </form>
            </div>
            <div id="primary-action">
                <input class="btn func-btn" type="button" onclick="update()" value="確 定"></input>
            </div>
        </div>
    </div>
</div>

<div class='log-inner'>
    <div class='log-switch'>
    <form id="select_form" action="?dept=finance&ma=accounts&sa=details" method="post">
        <ul class='period'>
            <li>
            	<?php /* Select element of during */ ?>
            	<select id="selectedDuring" name="selectedDuring">
            		<?php foreach ( $durings as $index => $during ): ?>
            			<option value="<?=$index?>" <?=($index==$selectedDuring) ? 'selected' : '' ?>><?=$during?></option>
            		<?php endforeach; ?>
            		<option value="user_time">自訂</option>
            	</select>
            </li>
            <li>
            	<?php /* Select element of interval */ ?>
            	<select id="interval" name="interval">
            		<?php foreach ( $intervals as $index => $interval ): ?>
            			<option value="<?=$index?>" <?=($index==$selectedInterval) ? 'selected' : '' ?>><?=$interval?></option>
            		<?php endforeach; ?>
            	</select>
            </li>
        </ul>
    </form>
        <ul class='menu'>
        	<?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
        		<li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
        	<?php endforeach; ?>
        </ul>
    </div>

<?php
$row_width = (count($months_last_dates)*80)+180;
?>

<?php /* Account list (Positive) */ ?>

<div id="detail_top_block" class="detail_top_block">
	<div class="detail_row" style="width:<?=$row_width+50?>px;">
<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;"><b>資產結餘</b></span>

<?php foreach ( $months_last_dates as $d ): ?>
	<?='<span class="detail_span" style="font-size:12px;">'.date('Y/m/t', $d).'</span>'?>
<?php endforeach; ?>
</div>
</div>

<div id="detail_block" class="detail_block">
<?php foreach ( $all_accounts as $t => $as ): ?>
	<?php if ( !in_array( $t, array(0, 2, 3) ) ) continue;  ?>
<div class="detail_row" style="width:<?=$row_width?>px;">
<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;"><b><?=$account_types[$t]?></b></span>
</div>
	<?php foreach ( $as as $id => $a ): ?>
		<div class="detail_row" style="width:<?=$row_width?>px;">
			<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;" title="<?=$a['aname']?>"><?=$a['aname']?></span>
			<?php foreach ( $a['balances'] as $b ): ?>
				<span class="detail_span<?php if ($b<0) echo ' negative'; ?>"><?=(is_numeric($b))?number_format($b):$b?></span>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
<div class="detail_row" style="width:<?=$row_width?>px;"><span class="detail_span"> </span></div>
<?php endforeach; ?>
<div class="detail_row" style="width:<?=$row_width?>px;">
	<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;"><b>小　　計</b></span>
	<?php foreach ( $p_subtotal_monthly as $b ): ?>
	<span class="detail_span<?php if ($b<0) echo ' negative'; ?>" style="font-weight:700;"><?=(is_numeric($b))?number_format($b):$b?></span>
	<?php endforeach; ?>
</div>

<?php /* Account list (Negative) */ ?>
<div class="detail_row" style="width:<?=$row_width?>px;"><span class="detail_span"> </span></div>
<div class="detail_row" style="width:<?=$row_width?>px;">
<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;"><b>負債結餘</b></span>
</div>

<?php foreach ( $all_accounts as $t => $as ): ?>
	<?php if ( !in_array( $t, array(1, 4) ) ) continue;  ?>
<div class="detail_row" style="width:<?=$row_width?>px;">
<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;"><b><?=$account_types[$t]?></b></span>
</div>

	<?php foreach ( $as as $id => $a ): ?>
		<div class="detail_row" style="width:<?=$row_width?>px;">
			<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;"title="<?=$a['aname']?>"><?=$a['aname']?></span>
			<?php foreach ( $a['balances'] as $b ): ?>
				<span class="detail_span<?php if ($b>0) echo ' negative'; ?>"><?=(is_numeric($b))?number_format(0-$b):$b?></span>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
<div class="detail_row" style="width:<?=$row_width?>px;"><span class="detail_span"> </span></div>
<?php endforeach; ?>
<div class="detail_row" style="width:<?=$row_width?>px;">
	<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;"><b>小　　計</b></span>
	<?php foreach ( $n_subtotal_monthly as $b ): ?>
	<span class="detail_span<?php if ($b>0) echo ' negative'; ?>" style="font-weight:700;"><?=(is_numeric($b))?number_format(0-$b):$b?></span>
	<?php endforeach; ?>
</div>
<div class="detail_row" style="width:<?=$row_width?>px;"><span class="detail_span"> </span></div>
<div class="detail_row" style="width:<?=$row_width?>px;">
	<span class="detail_span" style="text-align:left; padding-left:16px; width:100px;">淨　　值</span>
	<?php foreach ( $sum_monthly as $b ): ?>
	<span class="detail_span<?php if ($b<0) echo ' negative'; ?>"><?=(is_numeric($b))?number_format($b):$b?></span>
	<?php endforeach; ?>
</div>

</div>

</div>

<script type="text/javascript" src="finance/js/number_format.js"></script>
<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<link href="js/datePicker/datePicker.css" rel="stylesheet" />
<script type="text/javascript">
	$(document).ready(function() {
		$('.pick-Date').datePicker({
		    startDate: '1991/01/01',
		    endDate: (new Date()).asString(),
		    clickInput: true,
		    createButton: false,
		    showYearNavigation: false,
		    verticalOffset: -1,
		    horizontalOffset: 165
		});

		$("#selectedDuring").on("change",function(){
			if ($(this).val()=='user_time') {
				$("#selfLastDate_trigger").click();
			} else {
				$("#select_form").submit();
			};
		});

		$("#interval").on("change",function(){
			if ($(this).val()=='user_time') {
				$("#selfLastDate_trigger").click();
			} else {
				$("#select_form").submit();
			};
		});

		$("#selfLastDate_trigger").fancybox({
	        'type': 'inline',
	        'title': '期間',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

        $("#detail_block").scroll(function() {
            $("#detail_top_block").scrollLeft($("#detail_block").scrollLeft());
        });

	    $('#detail_block').css('height',$(window).height()).css('height', '-=230px');
	});

	function update(){
		$.fancybox.close();
		$('#user_interval').val($('#interval').val());
		$("#user_form").submit();
	};


</script>
<?php
/*
 Some variables you can use.
 1. (PHP) $all_accounts = array(
 	array(
 		'id' => 1,
 		'name' => 'xx帳戶'
 	)
 )
 */

// if (isset($_COOKIE["account"]) && !isset($_POST['account'])) {
// 	$selected_aid = $_COOKIE["account"];
// }
?>

<div style="display:none;">
	<a id="alert_show" href="#alert_window" style="display:none;" >#</a>
	<div id="alert_window">
        <div class='page-outer' style='width: 250px; height: 95px;'>
            <div class='normal-inner'>
            	<p id="alert_msg"></p>
            </div>
            <div id="primary-action">
                <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定"></input>
            </div>
        </div>
    </div>
    <a id="savings_show" href="#savings_count" style="display:none;" >#</a>
    <div id="savings_count">
        <div class='page-outer' style='width: 320px; height: 160px;'>
            <div class='normal-inner'>
                <form id="form_savings">
                <table class='distance-table'>
                <tr>
                    <td>
                        <div class="fancy_input_name" style="width:100px;">目標存款金額</div>
                        <input class="input-numbers" type="text" value="" id="saving_num" name="saving_num" required style="width: 100px;"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name" style="width:100px;">預計達成日期</div>
                        <div id="savings_date" class="fancy_input_name" style="margin-left: 15px;">2016/03/30</div>
                    </td>
                </tr>
                </table>
                </form>
            </div>
            <div id="primary-action">
                <input id="savings_btn" class="btn func-btn" type="button" onclick="ajax_count()" value="計 算"></input>
            </div>
        </div>
    </div>
</div>

<div class='log-inner'>
	<form id="post_form" method="post" action="?dept=finance&ma=saving&sa=statics">
    <div class='log-switch' style="border-bottom-width: 0px; border-right-width: 2px;">
    	<ul class="period" style="left:0px;">
    		<?php /* Select element of during */ ?>
    		<li>
	        <select id="all_accounts" class="form_select" name="account">
			<?php foreach ( $all_accounts as $atype => $accounts ): ?>
				<optgroup label="<?=$account_types[$atype]?>">
				<?php foreach ( $accounts as $account ): ?>
					<option value="<?=$atype.'-'.$account['account_id']?>"  <?=( $atype == $selected_atype && $account['account_id'] == $selected_aid ) ? 'selected' : '' ?>><?=$account['account_name']?></option>
				<?php endforeach; ?>
				<?php setcookie("account", $selected_aid);?>
				</optgroup>
			<?php endforeach; ?>
			</select>
	        </li>
	        <li>
	        <?php /* Select element of during */ ?>
			<select id="selectedDuring" class="form_select" name="selectedDuring">
			<?php foreach ( $durings as $index => $during ): ?>
				<option value="<?=$index?>" <?=($index==$selectedDuring) ? 'selected' : '' ?>><?=$during?></option>
			<?php endforeach; ?>
			</select>
	        </li>
    	</ul>
        <ul class='menu' style="right: 70px;">
        	<?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
        		<li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
        	<?php endforeach; ?>
        </ul>
    </div>
	</form>
</div>

<?php /* div container for chart */ ?>
<div id="chart" style="width:95%; padding-top: 50px;"></div>

<script type="text/javascript" src="finance/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="finance/js/additional-methods.min.js"></script>
<script type="text/javascript" src="finance/js/number_format.js"></script>
<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<link href="js/datePicker/datePicker.css" rel="stylesheet" />
<script type="text/javascript">

	$(document).mouseup(function (e)
    {
		
    });

	$(function(){
		$(".form_select").on("change",function(){
			$("#post_form").submit();
		});

		$("#alert_show").fancybox({
		    'type': 'inline',
		    'title': '',
		    'padding' : 0,
		    'titlePosition'     : 'outside',
		    'transitionIn'      : 'none',
		    'transitionOut'     : 'none',
		    'overlayShow'       : false
		});

		$("#savings_show").fancybox({
	        'type': 'inline',
	        'title': $( "#all_accounts option:selected" ).text(),
	        'padding' : 0,
	        'onStart' : function() {
	        	$('#saving_num').val('');
	        	$("#savings_date").text('');
	        	$("#savings_btn").show();
            },
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });
	});

//================================================================================
//
//
//          #####        #    #        ##   #        #####
//          #            #    #        # #  #        #
//          #####        #    #        #  # #        #
//          #            #    #        #   ##        #
//          #            ######        #    #        #####
//
//
//================================================================================
	function ara_alert(msg) {
		$('#alert_msg').html(msg);
		$("#alert_show").trigger('click');
	}

	function show_count() {
		$("#savings_show").trigger('click');
	}

	function ajax_count() {
		var data = $("#all_accounts").val().split("-");

		var json_str = JSON.stringify({
			'aid': data[1],
			'atype': data[0],
			'money': $('#saving_num').val()
		});

		$.ajax({
			url: 'finance/saving/saving_functions/statics/compute.php',
			data: { "data": json_str },
			type: 'post',
			dataType: "json",
			success: function(data) {
				console.log(data);
				if (data.status == false) {
					ara_alert(data.emsg);
				} else {
					$("#savings_btn").hide();
					$("#savings_date").text(data.date);
				};
			},
			error: function() {
				console.log('error');
			}
		});
	};
</script>
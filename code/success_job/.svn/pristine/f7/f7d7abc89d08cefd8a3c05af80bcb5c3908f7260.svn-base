<?php
/*
 Indexs
*/
$job_status = array('未開始',  '執行中', '已完成', '延遲');
$job_priorities = array('高', '中', '低');
$job_priorities_icons = array('square', 'circle', 'triangle');
$durings = array('7天' => 7 , '14天' => 14 ,  '30天' => 30);
$Months = array('1' => '一月', '2' => '二月', '3' => '三月', '4' => '四月', '5' => '五月', '6' => '六月',
			    '7' => '七月', '8' => '八月', '9' => '九月', '10' => '十月', '11' => '十一月', '12' => '十二月');
$Days = array('Sun' => '日', 'Mon' => '一', 'Tue' => '二', 'Wed' => '三', 'Thu' => '四', 'Fri' => '五', 'Sat' => '六');
$ampm = array('AM' => '上午', 'PM' => '下午');

// Post-Redirect-Session
if( isset($_POST['startDate']) ) {
    $_SESSION['startDate'] = $_POST['startDate'];
    // Redirect to this page.
    ob_end_clean();
	header("Location: " . $_SERVER['REQUEST_URI']);
	exit();
}
else {
	$_POST['startDate'] = $_SESSION['startDate'];
    unset( $_SESSION['startDate'] );
}

// Default start dateis today
if( !$_POST['startDate'] ) {
	$_POST['startDate'] = date('Y/m/d');
}

$startDate = $_POST['startDate'];
$endDate = date('Y-m-d', strtotime($startDate.' +6 day'));

/*
 Get jobs
*/
$query_jobs_sql = 'SELECT `job_id`, `job_title`, `job_priority`, `job_start_date`, `job_end_date` FROM `jobs` WHERE `user_id` = ? AND (`job_start_date` BETWEEN ? AND ?) OR (`job_end_date` BETWEEN ? AND ?) OR (`job_start_date` < ? AND `job_end_date` > ? ) ';
$query_jobs_params = array($_SESSION['userid'], $startDate, $endDate, $startDate, $endDate, $startDate, $endDate);

// Order jobs from new to old
$query_jobs_sql .= 'ORDER BY `created_datetime` DESC';

$query_jobs = $dbh->prepare( $query_jobs_sql );
$query_jobs->execute( $query_jobs_params );

$job_dataset = $query_jobs->fetchAll(PDO::FETCH_ASSOC);

$job_ids = '';
if( count($job_dataset) ) {
    foreach( $job_dataset as $job ) {
        $job_ids .= $job['job_id'] .",";
    }
    $job_ids = substr($job_ids, 0, strlen($job_ids)-1);
}
//echo $job_ids;

if( count($job_dataset) ) {
	$query_subjobs = $dbh->prepare('SELECT `subjob_id`, `parent_job_id`, `subjob_title`, `subjob_priority`, `subjob_start_date`, `subjob_end_date` FROM `subjobs` WHERE `user_id` = ? AND `parent_job_id` IN ( '. $job_ids .' )');
	$query_subjobs->execute(array($_SESSION['userid']));
	$subjob_dataset = $query_subjobs->fetchAll(PDO::FETCH_ASSOC);

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

/*
 Integrate data of jobs
*/
$jobsInDates = array();
for( $i = 0 ; $i < 7 ; $i++ ) {
	$date = date('Y-m-d', strtotime($startDate.' +'.$i.' day'  ));
	$jobsInDates[ $date ] = array();
	foreach( $job_dataset as $job ) {
		if( strtotime( $job['job_start_date'] ) <= strtotime( $date ) && strtotime( $job['job_end_date'] ) >= strtotime( $date ) ) {
			$job['job_priority'] == 0 ? $highlight = true : $highlight = false;
			array_push($jobsInDates[ $date ], array( 'title' => $job['job_title'], 'icon' => $highlight, 'type' => 'job' ) ) ;
		}
		if( isset( $subjob_dataset[ $job['job_id'] ] ) ) {
			foreach( $subjob_dataset[ $job['job_id'] ]  as $subjob ) {
				if( strtotime( $subjob['subjob_start_date'] ) <= strtotime( $date ) && strtotime( $subjob['subjob_end_date'] ) >= strtotime( $date ) ) {
					$subjob['subjob_priority'] == 0 ? $highlight = true : $highlight = false;
					array_push($jobsInDates[ $date ], array( 'title' => $subjob['subjob_title'], 'icon' => $highlight, 'type' => 'subjob' ) ) ;
				}
			}
		}
	}
}

/*
 Get sessions
*/
$query_sessions_sql = 'SELECT `session_id`, `session_title`, `session_date`, `session_start_time`, `session_end_time` FROM sessions WHERE `user_id` = ? AND (`session_date` BETWEEN ? AND ?)  ';
$query_sessions_params = array( $_SESSION['userid'], $startDate, $endDate );

$query_sessions = $dbh->prepare( $query_sessions_sql );
$query_sessions->execute( $query_sessions_params );

$session_dataset = $query_sessions->fetchAll(PDO::FETCH_ASSOC);

$sessionsInDates = array();
for( $i = 0 ; $i < 7 ; $i++ ) {
	$date = date('Y-m-d', strtotime($startDate.' +'.$i.' day'  ));
	$sessionsInDates[ $date ] = array();
	foreach( $session_dataset as $session ) {
		if( strtotime( $session['session_date'] ) == strtotime( $date ) ) {
			array_push($sessionsInDates[ $date ], array( 'sid' => $session['session_id'], 'title' => $session['session_title'], 'sTime' => $session['session_start_time'], 'eTime' => $session['session_end_time'], ) );
		}
	}
}

?>

<script type="text/javascript" src="job/js/placeholders_bak.js"></script>

<table cellspacing='0' class="map_table data_table center" style="width: 873px; border-radius: 3px 3px 0 0;">
	<thead>
		<tr>
			<td colspan="2" style="border-radius: 3px 0 0 0;">
				<form id="date-start-date"  method="post">
					<input id="date-pick-starDate" name="startDate" type="text" style="text-align: center; height: 23px; line-height: 20px\0/; width: 90px;" value="<?php echo $_POST['startDate'] ?>" readonly />
				</form>
			</td>
			<td colspan="2" style="text-align: right;">
				<b><?php echo date('Y', strtotime($startDate)).' '.$Months[ date('n', strtotime($startDate)) ]; ?></b>
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
		<tr class="days">
		<?php
		for( $i = 0 ; $i < 7 ; $i++ ) {
		?>
			<td class="column" style="<?php if(date('D', strtotime($startDate.' +'.$i.' day'  )) == "Sun") echo 'color: #FF1C19;'; if( $i==6 )echo"border-right:none;"; ?>">星期<?php echo $Days[ date('D', strtotime($startDate.' +'.$i.' day'  )) ]; ?></td>	
		<?php	
		}
		?>
		</tr>
		<tr class="dates">
		<?php
		for( $i = 0 ; $i < 7 ; $i++ ) {
		?>
			<td class="column" style="<?php if(date('D', strtotime($startDate.' +'.$i.' day'  )) == "Sun") echo 'color: #FF1C19;'; if( $i==6 )echo"border-right:none;"; ?>"><?php echo date('d', strtotime($startDate.' +'.$i.' day'  )); ?></td>	
		<?php	
		}
		?>
		</tr>
	</thead>
</table>
<div class="map_table_jobs_scrollalbe">
<table class="map_table center" style="width: 873px;">
	<tbody>
		<?php
		$dataRows = 0;
		foreach( $jobsInDates as $jobsInDate ) {
			if( count( $jobsInDate ) > $dataRows ) { $dataRows = count( $jobsInDate ); }
		}
		?>
		<?php
		/*
		 Show jobs in dates
		*/
		for( $i=0 ; $i < $dataRows ; $i++ ) {
		?>
		<tr>
			<?php
			foreach( $jobsInDates as $index => $jobsInDate ) {
			?>
				<td>
					<?php 
						$jobInDate = array_shift( $jobsInDates[ $index ] );
						if( $jobInDate ) { 
							if( $jobInDate['icon'] ) {
					?>	
						<img src="job/img/square.png" style="margin-left: 5px;" /><!--
					<?php
							}
							else{
					?>
						<div class="inlinebox" style="width: 9px; margin-left: 5px;"></div><!--
					<?php
							}
					?>
					 --><div class="inlinebox <?php echo $jobInDate['type']; ?>" title="<?php echo $jobInDate['title']; ?>" style="margin-left: 5px; width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
					<?php
							echo $jobInDate['title'];
						}
						else {
					?>
						<div>&nbsp;
					<?php
						}
					?>
						</div>
					<?php
					?>
				</td>
			<?php
			}
			?>
		</tr>
		<?php
		}
		$padding_row = 19 - $dataRows;
        for( $i = 0; $i < $padding_row ; $i++ ) {
        ?>
        <tr>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		</tr>
        <?php
        }
		?>

	</tbody>
	<tfoot></tfoot>
</table>
</div>
<table class="map_table data_table center" style="width: 873px;">
	<tfoot>
		<tr>
			<td class="column">會議</td><td class="column">會議</td><td class="column">會議</td><td class="column">會議</td><td class="column">會議</td><td class="column">會議</td><td class="column">會議</td>
		</tr>
	</tfoot>
</table>
<div class="map_table_session_scrollalbe">
<table class="map_table center" style="width: 873px;">
	<tbody>
		<?php
		$maxNumSession = 0;
		foreach( $sessionsInDates as $sessionsInDate ) {
			if( count( $sessionsInDate ) > $maxNumSession ) { $maxNumSession = count( $sessionsInDate ); }
		}
		?>
		<tr>
		<?php
		foreach( $sessionsInDates as $index => $sessionsInDate ) {
		?>
			<td class="sessions">
				<div class="sessionDate" style="display: none;"><?php echo $index; ?></div>
			<?php
				$numSession = count( $sessionsInDates[ $index ] );
				foreach( $sessionsInDates[ $index ] as $sessionInDate ) {
			?>
				<div class="session hasSession">
					<div class="deleteSession">x</div>
			<?php
					$time = substr($sessionInDate['sTime'], 0, 5);
					$amorpm = date('A', strtotime($time) );
					$showtime = date('A h:i', strtotime($time) );
					$showtime = $ampm[ $amorpm ].' '.substr( $showtime, 3);
					echo '<div class="sessionid" style="display: none;">'.$sessionInDate['sid'].'</div>';
					echo '<div class="sessionTitle"><input class="session_input session_title_input" type="text" placeholder="會議名稱 ..." value="'.$sessionInDate['title'].'" /></div>';
					echo '<div class="sessionTime">
							<input class="session_input session_time_input" type="text" placeholder="開始時間 ..." value="'.$showtime.'" readonly />
							<span class="timein24" style="display: none;">'.$time.'</span>
						  </div>';
			?>
				</div>
			<?php
				}
				$defaultNumSession = 3;
				if( $maxNumSession > 3 ) { $defaultNumSession = $maxNumSession; }
				if( $numSession <= 3 ) {
					$padding = $defaultNumSession*2 - $numSession*2;
					if( $numSession == 0 ) {
						$defaultNumSession*2 > $padding ? $padding = $maxNumSession*2 : $padding ;
					}
					for( $p = 0 ; $p < $padding ; $p++ ) {
						echo '<div class="session add"><div class="addSession">+</div></div>';
					}
					if( $maxNumSession > 3 ) {
						echo '<div class="session add"><div class="addSession">+</div></div>';
					}
				}
				else if( $numSession > 3 ) {
					echo '<div class="session add"><div class="addSession">+</div></div>';
				}
			?>
			</td>
		<?php
		}
		?>
		</tr>
	</tbody>
	<tfoot></tfoot>
</table>
</div>
<div class="data_table_tail center"></div>
<div class="center" style="padding: 3px 10px;">
		重要性 ： <img src="job/img/square.png" style="margin-right: 3px;" /> 高
</div>

<script src="job/js/jquery-scrollto.js"></script>
<script type="text/javascript">
$(function() {

	Date.firstDayOfWeek = 0;
    Date.format = 'yyyy/mm/dd';
	$('#date-pick-starDate').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 24});
	$('#date-pick-starDate').on( 'dpClosed', function(e, selectedDates) {
		if ( $('#date-pick-starDate').val() != "<?php echo $_POST['startDate'] ?>" )
		{
			$('#date-start-date').submit();	
		}
    });
	
    var numSession = 0;
    $('body').on('click', '.addSession', function() {

    	if( $('#timebox').length ) {
    		$('#confirmBox').remove();
    	}

    	var sessions_container = $(this).parents('.sessions:first');
    	
    	numSession =  sessions_container.find('.hasSession').length * 2 + sessions_container.find('.newSession').length * 2 + sessions_container.find('.add').length;

    	if( sessions_container.find('.newSession').length ) {
    		return false;
    	}
    	else {
	    	$.get('job/plan/plan_cpts/session.html', function( res ) {
	    		sessions_container.find('.session.add:last').remove();
	    		sessions_container.find('.session.add:last').remove();
	    		if( $('.session.newSession').length ) {
	    			$('.session.newSession').remove();
	    		}
	    		if( sessions_container.find('.hasSession').length ) {
	    			sessions_container.find('.hasSession:last').after( res );	
	    			if( sessions_container.find('.hasSession').length > 2 ) {
	    				$('.newSession').ScrollTo({duration: 0,});
	    			}
	    			paddingSessions();
	    		}
	    		else { 
	    			sessions_container.prepend( res );
	    			$('.newSession').ScrollTo({duration: 0,});
	    			paddingSessions();
	    		}
	    	});
    	}
    });
    
});

$('body').on('keyup click', '.hasSession .session_title_input', function(e) {
	var $this = $(this);
	var code = e.which;
	
	$('#confirmBox').remove();

	if(code == 13) {
		if( $.trim( $this.val() ) == '' ) {
			return false;
		}
		var sessionid = $this.parents('.session').find('.sessionid').text();
		var title = $(this).val();
		//alert( title );
		$.ajax({
			type:"POST",
			data: { 'type': 0, data: { 'id': sessionid, 'title': title } },
			url:"job/plan/plan_functions/map/session_updating.php",
			dateType: "json",
			error:function(){
				alert("Failed.");
			},
			success:function( data ){
				if( data.status.match(/^success/) ) {
				}
			}
		});
	}

});

$('body').on('click', '.hasSession .session_time_input', function() {
	var $this = $(this);
	var sessionid = $this.parents('.session').find('.sessionid').text();
	var title = $(this).parents('.session').find('.session_title_input').val(); 
	var date = $(this).parents('.sessions').find('.sessionDate').text();
	var inputPosition = $(this).offset();
	var offsetTop = $(this).parents('.sessions').offset().top;

	$('#confirmBox').remove();

	var timeForm = ['<div id="timebox">',
						'<select class="ampm">','<option value="AM">','上午</option>','<option value="PM">','下午</option>','</select><span style="width: 24px;">&nbsp;</span>',
						'<select class="hour">',
							'<option>','01</option>','<option>','02</option>','<option>','03</option>','<option>','04</option>',
							'<option>','05</option>','<option>','06</option>','<option>','07</option>','<option>','08</option>',
							'<option>','09</option>','<option>','10</option>','<option>','11</option>','<option>','12</option>',
						'</select><span>時</span>',
						'<select class="min">', 
							'<option>','00</option>','<option>','05</option>','<option>','10</option>','<option>','15</option>',
							'<option>','20</option>','<option>','25</option>','<option>','30</option>','<option>','35</option>',
							'<option>','40</option>','<option>','45</option>','<option>','50</option>','<option>','55</option>',
						'</select><span>分</span>',
					'</div>'].join('');
	var voffset_padding = 40;
	var hoffset_padding = 90;

	if( Math.floor(inputPosition.left) + 340  > $('#main-content').offset().left + $('#main-content')[0].offsetWidth ) {
		hoffset_padding =  (Math.floor(inputPosition.left) + 263) - ($('#main-content').offset().left + $('#main-content')[0].offsetWidth) ;
		hoffset_padding *= -1;
	}
	
	$.confirm({
        'title'     : '<b class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 12px; height: 18px;">時間</b>',
        'content'   : timeForm,
        'unmask'    : true,
        'width'     : '340',
        'position'  : 'absolute',
        'offset'    : Math.floor(inputPosition.left)+hoffset_padding,
        'voffset'   : Math.floor(offsetTop)-voffset_padding,
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() {},
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'action': function(){
                	
                	var time = $('#timebox').find('.hour').val() +':'+$('#timebox').find('.min').val() +':00 '+ $('#timebox').find('.ampm').val();
                	$.ajax({
						type:"POST",
						data: { type: 1, data: { 'id': sessionid, 'date': date, 'title': title, 'time': time }  },
						url:"job/plan/plan_functions/map/session_updating.php",
						dateType:"json",
						error:function(){
							alert("Failed.");
						},
						success:function( data ){
							if( data.status.match(/^success/) ) {
								$this.val(data.time);
							}
						}

					});

					return true;
                }
            }
        }
    });
	
});

$('body').on('click', '.deleteSession', function() {
	var session = $(this).parents('.session');
	var sessionid = session.find('.sessionid').text();
	
	$('#confirmBox').remove();

	$.ajax({
		type:"POST",
		data: { id: sessionid  },
		url:"job/plan/plan_functions/map/session_deleting.php",
		dateType:"json",
		error:function(){
			alert("Failed.");
		},
		success:function( data ){
			if( data.status.match(/^success/) ) {
				session.parents('.sessions').append('<div class="session add"><div class="addSession">+</div></div>');
				session.parents('.sessions').append('<div class="session add"><div class="addSession">+</div></div>');
				session.remove();
				paddingSessions();
			}
		}
	});
});

function paddingSessions() {
				var max = 0;
	    		$('.sessions').each(function() {
	    			var num = $(this).find('.hasSession').length * 2 + $(this).find('.newSession').length * 2 + 1;
	    			if( num > max ) { max = num; }
	    		});

	    		if( max < 7 ) { max = 7; }
	    		//alert(max);
	    		$('.sessions').each(function() {
	    			var num = $(this).find('.hasSession').length * 2 + $(this).find('.newSession').length * 2 + $(this).find('.add').length;
	    			if( num <= max ) { 
	    				for( var i = 0 ; i < max - num ; i++ ) {
	    					$(this).append('<div class="session add"><div class="addSession">+</div></div>');
	    				}
	    			}
	    			else {
	    				for( var i = 0 ; i < num - max ; i++ ) {
	    					$(this).find('.session.add:last').remove();
	    				}
	    			}
	    		});
}
</script>




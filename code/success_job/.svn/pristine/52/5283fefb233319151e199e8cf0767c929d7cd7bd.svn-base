<?php
// Record of last engine result
if( trim($_POST['engine_result']) != '' ) {
	$fid = $_POST['fid'];
	$lid = $_POST['lid'];
	$_POST = unserialize($_POST['engine_result']);
	$_POST['fid'] = $fid;
	$_POST['lid'] = $lid;
	$_POST['hasResult'] = 1;
}

// Post-Redirect-Session
// if( isset($_POST['jobs']) ) {
//     /*$_SESSION['jobs'] = $_POST['jobs'];
//     $_SESSION['main'] = $_POST['main'];
//     $_SESSION['similar'] = $_POST['similar'];
//     $_SESSION['orders'] = $_POST['orders'];
//     $_SESSION['hasResult'] = $_POST['hasResult'];*/
//     $_SESSION['post'] = $_POST;
//     // Redirect to this page.
//     ob_end_clean();
// 		header("Location: " . $_SERVER['REQUEST_URI']);
//     exit();
// }
// else {
//     /*$_POST['jobs'] = $_SESSION['jobs'];
//     $_POST['main'] = $_SESSION['main'];
//     $_POST['similar'] = $_SESSION['similar'];
//     $_POST['orders'] = $_SESSION['orders'];
// 		$_POST['hasResult'] = $_SESSION['hasResult'];*/
//     $_POST = $_SESSION['post'];
//     /*unset( $_SESSION['jobs'] );
//     unset( $_SESSION['main'] );
//     unset( $_SESSION['similar'] );
//     unset( $_SESSION['orders'] );
//     unset( $_SESSION['hasResult'] );*/
// 		unset($_SESSION['post']);
// }

if( count($_POST['jobs']) == 0 ) {
	ob_end_clean();
	header("Location: " . '?dept=job&ma=engine');
	exit();
}

//print_r($_POST);

/*
 Convert html tag
*/
foreach( $_POST as $index => $arg ) {
	if( is_array( $_POST[$index] ) ) {
		foreach( $_POST[$index] as $index2 => $arg2 ) {
			$_POST[$index][$index2] = htmlspecialchars( $_POST[$index][$index2] );
		}
	}
	else {
		$_POST[$index] = htmlspecialchars( $_POST[$index] );
	}
}

/*
 Save result to planning
*/
if( $_POST['hasResult'] == 0 ) {
	$add_jobs_params = array();
	$add_jobs_query = 'INSERT INTO `jobs` (`user_id`, `job_title`, `job_start_date`, `job_end_date`, `created_datetime`) VALUES ';
	foreach( $_POST['orders'] as $index => $order ) {
		$add_jobs_query .= '('.$_SESSION['userid'].', ?, "'.date('Y-m-d').'", "'.date('Y-m-d').'", "'.date('Y-m-d H:i:s').'")';
		if( $index != count($_POST['jobs']) - 1 ) {
			$add_jobs_query .= ', ';
		}
		array_push($add_jobs_params, $_POST['jobs'][$order] );
	}
	$add_jobs = $dbh->prepare( $add_jobs_query );
	$add_jobs->execute( $add_jobs_params );

	$firstJobID = $dbh->lastInsertId();
	$lastJobID = $firstJobID + count($_POST['jobs']) - 1;

	//echo serialize($_POST);
	$save_engine_result = $dbh->prepare('INSERT INTO `engine` (`user_id`, `engine_result`, `first_id`, `last_id`) VALUES('.$_SESSION['userid'].', ?, ?, ?)');
	$save_engine_result->execute( array(serialize($_POST), $firstJobID, $lastJobID) );
}
else {
	$firstJobID = $_POST['fid'];
	$lastJobID = $_POST['lid'];
}

$jobs_ids = array();
for( $id = $firstJobID ; $id < $firstJobID + count($_POST['jobs']) ; $id++ ) {
	array_push($jobs_ids, $id);
}
//print_r($jobs_ids);

/*echo $add_jobs_query."<br>";
print_r($add_jobs_params);*/


/*$_POST = array( 'jobs' => array( 'a', 'b', 'c' ), 
				'main' => array( 'b' ), 
				'similar' => array( 'a', 'c' ), 
				'orders' => array( 0, 2, 1 ) );*/

?>
<div style="width: 596px;">
	<div class="inlinebox">最佳化工作效率</div>
	<a href="job/engine/engine_functions/result/engine_restart.php" class="button" style="float: right; height: 24px; padding-top: 5px; padding-bottom: 5px;">重新啟動</a>
</div>
<br/>
<div class="underline">重要關鍵項目先處理</div>：
<div style="padding-top: 8px;">
<?php
error_reporting(E_ERROR | E_PARSE); // stop null main and similar warning

if( count( $_POST['main'] ) ) {
	foreach( $_POST['main'] as $job_title ) {
	?>
		<div style="padding-left: 20px; height: 20px; line-height: 20px;"><?php echo $job_title; ?></div>
	<?php
	}
}
?>
</div>
<br/>
<div class="underline">相似的工作集中一起做</div>：
<div style="padding-top: 8px;">
<?php
if( count( $_POST['similar'] ) ) {
	foreach( $_POST['similar'] as $job_title ) {
	?>
		<div style="padding-left: 20px; height: 20px; line-height: 20px;"><?php echo $job_title; ?></div>
	<?php
	}
}
?>
</div>
<br/>
<div class="underline">優先處理順序</div>
<br/><br/>
<table id="engine_table" class="data_table engine_result" style="margin: 0px;">
	<thead>
		<tr>
			<td class="column" style="width: 60px; text-align: center; border-right: 1px solid #c3c3c3;">
				順序
			</td>
			<td>
				<div style="text-align: left;">工作項目</div>
			</td>
			<!--<td style="text-aling: right;">
				
			</td>-->
		</tr>
	</thead>
	<tbody>
<?php
foreach( $_POST['orders'] as $index => $order ) {
?>
	<tr class="job-row">
		<td class="order">
			<div class="inlinebox text-hidden"><?php echo ($index+1);?></div>
		</td>
		<td class="job"><!--
		 --><div>
		 		<font class="job_id" style="display: none;"><?php echo $jobs_ids[$index]; ?></font>
				<div class="inlinebox text-hidden" style="width: 380px; padding-right: 20px;">
					<div class="inlinebox text-hidden job_title" style="width:360px;"><?php echo $_POST['jobs'][ $order ];?></div>
				</div><!--
			 --><a href="javascript:;" class="button" style="vertical-align: middle; padding: 0px 12px; height: 24px; line-height: 22px; line-height: 20px\0/;" onClick="changeJobOrder( $(this), 0 );">往上移</a><!--
			 -->&nbsp;<!--
			 --><a href="javascript:;" class="button" style="vertical-align: middle;padding: 0px 12px; height: 24px; line-height: 22px; line-height: 20px\0/;" onClick="changeJobOrder( $(this), 1 );">往下移</a><!--
		 --></div>
		</td>
	</tr>
<?php
}
?>
	<tr class="submit-row">
		<td class="order" style="border-bottom: none;">
			<div class="inlinebox text-hidden">&nbsp;</div>
		</td>
		<td style="text-align: right; padding-right: 6px; border-bottom: none;">
			<a id="submit" href="javascript:;" onClick="reorderJobs();" class="button" style="display: none; vertical-align: middle;padding: 0px 12px; width: 68px; height: 24px; line-height: 22px; line-height: 20px\0/;">確定</a>
		</td>
	</tr>
	</tbody>
</table>
<div class="data_table_tail" style="width:596px;"></div>
<br/>
<div class="underline">管理工作計畫</div>
<br/><br/>
<div>請至"工作計畫"編輯各項工作狀態 ，時程與重要性 ，並持續追蹤直到工作完成</div>

<script type="text/javascript">
var fjob = <?php echo $firstJobID; ?>;
var ljob = <?php echo $lastJobID; ?>;
</script>

<script type="text/javascript">
function changeJobOrder( job, direction ) {
	job = job.parents('tr');
	if( direction == 0 && job.prev().find('.job').length ) {
		/*var tjob = job.clone();
		job.prev().before( tjob );
		tjob.fadeIn(300);
		job.remove();*/
		var tjob = job.find('.job').clone();
		var pjob = job.prev().find('.job').clone();
		job.find('.job').remove();
		job.prev().find('.job').remove();
		job.append( pjob );
		job.prev().append( tjob );
	}
	else if( direction == 1 && job.next().find('.job').length ) {
		var tjob = job.find('.job').clone();
		var njob = job.next().find('.job').clone();
		job.find('.job').remove();
		job.next().find('.job').remove();
		job.append( njob );
		job.next().append( tjob );
	}
	else {
		return false;
	}
	$('#submit').show();
	$('#engine_table tbody td').css('border-bottom', '1px solid #c3c3c3');
	$('#engine_table tbody tr:last td').css('border-bottom', 'none');
	/*$('#engine_table .job > div').css('border-bottom', '1px solid #c3c3c3');
	$('#engine_table .job:last > div').css('border-bottom', 'none');*/
}

function reorderJobs() {
	var jobs = [];
	$('#engine_table .job_id').each(function(n) {
		jobs.push( $(this).text() );
	});
	$.ajax({
		type:"POST",
		data: { 'first': fjob, 'last': ljob, 'jobs': jobs },
		url:"job/engine/engine_functions/result/engine_reorder.php",
		dateType:"json",
		error:function(){
			alert("Failed.");
		},
		success:function( data ){
			if( data.status.match(/^success/) ) {
				$('#submit').hide();
			}
		}

	});
	return false;
}
</script>
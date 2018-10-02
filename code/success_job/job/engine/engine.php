<?php
$check_engine_result = $dbh->prepare('SELECT `engine_result`, `first_id`, `last_id` FROM `engine` WHERE `user_id`=?');
$check_engine_result->execute( array($_SESSION['userid']) );
$result = $check_engine_result->fetch(PDO::FETCH_ASSOC);

if( $check_engine_result->rowCount() ) {
	//$result = $result['engine_result'];
?>
	<form id="result" method="post" action="?dept=job&ma=engine&sa=result">
		<input type="hidden" name="engine_result" value='<?php echo $result["engine_result"]; ?>'/>
		<input type="hidden" name="fid" value='<?php echo $result['first_id']; ?>'/>
		<input type="hidden" name="lid" value='<?php echo $result['last_id']; ?>'/>
	</form>
	<script type="text/javascript">
	$(function() {
		$(window).on('load', function() {
			$('#result').submit();
		});
	});
	</script>
<?php
	exit();	
}
?>

<script type="text/javascript" src="job/js/placeholders_bak.js"></script><!-- For IE8, 9 -->

<div style="position:relative;">
	<div id="engine_step">最佳化工作效率</div>
	<div id="engine_content">
		<div id="engine_plane">
			<form id="job_list">
				<input type="text" class="job_input" name="jobs[]" placeholder="輸入所有你今天要做的事 ......" />
			</form>
			<div style="text-align: right; padding: 0;">
		        <a href="javascript:;" class="picbutton submit_btn" style="margin: 0; margin-top: 25px;" onClick="selectMainJobs( true );">確定</a>
		    </div>
		</div>
	</div>
</div>

<script type="text/javascript">
var jobs_list = [];

$(function(){
    // inital subjob config
    //$('.job_input:last').on('keyup', function(){ addJob(); });
    $('body').on('keyup','.job_input:last', function() { addJob(); } );
});

// Add subjob when click the last subjob input
function addJob() {
    if( $.trim( $('.job_input:last').prop('value') ) != '' ) {
        //$('.job_input:last').unbind('keyup');
        $("#job_list").append('<input type="text" class="job_input" name="jobs[]" placeholder="+ 事項 ......" />');
        //$('.job_input:last').on('keyup', function(){ addJob(); });
    }
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Show input jobs panel
function inputJobs( jobs_list ) {
	//console.log( jobs_list );
	var step = "最佳化工作效率";
	var panel = ['<div id="engine_plane"><form id="job_list"><input type="text" class="job_input" name="jobs[]" placeholder="輸入所有你今天要做的事 ......" value="'+ jobs_list[0].title +'" />'];
	for( var key in jobs_list ) {
		if( key == 0 ) { continue; }
		panel.push('<input type="text" class="job_input" name="jobs[]" placeholder="+ 事項 ......" value="'+ jobs_list[ key ].title +'" />');
	}
	panel.push('<input type="text" class="job_input" name="jobs[]" placeholder="+ 事項 ......" />');
	panel.push('</form><div style="text-align: right; padding: 0;"><a href="javascript:;" class="picbutton submit_btn" style="margin: 0; margin-top: 25px;" onClick="selectMainJobs( true );">確定</a></div></div>'); 
	$('#engine_step').html( step );
	$('#engine_content').html( panel.join('') );
}

// Show select main jobs table
function selectMainJobs( edited ) {

	var step = "找出最重要的關鍵項目並打勾(可複選)";
	var table = ['<table id="engine_table" class="data_table"><thead><tr><td><div style="text-align: left;">工作項目</div></td></tr></thead><tbody>'];
	var buttons = '<div style="text-align: right; padding: 0; width:674px; margin-left: 92px;"><a href="javascript:;" class="inlinebox" style="height: 25px; line-height: 25px;" onClick="inputJobs( jobs_list );">&lt;&nbsp;返回</a>&nbsp;&nbsp;<a href="javascript:;" class="picbutton submit_btn" style="margin: 0;" onClick="selectSimilarJobs( true );">確定</a><a href="javascript:;" class="inlinebox" style="height: 25px; line-height: 25px;" onClick="selectSimilarJobs( false );">&nbsp;&nbsp;略過&nbsp;&gt;</a></div>';
	var jobNum = 0;

	// show pre select main job
	if( !edited && jobs_list.length && typeof(jobs_list[0].main) != "undefined" && jobs_list[0].main !== null ) {
		for( var index in jobs_list ) {
			var job = '<tr><td class="job"><div><div class="inlinebox" style="width: 440px;"><input type="checkbox" ';
			if( jobs_list[ index ].main > 0 ) {
				job += 'checked="true" ';
			}
			job += ' />&nbsp;<div class="inlinebox text-hidden" style="width:400px;">'+jobs_list[ index ].title+'</div></div></div></td></tr>';
			table.push( job );
			$('#engine_step').html( step );
		}
		//table.push('<tr><td style="border-bottom: none;"><div style="height: 10px;">&nbsp;</div></td></tr>');
		table.push('</tbody></table><div class="data_table_tail" style="width:596px; margin-left: 122px;"></div>');
		$('#engine_content').html( table.join('') );
		$('.data_table_tail').after( buttons );
		$('#engine_table .job:last').css('border-bottom', 'none');
		return true;
	}

	Placeholders.disable(); // For IE8, 9 placeholders


	// empty jobs_list of inputJobs
	jobs_list = [];

	// save job tiles
	$('.job_input').each(function(n) {
		var job_title = escapeHtml($.trim( $(this).val() ));
		if( job_title != '' ) {
			table.push('<tr><td class="job"></font><div><div class="inlinebox" style="width: 440px;"><input type="checkbox" />&nbsp;<div class="inlinebox text-hidden" style="width:400px;">'+job_title+'</div></div></div></td></tr>');
			var job = new Object;
			job.title = job_title;
			job.order = n;
			jobs_list.push( job ); // job_list for inputJobs
			jobNum++;
		}
	});
	//table.push('<tr><td style="border-bottom: none;"><div style="height: 10px;">&nbsp;</div></td></tr>');
	table.push('</tbody></table><div class="data_table_tail" style="width:596px; margin-left: 122px;"></div>');
	if( jobNum > 0 ) {
		$('#engine_step').html( step );
		$('#engine_content').html( table.join('') );
		$('.data_table_tail').after( buttons );
		$('#engine_table .job:last').css('border-bottom', 'none');
		return true;
	}
	return false;
}

// Show select similar jobs table
function selectSimilarJobs( edited ) {
	var step = "找出性質相似的工作項目並打勾(無相似可以略過)";
	var table = ['<table id="engine_table" class="data_table"><thead><tr><td><div style="text-align: left;">工作項目</div></td></tr></thead><tbody>'];
	var buttons = '<div style="text-align: right; padding: 0; width:674px; margin-left: 92px;"><a href="javascript:;" class="inlinebox" style="height: 25px; line-height: 25px;" onClick="selectMainJobs( false );">&lt;&nbsp;返回</a>&nbsp;&nbsp;<a href="javascript:;" class="picbutton submit_btn" style="margin: 0;" onClick="orderJobs( true );">確定</a><a href="javascript:;" class="inlinebox" style="height: 25px; line-height: 25px;" onClick="orderJobs( false );">&nbsp;&nbsp;略過&nbsp;&gt;</a></div>';

	// show pre select similar job
	if( !edited && jobs_list.length && typeof(jobs_list[0].similar) != "undefined" && jobs_list[0].similar !== null ) {
		for( var index in jobs_list ) {
			if( jobs_list[ index ].main ) {
				continue;
			}
			var job = '<tr><td class="job"><font class="no" style="display: none;">'+jobs_list[index].order+'</font><div><div class="inlinebox text-hidden" style="width: 440px;"><input type="checkbox" ';
			if( jobs_list[ index ].similar > 0 ) {
				job += 'checked="true" ';
			}
			job += ' />&nbsp;<div class="inlinebox text-hidden" style="width:400px;">'+jobs_list[ index ].title+'</div></div></div></td></tr>';
			table.push( job );
			$('#engine_step').html( step );
		}
		table.push('<tr><td style="border-bottom: none;"><div style="height: 10px;">&nbsp;</div></td></tr>');
		table.push('</tbody></table><div class="data_table_tail" style="width:596px; margin-left: 122px;"></div>');
		$('#engine_content').html( table.join('') );
		$('.data_table_tail').after( buttons );
		$('#engine_table .job:last').css('border-bottom', 'none');
		return true;
	}

	//  save main job and show other jobs 
	$('#engine_table .job').each(function(n) {
		if( edited && $(this).find('input[type=checkbox]').prop('checked') ) {
			jobs_list[ n ].main = true;
		}
		else {
			jobs_list[ n ].main = false;				
			table.push('<tr><td class="job"><font class="no" style="display: none;">'+jobs_list[n].order+'</font><div><div class="inlinebox text-hidden" style="width: 440px;"><input type="checkbox" />&nbsp;<div class="inlinebox text-hidden" style="width:400px;">'+jobs_list[ n ].title+'</div></div></div></td></tr>');
		}
	});
	table.push('<tr><td style="border-bottom: none;"><div style="height: 10px;">&nbsp;</div></td></tr>');
	table.push('</tbody></table><div class="data_table_tail" style="width:596px; margin-left: 122px;"></div>');

	$('#engine_step').html( step );
	$('#engine_content').html( table.join('') );
	$('.data_table_tail').after( buttons );
	$('#engine_table .job:last').css('border-bottom', 'none');
	//console.log( jobs_list[0] );
}

// Show change jobs order table
function orderJobs( edited ) {
	var step = "排出優先處理順序";
	var table = ['<table id="engine_table" class="data_table"><thead><tr><td><div style="text-align: left;">工作項目</div></td></tr></thead><tbody>'];
	var buttons = '<div style="text-align: right; padding: 0; width:626px; margin-left: 92px;"><a href="javascript:;" class="inlinebox" style="height: 25px; line-height: 25px;" onClick="selectSimilarJobs();">&lt;&nbsp;返回</a>&nbsp;&nbsp;<a href="javascript:;" class="picbutton submit_btn" style="margin: 0;" onClick="showResult();">確定</a></div>';

	for( var index in jobs_list ) {
		jobs_list[ index ].similar = false;	
	}

	// save similar job and show jobs except main jobs
	$('#engine_table .job').each(function() {
		var n = parseInt( $(this).find('.no').text() );
		if( edited && $(this).find('input[type=checkbox]').prop('checked') ) {
			jobs_list[ n ].similar = true;
		}
		else {
			jobs_list[ n ].similar = false;	
		}
		table.push('<tr><td class="job"><font class="no" style="display: none;">'+n+'</font><div><div class="inlinebox text-hidden" style="width: 440px; padding-right: 20px;"><input type="checkbox" style="visibility:hidden;" />&nbsp;<div class="inlinebox text-hidden" style="width:400px;">'+jobs_list[ n ].title+'</div></div><a href="javascript:;" class="button" style="vertical-align: middle; padding: 0px 12px; height: 24px; line-height: 22px; line-height: 20px\\0/;" onClick="changeJobOrder( $(this), 0 );">往上移</a>&nbsp;<a href="javascript:;" class="button" style="vertical-align: middle;padding: 0px 12px; height: 24px; line-height: 22px; line-height: 20px\\0/;" onClick="changeJobOrder( $(this), 1 );">往下移</a></div></td></tr>');
	});
	table.push('<tr><td style="border-bottom: none;"><div style="height: 10px;">&nbsp;</div></td></tr>');
	table.push('</tbody></table><div class="data_table_tail" style="width:596px; margin-left: 122px;"></div>');

	$('#engine_step').html( step );
	$('#engine_content').html( table.join('') );
	$('.data_table_tail').after( buttons );
	$('#engine_table .job:last').css('border-bottom', 'none');
}

function changeJobOrder( job, direction ) {
	job = job.parents('tr');
	if( direction == 0 && job.prev().find('.job').length ) {
		//job.hide(0);
		var tjob = job.clone();
		job.prev().before( tjob );
		tjob.fadeIn(300);
		job.remove();
		//return true;
	}
	else if( direction == 1 && job.next().find('.job').length ) {
		//job.hide(0);
		var tjob = job.clone();
		job.next().after( tjob );
		tjob.fadeIn(300);
		job.remove();
	}
	else {
		return false;
	}

	$('#engine_table tbody td').css('border-bottom', '1px solid #c3c3c3');
	$('#engine_table .job:last').css('border-bottom', 'none');
}

function showResult() {
	var orders = [];
	// save similar job
	for( var index in jobs_list ) {
		if( jobs_list[ index ].main ) {
			orders.push( jobs_list[ index ].order );
		}
	}
	$('#engine_table .job').each(function(n) {
		var no = parseInt( $(this).find('.no').text() );
		orders.push( no );
	});
	
	var form = ['<form id="result" method="post" action="?dept=job&ma=engine&sa=result">'];
	for( var index in jobs_list ) {
		form.push('<input type="hidden" name="jobs[]" value="'+jobs_list[ index ].title+'" />');
		if( jobs_list[ index ].main ) {
			form.push('<input type="hidden" name="main[]" value="'+jobs_list[ index ].title+'" />');
		}
		if( jobs_list[ index ].similar ) {
			form.push('<input type="hidden" name="similar[]" value="'+jobs_list[ index ].title+'" />');
		}
	};
	for( var index in orders ) {
		form.push('<input type="hidden" name="orders[]" value="'+orders[ index ]+'" />');
	}
	form.push('</form>');

	$('body').append(form.join(''));
	$('#result').submit();
}
</script>
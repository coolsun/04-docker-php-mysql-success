<?php
if( isset($_GET['jn']) && $_GET['jn'] != '' ) {
	$jobnote_id = trim($_GET['jn']);
	// For existed note, fetch note forom DB by id
	$get_jobnote = $dbh->prepare('SELECT * FROM `jobnotes` WHERE `user_id`=? AND `jobnote_id`=?;');
	$get_jobnote->execute( array($_SESSION['userid'], $jobnote_id) );
	$tmp = $get_jobnote->fetch(PDO::FETCH_ASSOC);
	if( !$tmp ) {
		header("Location: " . $_SERVER['PHP_SELF'] . "?dept=job&ma=jobnote&sa=list");
	}
	$jobnote = array('title' => $tmp['jobnote_title'],
					 'date' => date('Y-m-d H:i:s', strtotime( $tmp['created_datetime'] )), 
					 'content' => $tmp['jobnote_content']);
}
else {
	header("Location: " . $_SERVER['PHP_SELF'] . "?dept=job&ma=jobnote&sa=list");
}
?>

<table cellspacing='0' class="jobnote_table data_table center" style="width: 873px; vertical-align: top;">
	<thead>
		<tr>
			<td class="operation">
				<a href="?dept=job&ma=jobnote&sa=edit&jn=<?php echo $jobnote_id ?>" id="edit" class="button">編輯</a>
				<a href="#" id="delete" class="button">刪除</a>
			</td>
		</tr>
	</thred>
</table>

<div class="view jobnotes">
	<div class="jobnote">
		<div class="meta">
			<div class="title" style="font-size: 18px;">
				<?php echo $jobnote['title'] ?>
			</div>
			<div class="date" style="font-size: 14px;"><?php echo date('Y/m/d', strtotime($jobnote['date'])); ?></div>
		</div>
		<div class="content">
			<?php 
				echo $jobnote['content'];
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function() {
	$('#delete').on('click', function() {
		$.confirm({
			'title'     : '<div class="inlinebox" style="height: 18px;">&nbsp;</div>',
	        'content'   : '<div style="text-align: left; padding-left: 16px;">請確認是否刪除?</div>',
	        'width'     : '240',
	        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
	        'buttons'   : {
	            '確定'   : {
	                'class' : 'gray',
	                'action': function(){
	                	$.ajax({
						    type : "GET",
						    data: {'jn': <?php echo $jobnote_id; ?>},
						    url : "job/jobnote/jobnote_functions/jobnote/jobnote_deleting.php",
						    beforeSend : function (XMLHttpRequest) {
						        XMLHttpRequest.setRequestHeader("ajax","yes");
						    },
						    success : function(res){
						    	if( res.match(/success/) ) {
						    		location.replace('<?php echo $_SERVER['PHP_SELF'] . "?dept=job&ma=jobnote&sa=list"; ?>');
						    	}
						    	return true;
						    }
	                	});
	                	return true;
	                }
	            },
	            '取消'    : {
	                'class' : 'gray',
	                'action': function(){ return true; }
	            }
			}
		});
	});
});
</script>
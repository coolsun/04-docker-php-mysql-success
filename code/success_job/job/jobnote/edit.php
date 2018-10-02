<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

// Post-Redirect-Session
if( isset($_POST['jobnote']) ) {
    // Store $_POST into $_SESSION
    $_SESSION['jobnote'] = $_POST['jobnote'];
    // Redirect to this page.
    ob_end_clean();
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
else {
    if( isset( $_SESSION['jobnote'] ) ) {
    	// Restore $_SESSION into $_POST
	    $_POST['jobnote'] = $_SESSION['jobnote'];
	    // Unset temp $_Session
	    unset( $_SESSION['jobnote'] );
	}
}


if( isset($_GET['jn']) && $_GET['jn'] != '' ) {
	$jobnote_id = trim($_GET['jn']);
	// For existed note, fetch note forom DB by id
	$get_jobnote = $dbh->prepare('SELECT * FROM `jobnotes` WHERE `user_id`=? AND `jobnote_id`=?;');
	$get_jobnote->execute( array($_SESSION['userid'], $jobnote_id) );
	$tmp = $get_jobnote->fetch(PDO::FETCH_ASSOC);
	$tmp['jobnote_content'] = preg_replace("/\\n|\\r/ius", "", $tmp['jobnote_content']); // Replcae \n and \r
	$jobnote = array('title' => $tmp['jobnote_title'], 'content' => $tmp['jobnote_content'] );

	if( isset($_POST['jobnote']) ) {
		// Update existed note
		$_POST['jobnote']['content'] = str_replace('"', "&#34;", $_POST['jobnote']['content']);
		$_POST['jobnote']['content'] = str_replace("'", "&#39;", $_POST['jobnote']['content']);
		$update_jobnote = $dbh->prepare('UPDATE `jobnotes` SET `jobnote_title`=?, `jobnote_content`=? WHERE `user_id`=? AND `jobnote_id`=?;');
		$update_jobnote->execute( array($_POST['jobnote']['title'], $_POST['jobnote']['content'], $_SESSION['userid'], $jobnote_id) );
		//$jobnote = $_POST['jobnote'];
		header("Location: " . $_SERVER['SCRIPT_NAME'] . "?dept=job&ma=jobnote&sa=view&jn=". $jobnote_id); // Back to list
		exit();
	}
}
else if( isset($_POST['jobnote']) ) {
	// Insert new note to DB
	$jobnote = $_POST['jobnote'];
	$jobnote['content'] = strip_tags( $_POST['jobnote']['content'], '<div><p><ol><ul><li><strong><br><b><i><em><u>' );
	$jobnote['content'] = str_replace('"', "&#34;", $jobnote['content']);
	$jobnote['content'] = str_replace("'", "&#39;", $jobnote['content']);
	try {
		$insert_jobnote_sql = "INSERT INTO `jobnotes` (`user_id`, `jobnote_title`, `jobnote_content`, `modified_datetime`, `created_datetime`) VALUES(?,?,?,?,?);";
		$insert_jobnote = $dbh->prepare($insert_jobnote_sql);
		$insert_jobnote->execute( array($_SESSION['userid'], $jobnote['title'], $jobnote['content'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s') ) ) ;
		$jobnote_id = $dbh->lastInsertId();
		//header("Location: " . $_SERVER['REQUEST_URI'] . "&jn=" . $jobnote_id); // Back to edit
		header("Location: " . $_SERVER['SCRIPT_NAME'] . "?dept=job&ma=jobnote"); // Back to list
		exit();
	}
	catch (PDOException $e) {
	  echo "Error";
	  exit();
	}
}
?>

<script type="text/javascript" src="job/js/placeholders_bak.js"></script>
<script type="text/javascript" src="job/js/jquery-te/jquery-te.js"></script>
<link rel="stylesheet" type="text/css" href="job/js/jquery-te/jquery-te.css" />

<table cellspacing='0' class="jobnote_table data_table center" style="width: 873px; vertical-align: top;">
	<thead>
		<tr>
			<td class="operation">
				&nbsp;
			</td>
		</tr>
	</thred>
</table>	

<div id="jobnote" class="edit-area">
	<form id="jobnote_form" action="?dept=job&ma=jobnote&sa=edit<?php if(isset($jobnote_id)) echo '&jn=',$jobnote_id; ?>" method="post">
		<input type="text" name="jobnote[title]" class="title" value="<?php if(isset($jobnote)) echo $jobnote['title']; ?>" placeholder="主題 ..."/>
		<textarea class="note-content" name="jobnote[content]"></textarea>
	</form>
	<div style="text-align:right;">
		<a href="#" class="button submit">確定</a>
	</div>
</div>

<script type="text/javascript">
$(function() {
	var edited = false;

	$("textarea.note-content").jqte({
		format: false, 
		fsize:false,
		color:false,
		sub: false,
		sup: false,
		outdent: false,
		indent: false,
		left: false,
		right: false,
		center: false,
		strike: false,
		link: false,
		unlink: false,
		remove: false,
		rule: false,
		source: false,
		button: 'SEND'
	}).jqteVal("<?php if(isset($jobnote)) echo $jobnote['content']; ?>");

	$('#jobnote').on('click', '.submit', function() {
		if( !$.trim( $('#jobnote_form .title').val() ).length > 0 ) {
			return false;
		}
		//alert('From jqte\n'+$('#jobnote .jqte_editor').html());
		$(window).unbind('beforeunload');
		$('.note-content').val( $('#jobnote .jqte_editor').html() );
		$('#jobnote_form').submit();
	});

	$('#jobnote').on('change', 'input', function() {
		edited = true;
	});

	$('#jobnote').on('change', '.jqte_editor', function() {
		edited = true;
	});

	$(window).on('beforeunload', function(e) {
		if(!edited) {
			return;
		}
		return "尚未儲存變更, 是否離開此頁面?";
	});
});
</script>
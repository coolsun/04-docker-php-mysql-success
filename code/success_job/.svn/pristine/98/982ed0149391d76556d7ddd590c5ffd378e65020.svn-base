<?php
session_start();
header('Content-Type:text/html; charset=utf-8');
require "../../../../config_conn.inc.php";

/*
 Indexs
*/
$job_status = array('未開始',  '執行中', '已完成', '延遲');
$job_priorities = array('高', '中','低');

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
 Get the job informations
 Job Type and Job ID
*/
$jobTypes = array('job', 'subjob');
if( isset( $_POST['job_type'] ) && trim( $_POST['job_type'] ) && in_array( $_POST['job_type'], $jobTypes ) && isset( $_POST['job_id'] ) ) {

	$job_type = $_POST['job_type'];
	$job_id = $_POST['job_id'];

}
else {
	//error_callback( 'Error.job_updating.1' );
	echo "Error.jobs_updating.1";
	exit();
}

/*
 Update type
 1 : all column
 2 : priority & status
 3 : during
 4 : job title & job description
*/
$updateTypes = array(1, 2, 3, 4);
$updateType = 1;
if( isset( $_POST['updateType'] ) && in_array($_POST['updateType'], $updateTypes) ) {
	$updateType = $_POST['updateType'];
}



/*
 Job priority, status, title, sdate, edate, description
*/
if( $updateType == 1 &&
	isset( $_POST['job_priority'] )    && trim( $_POST['job_priority'] ) && 
	isset( $_POST['job_status'] )      && trim( $_POST['job_status'] )   && 
	isset( $_POST['job_title'] )       && trim( $_POST['job_title'] )    &&
	isset( $_POST['job_start_date'] )  && trim( $_POST['job_start_date'] )    &&
	isset( $_POST['job_end_date'] )    && trim( $_POST['job_end_date'] )    &&
	isset( $_POST['job_description'] ) ) {

	$_POST['job_title'] = trim( $_POST['job_title'] );
	$_POST['job_description'] = trim( $_POST['job_description'] );
	$_POST['job_priority'] = (string) array_search($_POST['job_priority'], $job_priorities);
	$_POST['job_status'] = (string) array_search($_POST['job_status'], $job_status);

}
elseif( $updateType == 2 &&
		isset( $_POST['job_priority'] )    && trim( $_POST['job_priority'] ) && 
		isset( $_POST['job_status'] )      && trim( $_POST['job_status'] ) ) {

	$_POST['job_priority'] = (string) array_search($_POST['job_priority'], $job_priorities);
	$_POST['job_status'] = (string) array_search($_POST['job_status'], $job_status);

}
elseif( $updateType == 3 &&
		isset( $_POST['job_start_date'] )  && trim( $_POST['job_start_date'] ) &&
		isset( $_POST['job_end_date'] )    && trim( $_POST['job_end_date'] ) ) {

		// ... check action
}
else {
	//error_callback( 'Error.job_upadting.2' );
	echo "Error.jobs_updating.2";
	exit();
}

/*
 Connect to DB
*/
try {
  $dbh = new PDO($DB_connection_array['job']['driver_name'].':host='.$DB_connection_array['job']['host'].';dbname='.$DB_connection_array['job']['db_name'], $DB_connection_array['job']['user_name'], $DB_connection_array['job']['password']);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
  //error_callback( "Error.jobs_updating.3" );
  echo "Error.jobs_updating.3";
  exit();
}

/*
 Update a job data and its subjobs date
 Update a subjob data ant its parent date
*/
if( $updateType == 1 ) {
	$update_job = $dbh->prepare('UPDATE `'.$job_type.'s` SET `'.$job_type.'_priority`=?, `'.$job_type.'_status`=?, `'.$job_type.'_title`=?, `'.$job_type.'_start_date`=?, `'.$job_type.'_end_date`=?, `'.$job_type.'_description`=? WHERE `'.$job_type.'_id`=? and `user_id`=?;'); 
	$update_job->execute( array( $_POST['job_priority'], $_POST['job_status'], $_POST['job_title'], $_POST['job_start_date'], $_POST['job_end_date'], $_POST['job_description'], $job_id, $_SESSION['userid'] ) );
}
elseif( $updateType == 2 ) {
	$update_job = $dbh->prepare('UPDATE `'.$job_type.'s` SET `'.$job_type.'_priority`=?, `'.$job_type.'_status`=? WHERE `'.$job_type.'_id`=? and `user_id`=?;'); 
	$update_job->execute( array( $_POST['job_priority'], $_POST['job_status'], $job_id, $_SESSION['userid'] ) );
}
elseif( $updateType == 3 ) {
	$update_job = $dbh->prepare('UPDATE `'.$job_type.'s` SET `'.$job_type.'_start_date`=?, `'.$job_type.'_end_date`=? WHERE `'.$job_type.'_id`=? and `user_id`=?;'); 
	$update_job->execute( array( $_POST['job_start_date'], $_POST['job_end_date'], $job_id, $_SESSION['userid'] ) );
}

/*
 Update during with relation
*/
if( $updateType == 1 || $updateType == 3 ) {
	if( $job_type == 'subjob' ) {
		// Get parent job id
		$query_parent_job = $dbh->prepare('SELECT `parent_job_id` FROM `subjobs` WHERE `subjob_id`=? AND `user_id`=?;');
		$query_parent_job->execute( array( $job_id, $_SESSION['userid'] ) );
		$parent_job_temp = $query_parent_job->fetch(PDO::FETCH_ASSOC);
		$parent_job_id = $parent_job_temp['parent_job_id'];	
		
		// Get parent job during
		$query_parent_job = $dbh->prepare('SELECT `job_start_date`, `job_end_date` FROM `jobs` WHERE `job_id`=? AND `user_id`=?;');
		$query_parent_job->execute( array( $parent_job_id, $_SESSION['userid'] ) );
		$parent_job = $query_parent_job->fetch(PDO::FETCH_ASSOC);

		$psDate = sprintf("%d", str_replace('-', '', $parent_job['job_start_date']) );
		$peDate = sprintf("%d", str_replace('-', '', $parent_job['job_end_date']) );
		
		$updateParentJob = -1;
		if( sprintf("%d", str_replace('-', '', $_POST['job_start_date']) ) < $psDate ) {
			$updateParentJob = 1;
			$psDate = $_POST['job_start_date'];
		}
		if( sprintf("%d", str_replace('-', '', $_POST['job_end_date']) ) > $peDate ) {
			$updateParentJob = 1;
			$peDate = $_POST['job_end_date'];
		}
		if( $updateParentJob ) { 
			$update_parent_job = $dbh->prepare('UPDATE `jobs` SET `job_start_date`=?, `job_end_date`=? WHERE `job_id`=? and `user_id`=?;'); 
			$update_parent_job->execute( array( $psDate, $peDate, $parent_job_id, $_SESSION['userid'] ) );
		}

	}
	elseif( $job_type == 'job' ) {
		$query_subjobs = $dbh->prepare('SELECT `subjob_id`, `subjob_start_date`, `subjob_end_date` FROM `subjobs` WHERE `parent_job_id`=? AND `user_id`=?;');
		$query_subjobs->execute( array( $job_id, $_SESSION['userid'] ) );
		$subjobs = $query_subjobs->fetchAll(PDO::FETCH_ASSOC);
		
		// Set job date as default
		$minStartDate = sprintf("%d", str_replace('-', '', $_POST['job_start_date']) );
		$maxEndDate = sprintf("%d", str_replace('-', '', $_POST['job_end_date']) );
		// Check subjob during and update
		if( count( $subjobs ) ) {
			$update_subjob = $dbh->prepare('UPDATE `subjobs` SET `subjob_start_date`=?, `subjob_end_date`=? WHERE `subjob_id`=? and `user_id`=?;'); 
			foreach( $subjobs as $index => $subjob ) {
				$updateSubjob = -1;
				$subjob_sdate = sprintf("%d", str_replace('-', '', $subjob['subjob_start_date']) );
				$subjob_edate = sprintf("%d", str_replace('-', '', $subjob['subjob_end_date']) );
				if( $subjob_sdate < $minStartDate || $subjob_sdate > $maxEndDate ) {
					$updateSubjob = 1;
					$subjob['subjob_start_date'] = $_POST['job_start_date'];
				}
				if( $subjob_edate > $maxEndDate || $subjob_edate < $minStartDate ) {
					$updateSubjob = 1;
					$subjob['subjob_end_date'] = $_POST['job_end_date'];
				}
				if( $updateSubjob ) {
					$update_subjob->execute( array( $subjob['subjob_start_date'], $subjob['subjob_end_date'], $subjob['subjob_id'], $_SESSION['userid'] ) );
				}
			}
		}
	}
}

echo "success";

?>


<?php
/*
 Back to previous page and show error message
*/
function error_callback( $error_msg ) {
	$_SESSION['Error_msg'] = $error_msg;
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
?>
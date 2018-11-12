<?php
/*
 Indexs
*/
$job_status = array('未開始',  '執行中', '已完成', '延遲');
$job_bar_color = array( 'notStarted', 'executing', 'done', 'delay' );
$job_priorities = array('高', '中','低');
$date_units = array('日' => 1, '週' => 7, '月' => 30);

if( isset($_POST['startDate']) || isset($_POST['selectedUnit'])) {
    $_SESSION['startDate'] = $_POST['startDate'];
    $_SESSION['selectedUnit'] = $_POST['selectedUnit'];
    // Redirect to this page.
    ob_end_clean();
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
else {
    $_POST['startDate'] = $_SESSION['startDate'];
    $_POST['selectedUnit'] = $_SESSION['selectedUnit'];
    unset( $_SESSION['startDate'] );
    unset( $_SESSION['selectedUnit'] );
}

// Default start dateis today
if( !$_POST['startDate'] ) {
    $_POST['startDate'] = date('Y/m/d');
}

$unit = $date_units[ $_POST['selectedUnit'] ];
// Default date unit
if( !isset($date_units[ $_POST['selectedUnit'] ]) ) {
    $unit = 1;
}

// BETWEEN function
function BETWEEN( $m, $s, $e ) {
    if( $s > $e ) {
        $t = $s;
        $s = $e;
        $e = $t;
    }
    if( $s <= $m && $m <= $e ) {
        return 1;
    }
    return 0;
}

/*
 Get visible dates
*/
$timeLine = array();
$rawdates = array();
$dateNum = 32;
$lastDate = "";
//$startMonth = date( 'Y-m', strtotime($_POST['startDate']) );
for( $num = 0 ; $num < $dateNum ; $num++ ) {
    
    if( $num == $dateNum - 1 ) {
        ($unit != 30) ? $lastDate = date( 'Y-m-d', strtotime($_POST['startDate'].' +'.$num*$unit.' day') ) : $lastDate = date( 'Y-m-d', strtotime($_POST['startDate'].' +'.$num.' month') );
    }

    ($unit != 30) ? $rawdates[] = strtotime($_POST['startDate'].' +'.$num*$unit.' day') : $rawdates[] = strtotime($_POST['startDate'].' +'.$num.' month');

    ($unit != 30) ? $month = date( 'Y/m', strtotime($_POST['startDate'].' +'.$num*$unit.' day') ) : $month = date( 'Y/m', strtotime($_POST['startDate'].' +'.$num.' month') );
    ($unit != 30) ? $date = date( 'd', strtotime($_POST['startDate'].' +'.$num*$unit.' day') ) : $date = date( 'd', strtotime($_POST['startDate'].' +'.$num.' month') );
    ($unit != 30) ? $day = date( 'w', strtotime($_POST['startDate'].' +'.$num*$unit.' day') ) : $day = date( 'w', strtotime($_POST['startDate'].' +'.$num.' month') );;
    
    //$month = date( 'Y/m', strtotime($_POST['startDate'].' +'.$num*$unit.' day') );
    //$date = date( 'd', strtotime($_POST['startDate'].' +'.$num*$unit.' day') );
    //$day = date( 'w', strtotime($_POST['startDate'].' +'.$num*$unit.' day') );
    if( !isset( $timeLine[ $month ] ) ) {
        $timeLine[ $month ] = array( $date  => $day );
        continue;
    }
    $timeLine[ $month ][ $date ] = $day;
}
/*
echo $_POST['startDate']."<br>";
echo $unit."<br>";
echo $lastDate;
*/
//print_r($rawdates);

$monthEndDate = array();
$count = 0;
$first = 1;
foreach($timeLine as $month => $m ) {
    if($first) {
        $count += count($m) - 1 ;
        $first = 0;
    }
    else {
        $count += count($m);
    }
    $monthEndDate[] = $count;
}
array_pop($monthEndDate);
//print_r($monthEndDate);

/*
 Get data of jobs
*/
$query_jobs_sql = 'SELECT `job_id`, `job_title`, `job_priority`, `job_status`, `job_start_date`, `job_end_date`, `job_description` FROM `jobs` WHERE `user_id` = ? ';
$query_jobs_params = array($_SESSION['userid']);

$query_jobs_sql .= 'AND (`job_start_date` BETWEEN ? AND ?) OR (`job_end_date` BETWEEN ? AND ?) OR (`job_start_date` < ? AND `job_end_date` > ? ) ';
array_push($query_jobs_params, $_POST['startDate']);
array_push($query_jobs_params, $lastDate);
array_push($query_jobs_params, $_POST['startDate']);
array_push($query_jobs_params, $lastDate);
array_push($query_jobs_params, $_POST['startDate']);
array_push($query_jobs_params, $lastDate);

$query_jobs_sql .= 'ORDER BY `created_datetime` DESC';

$query_jobs = $dbh->prepare( $query_jobs_sql );
$query_jobs->execute( $query_jobs_params );

$job_dataset = $query_jobs->fetchAll(PDO::FETCH_ASSOC);

//print_r( $job_dataset );

/*
 Data rows
*/
$dataRows = count( $job_dataset );

/*
 Get data of subjobs
*/
$job_ids = '';
if( count($job_dataset) ) {
    foreach( $job_dataset as $job ) {
        $job_ids .= $job['job_id'] .",";
    }
    $job_ids = substr($job_ids, 0, strlen($job_ids)-1);

    $query_subjobs = $dbh->prepare('SELECT `subjob_id`, `parent_job_id`, `subjob_title`, `subjob_priority`, `subjob_status`, `subjob_start_date`, `subjob_end_date`, `subjob_description` FROM `subjobs` WHERE `user_id` = ? AND `parent_job_id` IN ( '. $job_ids .' )');
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

/*
 Calculate Bar
*/
//echo $unit;
foreach( $job_dataset as $index => $job ) {
    $jsdate = strtotime( $job['job_start_date'] );
    $jedate = strtotime( $job['job_end_date'] );
    $job_dataset[ $index ]['barMark'] = array();
    $job_dataset[ $index ]['bar'] = array();
    $barPadding = 0; // 0:left padding , 1:right padding
    for( $num = 0 ; $num < $dateNum ; $num++ ) {
        if( $unit == 1 ) {
            if( $jsdate <= $rawdates[$num] && $rawdates[$num] <= $jedate ) {
                $job_dataset[ $index ]['barMark'][$num] = 1;
                $job_dataset[ $index ]['bar']['fill'] += 24;
                $barPadding = 1;
            }
            else {
                $job_dataset[ $index ]['barMark'][$num] = 0;
                if( $barPadding == 0 ) {
                    $job_dataset[ $index ]['bar']['left'] += 24;
                }
                else if( $barPadding == 1 ) {
                    $job_dataset[ $index ]['bar']['right'] += 24; 
                }
            }
        }
        else if( $unit == 7 || $unit == 30 ) {
            if( ($jsdate <= $rawdates[$num] && $rawdates[$num] <= $jedate) || ($jsdate > $rawdates[$num] && $rawdates[$num] <= $jedate ) ) {
                if( $unit == 7 ) {
                    $wdates = array();
                    $wsdate = $rawdates[$num];
                    for( $i=0 ; $i<7 ; $i++ ) {
                        $wdates[] = strtotime( date('Y-m-d',$wsdate).' +'.$i.' day' );
                    }
                    $job_dataset[ $index ]['barMark'][$num] = array();
                    for( $i=0 ; $i<7 ; $i++ ) {
                        if( $jsdate <= $wdates[$i] && $wdates[$i] <= $jedate ) {
                            $job_dataset[ $index ]['barMark'][$num][] = 1;
                        }
                        else{
                            $job_dataset[ $index ]['barMark'][$num][] = 0;   
                        }
                    }
                }
                /*else if ( $unit == 30 ) {
                    $mdates = array();
                    $msdate = $rawdates[$num];
                    for( $i=0 ; $i<3 ; $i++ ) {
                        $mdates[] = strtotime( date('Y-m-1',$msdate).' +'.(($i+1)*7).' day' );
                        echo date('Y-m-d', $mdates[$i] ).'<br>';
                    }
                    $mdates[] = strtotime( date('Y-m-t',$msdate) );
                    print_r($mdates);
                    echo '<br>';
                    $job_dataset[ $index ]['barMark'][$num] = array();
                    for( $i=0 ; $i<4 ; $i++ ) {
                        if( $jsdate <= $mdates[$i] && $mdates[$i] <= $jedate ) {
                            $job_dataset[ $index ]['barMark'][$num][] = 1;
                        }
                        else{
                            $job_dataset[ $index ]['barMark'][$num][] = 0;   
                        }   
                    }
                    print_r($job_dataset[ $index ]['barMark'][$num]);
                    echo '<br>';
                }*/
                else{
                    $job_dataset[ $index ]['barMark'][$num] = 1;
                }
            }
            else {
                $job_dataset[ $index ]['barMark'][$num] = 0;
            }   
        }
    }
    print_r($job_dataset[ $index ]['bar']);
    echo '<br>';
}

foreach( $subjob_dataset as $job_id => $subjobs ) {
    foreach( $subjobs as $index => $subjob ) {
        $jsdate = strtotime( $subjob['subjob_start_date'] );
        $jedate = strtotime( $subjob['subjob_end_date'] );
        $subjob_dataset[$job_id][ $index ]['barMark'] = array();
        for( $num = 0 ; $num < $dateNum ; $num++ ) {
            if( $unit == 1 ) {
                if( $jsdate <= $rawdates[$num] && $rawdates[$num] <= $jedate ) {
                    $subjob_dataset[$job_id][ $index ]['barMark'][$num] = 1;
                }
                else {
                    $subjob_dataset[$job_id][ $index ]['barMark'][$num] = 0;
                }
            }
            else if( $unit == 7 || $unit == 30 ) {
                if( ($jsdate <= $rawdates[$num] && $rawdates[$num] <= $jedate) || ($jsdate > $rawdates[$num] && $rawdates[$num] <= $jedate ) ) {
                    if( $unit == 7 ) {
                        $wdates = array();
                        $wsdate = $rawdates[$num];
                        for( $i=0 ; $i<7 ; $i++ ) {
                            $wdates[] = strtotime( date('Y-m-d',$wsdate).' +'.$i.' day' );
                        }
                        $subjob_dataset[$job_id][ $index ]['barMark'][$num] = array();
                        for( $i=0 ; $i<7 ; $i++ ) {
                            if( $jsdate <= $wdates[$i] && $wdates[$i] <= $jedate ) {
                                $subjob_dataset[$job_id][ $index ]['barMark'][$num][] = 1;
                            }
                            else{
                                $subjob_dataset[$job_id][ $index ]['barMark'][$num][] = 0;   
                            }
                        }
                    }
                    else {
                        $subjob_dataset[$job_id][ $index ]['barMark'][$num] = 1;
                    }
                }
                else {
                    $subjob_dataset[$job_id][ $index ]['barMark'][$num] = 0;
                }
            }
        }
    }
}
//print_r( $subjob_dataset );

?>

<table cellspacing='0' class="schedule_table data_table center" style="width: 873px; border-radius: 3px 3px 0 0;">
	<thead>
		<tr>
			<td style="border-radius: 3px 0 0 0; width: 103px;">
				<form id="startDateUnit" method="post" class="inlinebox">
                    <input id="date-pick-starDate" name="startDate" type="text" style="text-align: center; height: 23px; width: 90px;" value="<?php echo $_POST['startDate'] ?>" readonly />
                
            </td>
            <td>
				<select name="selectedUnit" onChange=" $('#startDateUnit').submit(); ">
                    <option>時間單位</option>
                <?php 
                foreach( $date_units as $date_unit => $u ) {
                ?>
                    <option <?php if($_POST['selectedUnit'] == $date_unit) echo "selected"; ?> ><?php echo $date_unit; ?></option>
                <?php
                }
                ?>
                </select>
                </form>
			</td>
			<td colspan="" style="border-radius: 0 3px 0 0;">
			<?php 
            foreach( $sas[ $ma ] as $subaction => $subaction_name ) {
            ?>
                <a href="?dept=job&ma=plan&sa=<?php echo $subaction; ?>" class="<?php if($sa == $subaction) echo 'on'; ?> button"><?php echo $subaction_name; ?></a>
            <?php
            }
            ?>
			</td>
		</tr>
        <tr>
            <td class="column" style="padding: 0px; text-align: left;">
                <div class="inlinebox">
                    <div class="inlinebox" style="text-align: left; padding-left: 5px; height: 20px;">重要性 <img src="job/img/square.png" style="margin-right: 3px;" /> 高</div>
                    <div class="inlinebox" style="text-align: left; padding-left: 5px;">工作項目</div>
                </div>
            </td>
            <td class="timeLine" colspan="2"><!--
                <?php
                foreach( $timeLine as $month => $dates ) {
                ?>
             --><div class="inlinebox datesGroup">
                    <div class="month" title="<?php echo $month; ?>">
                    <?php 
                        if(count($dates) > 2){ echo $month; }
                        else{ echo "&nbsp;"; } ?>
                    </div><!--
                    <?php
                    foreach( $dates as $date => $day ) {
                    ?>
                     --><div class="date" style="<?php if( $unit == 1 && $day == 0 ) { echo 'color: #FF1C19;'; } ?>"><?php echo $date; ?></div><!--
                    <?php
                    }
                    ?>
             --></div><!--
                <?php
                }
                ?>
         --></td>
        </tr>
	</thead>
</table>
<table cellspacing='0' class="schedule_table data_table center" style="width: 873px; border-top: none;">
    <tbody>
    <?php
    // Job Loop
    foreach( $job_dataset as $index => $job ) {
        $jobBarColor = $job_bar_color[ $job['job_status'] ];
    ?>
    <tr>
        <td>
            <?php
            if( $job['job_priority'] == 0 ) {
            ?>
            <img src="job/img/square.png" style="margin-left: 5px;" /><!--
            <?php
            }
            else {
            ?>
            <div class="inlinebox" style="width: 9px; margin-left: 5px;"></div><!--
            <?php
            }
            ?>
         --><div class="inlinebox" style="margin-left: 5px; width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?php 
                echo $job['job_title'];
            ?>
            </div>
        </td>
        <td><!--
            <?php 
            if( $unit == 1 || $unit == 30 ) {
                foreach( $job['barMark'] as $barNum => $mark ) {
            ?>
             --><div class="inlinebox bar-wrap <?php if( in_array($barNum, $monthEndDate) ) { echo 'monthEnd'; } ?>">
                    <div class="bar <?php if($mark == 1) { echo 'fill'; echo ' '.$jobBarColor; } ?>"></div>
                </div><!--
            <?php
                }
            }
            else if( $unit == 7 ) {
                foreach( $job['barMark'] as $barNum => $day ) {
            ?>
             --><div class="inlinebox bar-wrap <?php if( in_array($barNum, $monthEndDate) ) { echo 'monthEnd'; } ?>"><!--
                <?php
                    if( is_array( $day ) ) {
                        foreach( $day as $dayNum => $mark ) {
                ?>
                 --><div class="bar weekday <?php if($mark == 1) { echo 'fill'; echo ' '.$jobBarColor; } if( $dayNum % 2 == 0 ) { echo " even"; } ?>"></div><!--
                <?php
                        }
                    }
                    else {
                ?>
                 --><div class="bar"></div><!--
                <?php
                    }
                ?>
             --></div><!--
            <?php
                }
            }
            ?>
     --></td>
    </tr>
        <?php
        // Subjob Loop
        if( isset($subjob_dataset[ $job['job_id'] ]) ) {
            foreach( $subjob_dataset[ $job['job_id'] ] as $subindex => $subjob ) {
                $subjobBarColor = $job_bar_color[ $subjob['subjob_status'] ];
        ?>
    <tr>
        <td>
            <?php
            if( $subjob['subjob_priority'] == 0 ) {
            ?>
            <img src="job/img/square.png" style="margin-left: 5px;" /><!--
            <?php
            }
            else {
            ?>
            <div class="inlinebox" style="width: 9px; margin-left: 5px;"></div><!--
            <?php
            }
            ?>
         --><div class="inlinebox" style="margin-left: 5px; padding-left: 14px; width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?php 
                echo $subjob['subjob_title'];
            ?>
            </div>
        </td>
        <td><!--
            <?php
            if( $unit == 1 || $unit == 30 ) {
                foreach( $subjob['barMark'] as $barNum => $mark ) {
            ?>
             --><div class="inlinebox bar-wrap <?php if( in_array($barNum, $monthEndDate) ) { echo 'monthEnd'; } ?>">
                    <div class="bar <?php if($mark == 1) { echo 'fill'; echo ' '.$subjobBarColor; } ?>"></div>
                </div><!--
            <?php
                }
            }
            else if( $unit == 7 ) {
                foreach( $subjob['barMark'] as $barNum => $day ) {
            ?>
             --><div class="inlinebox bar-wrap <?php if( in_array($barNum, $monthEndDate) ) { echo 'monthEnd'; } ?>"><!--
                <?php
                    if( is_array( $day ) ) {
                        foreach( $day as $dayNum => $mark ) {
                ?>
                 --><div class="bar weekday <?php if($mark == 1) { echo 'fill'; echo ' '.$subjobBarColor; } if( $dayNum % 2 == 0 ) { echo " even"; } ?>"></div><!--
                <?php
                        }
                    }
                    else {
                ?>
                 --><div class="bar"></div><!--
                <?php
                    }
                ?>
             --></div><!--
            <?php
                }
            }
            ?>
     --></td>
    </tr>
    <?php
            } // End Subjob Loop
        }
    } // End Job Loop

    $padding_row = 27 - $dataRows;
    for( $i = 0; $i < $padding_row ; $i++ ) {
    ?>
    <tr>
        <td>&nbsp;</td>
        <td><!--
            <?php 
            for( $j = 0 ; $j < 32 ; $j++ ) {
            ?>
             --><div class="inlinebox bar-wrap <?php if( in_array($j, $monthEndDate) ) { echo 'monthEnd'; } ?>" <?php if( in_array($j, $monthEndDate) ) { echo "style='border-right: 1px solid #c3c3c3;'"; } ?>>
                    <div class="bar"></div>
                </div><!--
            <?php
            }
            ?>
     --></td>
    </tr>
    <?php
    }
    ?>
    </tbody>
</table>
<div class="data_table_tail center"></div>

<script type="text/javascript">
$(function() {

    Date.firstDayOfWeek = 0;
    Date.format = 'yyyy/mm/dd';
    $('#date-pick-starDate').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 24});
    $('#date-pick-starDate').on( 'dpClosed', function(e, selectedDates) {
            $(this).parent().submit();
    });
});
</script>
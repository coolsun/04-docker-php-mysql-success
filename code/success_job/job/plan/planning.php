<?php
/*
 Indexs
*/
$job_status = array('未開始',  '執行中', '已完成', '延遲');
$job_priorities = array('高', '中','低');
$durings = array('前7天' => 7, '前14天' => 14, '前30天' => 30, '前60天' => 60);
$sdurings = array('7天' => 7, '14天' => 14, '30天' => 30, '60天' => 60);

// Post-Redirect-Session
if( isset($_POST['selectedStatus']) || isset($_POST['selectedDuring']) ) {
    // Store $_POST into $_SESSION
    $_SESSION['selectedStatus'] = $_POST['selectedStatus'];
    $_SESSION['selectedDuring'] = $_POST['selectedDuring'];
    if(  isset($_POST['selfLastDate']) ) {
        $_SESSION['selfLastDate'] = $_POST['selfLastDate'];
    }
    // Redirect to this page.
    ob_end_clean();
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
else {
    // Restore $_SESSION into $_POST
    $_POST['selectedStatus'] = $_SESSION['selectedStatus'];
    $_POST['selectedDuring'] = $_SESSION['selectedDuring'];
    
    unset( $_SESSION['selectedStatus'] );
    unset( $_SESSION['selectedDuring'] );

    if( isset($_SESSION['selfLastDate']) ) {
        $_POST['selfLastDate'] = $_SESSION['selfLastDate'];
        $_POST['selfLastDate'] = str_replace('/', '-', $_POST['selfLastDate']);

        unset( $_SESSION['selfLastDate'] );
    }
}


/*
 Get data of jobs
*/
$query_jobs_sql = 'SELECT `job_id`, `job_title`, `job_priority`, `job_status`, `job_start_date`, `job_end_date`, `job_description` FROM `jobs` WHERE `user_id` = ? ';
$query_jobs_params = array($_SESSION['userid']);

if( isset($_POST['selectedStatus']) && in_array($_POST['selectedStatus'], $job_status) ) {
    $query_jobs_sql .= 'AND `job_status` = ? ';
    array_push($query_jobs_params, array_search($_POST['selectedStatus'], $job_status));
}

// Query jobs whose during are relative with earliest date
$backDays = 0;
if( isset($durings[ $_POST['selectedDuring'] ]) || isset($sdurings[ $_POST['selectedDuring'] ])) {
    

    if( isset($_POST['selfLastDate']) ) {
        $backDays = $sdurings[ $_POST['selectedDuring'] ];
        if( !trim($_POST['selfLastDate']) ) { $_POST['selfLastDate'] = date( 'Y-m-d'); }
        // Self define during
        $query_jobs_sql .= 'AND (`created_datetime` BETWEEN ? AND ? )  ';
        $earliestDate = date( 'Y-m-d 00:00:00', strtotime($_POST['selfLastDate'].' -'. $backDays .' day') );
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, date( 'Y-m-d 23:59:59', strtotime($_POST['selfLastDate']) ) );

        unset($_POST['selectedDuring']);
    }
    else {
        $backDays = $durings[ $_POST['selectedDuring'] ];
        // Selection During
        $query_jobs_sql .= 'AND (`created_datetime` BETWEEN ? AND ? )  ';
        $earliestDate = date( 'Y-m-d 00:00:00', strtotime('-'. $backDays .' day') );
        array_push($query_jobs_params, $earliestDate);
        array_push($query_jobs_params, date('Y-m-d 23:59:59'));
    }
}
else {
    // Default backDays = 14 days
    $query_jobs_sql .= 'AND (`created_datetime` BETWEEN ? AND ? )  ';
    $earliestDate = date( 'Y-m-d 00:00:00', strtotime('-14 day') );
    array_push($query_jobs_params, $earliestDate);
    array_push($query_jobs_params, date('Y-m-d 23:59:59'));
}

// Order jobs from new to old
$query_jobs_sql .= 'ORDER BY `created_datetime` DESC';

/*echo $query_jobs_sql.'<br>';
print_r( $query_jobs_params );*/

$query_jobs = $dbh->prepare( $query_jobs_sql );
$query_jobs->execute( $query_jobs_params );

$job_dataset = $query_jobs->fetchAll(PDO::FETCH_ASSOC);


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

?>

<script type="text/javascript" src="job/js/placeholders_bak.js"></script>

<div id="plan_planning_panel" class="center" data-placeholder-focus="false">
    <form id="jobs_plan" action="job/plan/plan_functions/planning/jobs_saving.php" method="post">
        <div id="main_job_list">
            <div id="main_job">
                <input class='center main_job_input' type='text' name='main_job_title' placeholder='工作項目......' /><!--
             --><a href="javascript:;" class="picbutton cal_btn">時程</a><!--
             --><div class="pick-during">
                    <div style="text-align: right;">
                        <a href="javascript:;" onClick="$(this).parent().parent().stop().toggle(300);" class="closex"><!--<img src="job/img/closex.png" border="0" />--></a>
                    </div>
                    <div class="during-box">
                        <div>開始日期&nbsp;&nbsp;<input type="text" name="main_job_sdate" class="date-pick start-date" title="開始日期" readonly /></div>
                        <div>結束日期&nbsp;&nbsp;<input type="text" name="main_job_edate" class="date-pick end-date" title="結束日期" readonly /></div>
                        <div style="width: auto; text-align: right; padding: 5px 2px;">
                            <div class="during-submit" style="">
                                <a class="" href="javascript:;" onClick="checkDateIsEmpty( $(this) );">確定</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sub_job_list" style="display: none;">
        <?php
            include('plan_cpts/subjob.html');
        ?>
        </div>
        <div style="text-align: right; padding: 0;">
            <span id="subjob_button" style="" onClick="$(this).hide(); $('#sub_job_list').show();">分解工作</span>
            <a href="javascript:;" class="picbutton submit_btn" style="margin: 0;" onClick=" $(this).parents('#jobs_plan').submit(); ">確定</a>
        </div>
    </form>
</div>

<table id="plan_table" class="data_table center" style="width: 100%; margin-top: 40px;">
    <thead>
        <tr>
            <td colspan="4">
                <form method="post" style="display: inline-block;">
                    <select name="selectedStatus" onChange=" $(this).parent().submit(); ">
                        <option>狀態</option>
                    <?php 
                    foreach( $job_status as $status ) {
                    ?>
                        <option <?php if($_POST['selectedStatus'] == $status) echo 'selected'; ?> ><?php echo $status; ?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <select name="selectedDuring" onChange=" if( $(this).val() != $(this).find('option:last').text() ) {$(this).parent().submit();} else { selfDuring(); $(this).find('option:first').prop('selected', true); } ">
                        <option>期間</option>
                    <?php 
                    foreach( $durings as $during => $days ) {
                    ?>
                        <option <?php if($_POST['selectedDuring'] == $during) echo 'selected'; ?> ><?php echo $during; ?></option>
                    <?php
                    }
                    ?>
                        <option>自訂</option>
                    </select>
                </form>
            </td>
            <td colspan="2" style="text-align: right;">
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
            <td class="thead priority">重要性</td>
            <td class="thead status">狀態</td>
            <td class="thead title">工作項目</td>
            <td class="thead during">起迄時間</td>
            <td class="thead description">說明</td>
            <td class="thead operation" style="border-right: none;"></td>
        </tr>
    </thead>
    <tbody class="twoColorRow">
        <?php
        /*
         Jobs Loop
        */
        $rowNumber = 0;
        foreach( $job_dataset as $index => $job ) {
        ?>
        <tr id="" class="job <?php if(  $rowNumber++ % 2 ) { echo 'grayLine'; } ?>">
            <td class="priority">
                <div>
                <select class="selectlist" style="visibility:hidden;" onChange=" updateJob( $(this).parents('.job'), 'job', <?php echo $job['job_id']; ?>, 2 ); ">
                <?php 
                foreach( $job_priorities as $priority ) {
                ?>
                    <option <?php if( $job_priorities[ $job['job_priority'] ] == $priority ) echo 'selected'; ?>><?php echo $priority; ?></option>
                <?php
                }
                ?>
                </select>
                </div>
            </td>
            <td class="status">
                <div>
                <select class="selectlist" style="visibility:hidden;" onChange=" updateJob( $(this).parents('.job'), 'job', <?php echo $job['job_id']; ?>, 2 ); ">
                <?php 
                foreach( $job_status as $status ) {
                ?>
                    <option <?php if( $job_status[ $job['job_status'] ] == $status ) echo "selected"; ?>><?php echo $status; ?></option>
                <?php
                }
                ?>
                </select>
                </div>
            </td>
            <td class="title">
                <div>
                    <input class="plan_table_input" type="text" value="<?php echo $job['job_title']; ?>" />
                </div>
            </td>
            <td class="during">
                <div class="during-wrap" style="position: relative;">
                    <font class="during-view" onClick=" $('.pick-during:visible').hide(); $(this).next().toggle(); ">
                        <span class="during-start-year" style="display: none;">
                        <?php echo substr($job['job_start_date'], 0, 4); ?>
                        </span>
                        <span class="during-end-year" style="display: none;">
                        <?php echo substr($job['job_end_date'], 0, 4); ?>
                        </span>
                        <span class="during-start-date">
                        <?php
                            //$start_date = preg_replace( '/^\d{4}-/', '', $job['job_start_date']); 
                            echo str_replace('-', '/', substr($job['job_start_date'], 5) );
                        ?>
                        </span>
                        ~
                        <span class="during-end-date">
                        <?php
                            //$end_date = preg_replace( '/^\d{4}-/', '', $job['job_end_date']); 
                            echo str_replace('-', '/', substr($job['job_end_date'], 5)  );
                        ?>
                        </span>
                    </font><!--
                 --><div class="pick-during" style="top: 2px; left: 102px;">
                            <div style="text-align: right;">
                                <a href="javascript:;" onClick="$(this).parent().parent().stop().toggle(300);" class="closex"></a>
                            </div>
                            <div class="during-box">
                                <div>開始日期&nbsp;&nbsp;<input type="text" name="main_job_sdate" class="date-pick start-date" title="開始日期" value="<?php echo str_replace('-', '/', $job['job_start_date']); ?>" readonly /></div>
                                <div>結束日期&nbsp;&nbsp;<input type="text" name="main_job_edate" class="date-pick end-date" title="結束日期" value="<?php echo str_replace('-', '/', $job['job_end_date']); ?>" readonly /></div>
                                <div style="width: auto; text-align: right; padding: 5px 2px;">
                                    <div class="during-submit" style="">
                                        <a class="" href="javascript:;" onClick="if( checkDateIsEmpty( $(this) ) ) { updateJob( $(this).parents('.job'), 'job', <?php echo $job['job_id']; ?>, 3 ); };">確定</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </td>
            <td class="description">
                <div>
                    <input class="plan_table_input" type="text" value="<?php echo $job['job_description']; /*if(!$job['job_description']) { echo '&nbsp;'; }*/ ?>" />
                </div>
            </td>
            <td class="operation" style="border-right: none;">
                <div>
                    <a href="javascript:;" class="button update" onClick=" updateJob( $(this).parents('.job'), 'job', <?php echo $job['job_id']; ?>, 1 ); ">確定</a><!--
           -->&nbsp;<a href="javascript:;" class="button" onClick=" deleteJob( $(this).parents('.job'), 'job', <?php echo $job['job_id']; ?> ); ">刪除</a>
                </div>
            </td>
        </tr>
        <?php
            /*
                Sub Jobs Loop
            */
            if( isset( $subjob_dataset[ $job['job_id'] ] ) ) {
                foreach( $subjob_dataset[ $job['job_id'] ] as $subindex => $subjob ) {
        ?>
        <tr id="" class="subjob <?php if( $rowNumber++ % 2 ) { echo 'grayLine'; } ?>">
            <td class="priority">
                <div>
                <select class="selectlist" style="visibility:hidden;" onChange=" updateJob( $(this).parents('.subjob'), 'subjob', <?php echo $subjob['subjob_id']; ?>, 2 ); ">
                <?php 
                foreach( $job_priorities as $priority ) {
                ?>
                    <option <?php if( $job_priorities[ $subjob['subjob_priority'] ] == $priority ) echo 'selected'; ?>><?php echo $priority; ?></option>
                <?php
                }
                ?>
                </select>
                </div>
            </td>
            <td class="status">
                <div>
                <select class="selectlist" style="visibility:hidden;" onChange=" updateJob( $(this).parents('.subjob'), 'subjob', <?php echo $subjob['subjob_id']; ?>, 2 ); ">
                <?php 
                foreach( $job_status as $status ) {
                ?>
                    <option <?php if( $job_status[ $subjob['subjob_status'] ] == $status ) echo 'selected'; ?>><?php echo $status; ?></option>
                <?php
                }
                ?>
                </select>
                </div>
            </td>
            <td class="title">
                <div>
                    <input class="plan_table_input" type="text" value="<?php echo $subjob['subjob_title']; ?>" />
                </div>
            </td>
            <td class="during">
                <div class="during-wrap" style="position: relative;">
                    <font class="during-view" onClick=" $('.pick-during:visible').hide(); $(this).next().toggle(); ">
                        <span class="during-start-year" style="display: none;">
                        <?php echo substr($subjob['subjob_start_date'], 0, 4); ?>
                        </span>
                        <span class="during-end-year" style="display: none;">
                        <?php echo substr($subjob['subjob_end_date'], 0, 4); ?>
                        </span>
                        <span class="during-start-date">
                        <?php
                            //$start_date = preg_replace( '/^\d{4}-/', '', $subjob['subjob_start_date']); 
                            echo str_replace('-', '/', substr($subjob['subjob_start_date'], 5) );
                        ?>
                        </span>
                        ~
                        <span class="during-end-date">
                        <?php
                            //$end_date = preg_replace( '/^\d{4}-/', '', $subjob['subjob_end_date']); 
                            echo str_replace('-', '/', substr($subjob['subjob_end_date'], 5) );
                        ?>
                        </span>
                    </font><!--
                 --><div class="pick-during" style="top: 2px; left: 102px;">
                            <div style="text-align: right;">
                                <a href="javascript:;" onClick="$(this).parent().parent().stop().toggle(300);" class="closex"></a>
                            </div>
                            <div class="during-box">
                                <div>開始日期&nbsp;&nbsp;<input type="text" name="main_job_sdate" class="date-pick start-date" title="開始日期" value="<?php echo str_replace('-', '/', $subjob['subjob_start_date']); ?>" readonly /></div>
                                <div>結束日期&nbsp;&nbsp;<input type="text" name="main_job_edate" class="date-pick end-date" title="結束日期" value="<?php echo str_replace('-', '/', $subjob['subjob_end_date']); ?>" readonly /></div>
                                <div style="width: auto; text-align: right; padding: 5px 2px;">
                                    <div class="during-submit" style="">
                                        <a class="" href="javascript:;" onClick="if( checkDateIsEmpty( $(this) ) ) { updateJob( $(this).parents('.subjob'), 'subjob', <?php echo $subjob['subjob_id']; ?>, 3 ); } ">確定</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </td>
            <td class="description">
                <div>
                    <input class="plan_table_input" type="text" value="<?php echo $subjob['subjob_description']; /*if(!$subjob['subjob_description']) { echo '&nbsp;'; }*/ ?>" />
                </div>
            </td>
            <td class="operation" style="border-right: none;">
                <div>
                    <a href="javascript:;" class="button update" onClick=" updateJob( $(this).parents('.subjob'), 'subjob', <?php echo $subjob['subjob_id']; ?>, 1 ); ">確定</a><!--
           -->&nbsp;<a href="javascript:;" class="button" onClick=" deleteJob( $(this).parents('.subjob'), 'subjob', <?php echo $subjob['subjob_id']; ?> ); ">刪除
                    </a>
                </div>
            </td>
        </tr>
        <?php
                }
            }
        }
        
        /*
         At least 16 rows in table
        */
        $padding_row = 16 - $dataRows;
        for( $i = 0; $i < $padding_row ; $i++ ) {
        ?>
        <tr class="<?php if(  $rowNumber++ % 2 ) { echo 'grayLine'; } ?>">
            <td class="priority="></td><td class="status"></td><td class="title"></td><td class="during"></td><td class="description"></td><td class="operation" style="border-right: none;"></td>
        </tr>
        <?php
        }
        
        ?>
    </tbody>
</table>
<div class="data_table_tail center"></div>

<script type="text/javascript">
$(function(){

    $('.selectlist').chosen({disable_search_threshold: 10});

    Date.firstDayOfWeek = 0;
    Date.format = 'yyyy/mm/dd';

    $('.cal_btn').bind('click', function(){
        $('.pick-during:visible').hide();
        $(this).next('.pick-during').stop().toggle();
    });
    
    datepickers();

    keepTitleAndDescription();

    $('.sub_job_input:last').on('keyup', function(){ addSubJob(); });

});

function selfDuring() {
    var selfDuring = ['<form id="selfDuring" method="post" class="inlinebox" style="width: 100%;">',
                          '<div style="text-align: left; padding-left: 24px;">',
                            '<div class="inlinebox" style="width: 24px;"">從</div>',
                            '<input type="text" name="selfLastDate" class="date-pick" style="width: 120px; text-align: center;" readonly />',
                          '</div>',
                          '<div style="text-align: left; padding-left: 24px; margin-top: 10px;">',
                            '<div class="inlinebox" style="width: 64px;">往前返回</div>',
                            '<select name="selectedDuring" style="width: 82px;">',
                                '<option>7天</option>',
                                '<option>14天</option>',
                                '<option>30天</option>',
                                '<option>60天</option>',
                            '</select>',
                          '</div>',
                     '</form>'].join('');
    $.confirm({
        'title'     : '<b class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 12px; height: 18px;">期間</b>',
        'content'   : selfDuring,
        'width'     : '240',
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() { datepickers(); },
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'action': function(){
                    $('#selfDuring').submit();
                }
            }
        }
    });
}

function datepickers() {
    $('.date-pick').each(function() {
        var sDate = '1900/01/01';
        var eDate = null;
        if( $(this).parents('tr:first').hasClass('job') || $(this).parents('tr:first').hasClass('subjob') ) {
            if( $(this).hasClass('start-date') ) {
                eDate = $(this).parent().next().find('.end-date').val();
                if( $(this).val() != eDate ) {
                    $(this).datePicker({startDate: sDate, endDate: eDate, clickInput:true, createButton: false, showYearNavigation: false, horizontalOffset: -243});
                }
                else {
                    $(this).datePicker({startDate: '1900/01/01', clickInput:true, createButton: false, showYearNavigation: false, horizontalOffset: -243});
                }
            }
            else if( $(this).hasClass('end-date') ) {
                sDate = $(this).parent().prev().find('.start-date').val();
                if( $(this).val() != sDate ) {
                    $(this).datePicker({startDate: sDate, clickInput:true, createButton: false, showYearNavigation: false, horizontalOffset: -243});
                }
                else {
                    $(this).datePicker({startDate: '1900/01/01', clickInput:true, createButton: false, showYearNavigation: false, horizontalOffset: -243});
                }
            }
        }
        else{
            $(this).datePicker({startDate: sDate, clickInput:true, createButton: false, showYearNavigation: false, horizontalOffset: -243});
        }
    });
    $('.start-date').on( 'dpClosed', function(e, selectedDates) {
            var d = selectedDates[0];
            //alert(d);
            if (d) {
                d = new Date(d);
                $(this).parent().next().find('.end-date').dpSetStartDate(d.addDays(0).asString());
            }
    });
    $('.end-date').on( 'dpClosed', function(e, selectedDates) {
            var d = selectedDates[0];
            if (d) {
                d = new Date(d);
                $(this).parent().prev().find('.start-date').dpSetEndDate(d.addDays(0).asString());
            }
    });
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function keepTitleAndDescription() {
    $('.job, .subjob').each(function() {
        $(this).on('click', function() {
            if( !$(this).hasClass('onEdit') ) {
                $('.onEdit').each(function() {
                    $(this).find('.title .plan_table_input').prop('value', $(this).find('.title .kTitle').text());
                    $(this).find('.title .kTitle').remove();
                    $(this).find('.description .plan_table_input').prop('value', $(this).find('.description .kDescription').text());
                    $(this).find('.description .kDescription').remove();
                    $(this).removeClass('onEdit');
                });
                $(this).addClass('onEdit');
                $(this).find('.title').append('<div class="kTitle" style="display: none;">'+ escapeHtml($.trim( $(this).find('.title .plan_table_input').val() )) +'</div>');
                $(this).find('.description').append('<div class="kDescription" style="display: none;">'+ escapeHtml($.trim( $(this).find('.description .plan_table_input').val() )) +'</div>');
            }
        });
    });
}

function checkDateIsEmpty( $a ) {
    $.fn.reverse = [].reverse;
    var IsNotEmpty = true;
    $a.parents('.pick-during').find('input').each(function(){
        if( $(this).val().trim() == '' ) {
            alert($(this).attr('title') + '不能為空');
            IsNotEmpty = false;
            return false;
        }
        IsNotEmpty = true;
    });

    if( parseInt( $a.parents('.pick-during').find('.start-date').val().replace(/\//g, '') ) > parseInt( $a.parents('.pick-during').find('.end-date').val().replace(/\//g, '') ) ) {
        alert('During is error.');
        return false;
    }

    if( IsNotEmpty ) {
        $a.parents('.pick-during').toggle(300);
        var sdate = $a.parents('.pick-during').find('.start-date').val();
        var edate = $a.parents('.pick-during').find('.end-date').val();
        $a.parents('.during-wrap').find('.during-start-year').text(sdate.match(/^(\d{4})\/\d{2}\/\d{2}/)[1]);
        $a.parents('.during-wrap').find('.during-end-year').text(edate.match(/^(\d{4})\/\d{2}\/\d{2}/)[1]);
        $a.parents('.during-wrap').find('.during-start-date').text(sdate.match(/^\d{4}\/(\d{2}\/\d{2})/)[1]);
        $a.parents('.during-wrap').find('.during-end-date').text(edate.match(/^\d{4}\/(\d{2}\/\d{2})/)[1]);
        return true;
    }
}

function addSubJob() {
    if( $.trim( $('.sub_job_input:last').prop('value') ) != '' ) {
        
        $('.sub_job_input:last').unbind('keyup');

        $.get('job/plan/plan_cpts/subjob.html', function(result){
            $("#sub_job_list").append(result);

            $('.sub_job_input:last').on('keyup', function(){addSubJob();});
            // date-picker config
            $('.sub_job:last .cal_btn').bind('click', function(){
                $('.pick-during:visible').hide();
                $(this).next().stop().toggle();
            });
            datepickers();
        });
    }
}

function updateJob( $job, jobType, jobID, uptype ) {
    var priority = $job.find('.priority select').val();
    var status = $job.find('.status select').val();
    var title = $.trim($job.find('.title input').val());
    var sdate = $.trim($job.find('.during .during-start-year').text())+'/'+$.trim($job.find('.during .during-start-date').text());
    var edate = $.trim($job.find('.during .during-end-year').text())+'/'+$.trim($job.find('.during .during-end-date').text());
    var description = $.trim($job.find('.description input').val());

    // Check start date is early than end date
    if( parseInt( sdate.replace(/\//g, '') ) > parseInt( edate.replace(/\//g, '') )  ) {
        alert( 'Date During is Error.' );
        return false;
    }
    
    $.post( 'job/plan/plan_functions/planning/job_updating.php', 
            { job_type: jobType,
              job_id: jobID,
              job_priority: priority,
              job_status: status,
              job_title: $.trim( title ),
              job_start_date: sdate.replace(/\//g, '-'),
              job_end_date: edate.replace(/\//g, '-'),
              job_description: description,
              updateType: uptype
            },
            function(res) { 
                if( res.match(/^success/) ) {
                    if( jobType == 'subjob' ) {
                        var $pjob = $job.prevAll('.job:first');
                        var psdate = $.trim($pjob.find('.during .during-start-year').text())+'/'+$.trim($pjob.find('.during .during-start-date').text());
                        var pedate = $.trim($pjob.find('.during .during-end-year').text())+'/'+$.trim($pjob.find('.during .during-end-date').text());

                        if( parseInt( sdate.replace(/\//g, '') ) < parseInt( psdate.replace(/\//g, '') ) ) {
                            $pjob.find('.during .during-start-year').text( $job.find('.during .during-start-year').text() );
                            $pjob.find('.during .during-start-date').text( $job.find('.during .during-start-date').text() );
                            $pjob.find('.during .date-pick.start-date').prop('value', sdate );
                        }
                        if( parseInt( edate.replace(/\//g, '') ) > parseInt( pedate.replace(/\//g, '') ) ) {
                            $pjob.find('.during .during-end-year').text( $job.find('.during .during-end-year').text() );
                            $pjob.find('.during .during-end-date').text( $job.find('.during .during-end-date').text() );
                            $pjob.find('.during .date-pick.end-date').prop('value', edate );
                        }
                    }
                    else if( jobType == 'job' ) {
                        var $subjobs = $job.nextUntil('.job', '.subjob');
                        $subjobs.each(function() {
                            var $subjob = $(this);
                            var ssdate = $.trim($subjob.find('.during .during-start-year').text())+'/'+$.trim($subjob.find('.during .during-start-date').text());
                            var sedate = $.trim($subjob.find('.during .during-end-year').text())+'/'+$.trim($subjob.find('.during .during-end-date').text());

                            if( parseInt( ssdate.replace(/\//g, '') ) < parseInt( sdate.replace(/\//g, '') )
                                ||
                                parseInt( ssdate.replace(/\//g, '') ) > parseInt( edate.replace(/\//g, '') ) ) {
                                
                                $subjob.find('.during .during-start-year').text( $job.find('.during .during-start-year').text() );
                                $subjob.find('.during .during-start-date').text( $job.find('.during .during-start-date').text() );
                                $subjob.find('.during .date-pick.start-date').prop('value', sdate );
                            }
                            if( parseInt( sedate.replace(/\//g, '') ) > parseInt( edate.replace(/\//g, '') )
                                ||
                                parseInt( sedate.replace(/\//g, '') ) < parseInt( sdate.replace(/\//g, '') ) ) {
                                
                                $subjob.find('.during .during-end-year').text( $job.find('.during .during-end-year').text() );
                                $subjob.find('.during .during-end-date').text( $job.find('.during .during-end-date').text() );
                                $subjob.find('.during .date-pick.end-date').prop('value', edate );
                            }
                        });
                    }
                    if( uptype == 1 ) {
                        $job.find('.title .kTitle').text( $.trim( title ) );
                        $job.find('.description .kDescription').text( description );
                    }
                    datepickers();
                }
                else {
                    alert('failed');
                }
            } 
    );
}

function deleteJob( $job, jobType, jobID ) {
    $.confirm({
        'title'     : '<div class="inlinebox" style="height: 18px;">&nbsp;</div>',
        'content'   : '<div style="text-align: left; padding-left: 16px;">請確認是否刪除?</div>',
        'width'     : '240',
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'action': function(){
                    $.post( 'job/plan/plan_functions/planning/job_deleting.php', 
                            { job_type: jobType, job_id: jobID },
                            function(res) { 
                                if( res.match(/success/) ) {
                                    var subjobNum = 0;
                                    if( jobType == 'job' ) {
                                        subjobNum = $job.nextUntil('.job', '.subjob').length;
                                        $job.nextUntil('.job', '.subjob').fadeOut(500, function(){ $(this).remove(); });
                                    }
                                    $job.fadeOut(550, function(){
                                        if( $('#plan_table > tbody > tr').length - (1+subjobNum) < 16 ) {
                                            var paddingRows = (1+subjobNum);
                                            if( $('#plan_table > tbody > tr').length < 17 ) {
                                                for(var i=0; i < paddingRows ; i++) {
                                                    $('#plan_table > tbody').append('<tr><td class="priority="></td><td class="status"></td><td class="title"></td><td class="during"></td><td class="description"></td><td class="operation" style="border-right: none;"></td></tr>');
                                                }
                                            }
                                        }
                                        var $nextRows = $(this).nextAll('tr');
                                        $(this).remove();
                                        $nextRows.each(function(){
                                                if( $(this).prev().hasClass('grayLine') ) {
                                                    $(this).removeClass('grayLine');
                                                }
                                                else {
                                                    $(this).addClass('grayLine');   
                                                }
                                        });
                                    });
                                }
                            } 
                    );
                    return true;
                }
            },
            '取消'    : {
                'class' : 'gray',
                'action': function(){ return true; }
            }
        }
    });

}
</script>
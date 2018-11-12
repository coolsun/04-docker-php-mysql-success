<?php
// Show Client view
$job_status = array('狀態', '未開始',  '執行中', '以完成', '延遲');
$job_weights = array('高', '中','低');
$durings = array('期間', '7天', '14天',  '30天', '自訂');

$query_jobs = $dbh->prepare('SELECT `job_id`, `job_title`, `job_priority`, `job_status`, `job_start_date`, `job_end_date`, `job_description` FROM `jobs` WHERE `user_id` = ?');
$query_jobs->execute(array($_SESSION['userid']));
$job_dataset = $query_jobs->fetchAll(PDO::FETCH_ASSOC);

$query_subjobs = $dbh->prepare('SELECT `parent_job_id`, `subjob_title`, `subjob_priority`, `subjob_status`, `subjob_start_date`, `subjob_end_date`, `subjob_description` FROM `subjobs` WHERE `user_id` = ?');
$query_subjobs->execute(array($_SESSION['userid']));
$subjob_dataset = $query_subjobs->fetchAll(PDO::FETCH_ASSOC);

/*
 Data rows
*/
 $dataRows = count( $job_dataset ) + count( $subjob_dataset );

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
?>

<div id="plan_planning_panel" class="center">
    <form id="jobs_plan" action="job/plan/plan_functions/planning/jobs_saving.php" method="post">
        <div id="main_job_list">
            <div id="main_job">
                <input class='center main_job_input' type='text' name='main_job_title' placeholder='工作項目......' /><!--
             --><a href="javascript:;" class="picbutton cal_btn">時程</a><!--
             --><div class="pick-during">
                    <div style="text-align: right;">
                        <a href="javascript:;" onClick="$(this).parent().parent().stop().toggle(300);"><img src="/demo/img/closex.png" border="0" /></a>
                    </div>
                    <div class="during">
                        <div>開始日期&nbsp;&nbsp;<input type="text" name="main_job_sdate" class="date-pick start-date" style="width: 80px;" title="開始日期" /></div>
                        <div>結束日期&nbsp;&nbsp;<input type="text" name="main_job_edate" class="date-pick end-date" style="width: 80px;" title="結束日期"/></div>
                        <div class="during-submit" style="">
                            <a class="" href="javascript:;" onClick="checkDateIsEmpty( $(this) );">確定</a>
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
                <select>
                <?php 
                foreach( $job_status as $status ) {
                ?>
                    <option><?php echo $status; ?></option>
                <?php
                }
                ?>
                </select>
                <select>
                <?php 
                foreach( $durings as $during ) {
                ?>
                    <option><?php echo $during; ?></option>
                <?php
                }
                ?>
                </select>
            </td>
            <td colspan="2" style="text-align: right;">
            <?php 
            foreach( $sas[ $ma ] as $subaction => $subaction_name ) {
            ?>
                <a href="#" class="<?php if($sa == $subaction) echo 'on'; ?> button"><?php echo $subaction_name; ?></a>
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
            <td class="thead operation"></td>
        </tr>
    </thead>
</table>
<div id="jobs_table">
        <?php
        // Delete the unvalid status
        array_shift( $job_status );
        /*
         Jobs Loop
        */
        $rowNumber = 0;
        foreach( $job_dataset as $index => $job ) {
        ?>
        <div class="<?php if(  $rowNumber++ % 2 ) { echo 'even'; } ?> jobs_table_row">
            <div class="priority inlinebox">
                <select  class="">
                <?php 
                foreach( $job_weights as $weight ) {
                ?>
                    <option <?php if( $job_weights[ $job['job_priority'] ] == $weight ) echo "selected"; ?>><?php echo $weight; ?></option>
                <?php
                }
                ?>
                </select>
            </div><!--
         --><div class="status inlinebox">
                <select  class="">
                <?php 
                foreach( $job_status as $status ) {
                ?>
                    <option <?php if( $job_status[ $job['job_status'] ] == $status ) echo "selected"; ?>><?php echo $status; ?></option>
                <?php
                }
                ?>
                </select>

            </div><!--
         --><div class="title inlinebox">
                <div>
                    <?php echo $job['job_title']; ?>
                </div>
            </div><!--
         --><div class="during inlinebox">
                <font onClick=" $(this).next().toggle(); ">
                    <span>
                    <?php
                        $start_date = preg_replace( '/^\d{4}-/', '', $job['job_start_date']); 
                        echo str_replace('-', '/', $start_date);
                    ?>
                    </span>
                    ~
                    <span>
                    <?php
                        $end_date = preg_replace( '/^\d{4}-/', '', $job['job_end_date']); 
                        echo str_replace('-', '/', $end_date);
                    ?>
                    </span>
                </font>
            </div><!--
         --><div class="description inlinebox"><?php echo $job['job_description']; ?></div><!--
         --><div class="operation inlinebox" style="border-right: none;">
                    <a href="javascript:;" class="button">確定</a><!--
                 -->&nbsp;<a href="javascript:;" class="button">刪除</a>
            </div>
        </div>
        <?php
            /*
                Sub Jobs Loop
            */
            if( isset( $subjob_dataset[ $job['job_id'] ] ) ) {
                foreach( $subjob_dataset[ $job['job_id'] ] as $subindex => $subjob ) {
        ?>
        <div class="<?php if( $rowNumber++ % 2 ) { echo 'even'; } ?> jobs_table_row">
            <div class="priority inlinebox">
                <select  class="">
                <?php 
                foreach( $job_weights as $weight ) {
                ?>
                    <option <?php if( $job_weights[ $subjob['subjob_priority'] ] == $weight ) echo "selected"; ?>><?php echo $weight; ?></option>
                <?php
                }
                ?>
                </select>
            </div><!--
         --><div class="status inlinebox">
                <select class="">
                <?php 
                foreach( $job_status as $status ) {
                ?>
                    <option <?php if( $job_status[ $subjob['subjob_status'] ] == $status ) echo "selected"; ?>><?php echo $status; ?></option>
                <?php
                }
                ?>
                </select>

            </div><!--
         --><div class="title inlinebox">
                <div>
                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $subjob['subjob_title']; ?>
                </div>
            </div><!--
         --><div class="during inlinebox">
                <font onClick=" $(this).next().toggle(); ">
                    <span>
                    <?php
                        $start_date = preg_replace( '/^\d{4}-/', '', $subjob['subjob_start_date']); 
                        echo str_replace('-', '/', $start_date);
                    ?>
                    </span>
                    ~
                    <span>
                    <?php
                        $end_date = preg_replace( '/^\d{4}-/', '', $subjob['subjob_end_date']); 
                        echo str_replace('-', '/', $end_date);
                    ?>
                    </span>
                </font>
            </div><!--
         --><div class="description inlinebox"><?php echo $subjob['subjob_description']; ?></div><!--
         --><div class="operation inlinebox" style="border-right: none;">
                    <a href="javascript:;" class="button">確定</a><!--
                 -->&nbsp;<a href="javascript:;" class="button">刪除</a>
            </div>
        </div>
        <?php
                }
            }
        }
        
        //$padding_row = 20 - count( $job_dataset ) - count( $subjob_dataset );
        $padding_row = 20 - $dataRows;
        for( $i = 0; $i < $padding_row ; $i++ ) {
        ?>
        <div class="<?php if(  $rowNumber++ % 2 ) { echo 'even'; } ?>">
            <div class="priority inlinebox"></div><div class="status inlinebox"></div><div class="title inlinebox"></div><div class="during inlinebox"></div><div class="description inlinebox"></div><div class="operation inlinebox" style="border-right: none;"></div>
        </div><!--
     -->
        <?php
        }
        
        ?>
</div>
<div class="data_table_tail center"></div>

<script type="text/javascript">
$(function(){

    //$('.chosen-select').chosen({disable_search_threshold: 10});
    //$('.selectpicker').selectpicker();


    Date.firstDayOfWeek = 0;
    Date.format = 'yyyy/mm/dd';

    // date-picker config
    $('.cal_btn').bind('click', function(){
        $(this).next().stop().toggle(300);
    });
    
    datapicker(); 

    // inital subjob config
    //$('.sub_job_input:last').on('input change', function(){ addSubJob(); });
    $('.sub_job_input:last').on('keyup', function(){ addSubJob(); });

});

// Data picker binding
function datapicker() {
    $('.date-pick').datePicker({startDate:'01/01/1996', clickInput:true, createButton: false, showYearNavigation: false, horizontalOffset: -255});
    $('.start-date').bind( 'dpClosed', function(e, selectedDates) {
            var d = selectedDates[0];
            //alert(d);
            if (d) {
                d = new Date(d);
                $(this).parent().next().find('.end-date').dpSetStartDate(d.addDays(0).asString());
            }
    });
    $('.end-date').bind( 'dpClosed', function(e, selectedDates) {
            var d = selectedDates[0];
            if (d) {
                d = new Date(d);
                $(this).parent().prev().find('.start-date').dpSetEndDate(d.addDays(0).asString());
            }
    });
}

// Check date input is empty ?
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

    if( IsNotEmpty ) {
        $a.parents('.pick-during').toggle(300); 
    }
}

// Add subjob when click the last subjob input
function addSubJob() {
    if( $.trim( $('.sub_job_input:last').prop('value') ) != '' ) {
        //$('.sub_job_input:last').unbind('input').unbind('change');
        $('.sub_job_input:last').unbind('keyup');

        $.get('job/plan/plan_cpts/subjob.html', function(result){
            $("#sub_job_list").append(result);

            //$('.sub_job_input:last').on('input change', function(){addSubJob();});
            $('.sub_job_input:last').on('keyup', function(){addSubJob();});
            // date-picker config
            $('.sub_job:last .cal_btn').bind('click', function(){
                $(this).next().stop().toggle(300);
            });
            datapicker();
        });
    }
}
</script>
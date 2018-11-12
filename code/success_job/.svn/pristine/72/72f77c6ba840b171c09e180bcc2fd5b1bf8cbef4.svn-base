<?php
$business_status = array( '報價', '開案', '出貨', '流標' );

// Post-Redirect-Session
if( isset($_POST['searchFor']) ) {
    $_SESSION['searchFor'] = $_POST['searchFor'];
    // Redirect to this page.
    ob_end_clean();
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
else {
    $_POST['searchFor'] = $_SESSION['searchFor'];
    unset( $_SESSION['searchFor'] );
}

/*
 Get last business No.
*/
try {
    $getLastBusinessNo = $dbh->prepare('SELECT `business_last_no`, `business_num`, `business_max_num` FROM `businesses_metadata` WHERE `user_id` = ?;');
    $getLastBusinessNo->execute( array( $_SESSION['userid'] ) );
}
catch(Exception $e) {
    echo $e->getMessage();
}
$response = $getLastBusinessNo->fetch(PDO::FETCH_ASSOC);

/*
 If don't have existing last business No. data, create it.
*/
if( !count( $response ) || !$response ) {
    $initial = $dbh->prepare('INSERT INTO `businesses_metadata`(`user_id`, `business_last_no`, `business_num`, `business_max_num`) VALUES( ?, ?, ?, ? );');
    $initial->execute( array($_SESSION['userid'], 0, 0, 0) );
}
else {
    $thisBusinessNo = $response['business_last_no'];
    $businessNum = $response['business_num'];
    $businessMax = $response['business_max_num'];
}

/*
 If search not for special opportunity, Get the last opportunity
*/
if( isset($_POST['searchFor']) ) {
    $thisBusinessNo = $_POST['searchFor'];
}

$getLastOpportunity = $dbh->prepare('SELECT * FROM `businesses` WHERE `user_id`=? AND `business_no`=? ');
$getLastOpportunity->execute( array( $_SESSION['userid'], $thisBusinessNo ) );
$opportunity = $getLastOpportunity->fetch(PDO::FETCH_ASSOC);
//print_r($opportunity);
?>

<script type="text/javascript" src="job/js/disableselect.js"></script>

<table cellspacing='0' class="business_table data_table center" style="width: 873px; border-radius: 3px 3px 0 0; vertical-align: top;">
	<thead>
		<tr>
			<td style="border-radius: 3px 0 0 0; width: 152px; padding-left: 27px;">
				商機序號 : <span id="businessNo"><?php if($thisBusinessNo > 0) { echo $thisBusinessNo; } else { echo 0 ; } ?></span>
			</td>
            <td style="width: 202px;">
                日期 : <?php 
                    if( isset($opportunity['created_datetime']) ) { 
                        echo date('Y/m/d', strtotime( $opportunity['created_datetime'] ) ); 
                    }
                    else {
                        echo date('Y/m/d');
                    } ?>
            </td>
            <td style="width: 216px;">
                狀態 : 
                <select id="status" name="status" onChange="changeStatus();">
                <?php
                foreach( $business_status as $v => $status ) {
                ?>
                    <option value="<?php echo $v; ?>" <?php if( $opportunity['business_status'] == $v ) echo "selected"; ?> ><?php echo $status; ?></option>
                <?php
                }
                ?>
                </select>
            </td>
			<td style="border-radius: 0 3px 0 0; width: 302px;">
			<?php 
            foreach( $sas[ $ma ] as $subaction => $subaction_name ) {
                if( $subaction != 'opportunities' ) {
            ?>
                <a href="javascript:;" class="<?php echo $subaction; if($sa == $subaction) echo ' on'; ?> button"><?php echo $subaction_name; ?></a>    
            <?php
                    continue;
                }
            ?>
                <a href="?dept=job&ma=business&sa=<?php echo $subaction; ?>" class="<?php if($sa == $subaction) echo 'on'; ?> button"><?php echo $subaction_name; ?></a>
            <?php
            }
            ?>
			</td>
		</tr>
	</thead>
</table>
<div class="business_table_wrap">
    <div id="opportunities" class="inlinebox masked" style="width: 572px;">
        <form id="edit-form" method="post" action="job/business/business_functions/opportunities/opportunity_updating.php" >
            <input type="hidden" name="businessNo" value="<?php echo $thisBusinessNo; ?>" />
            <div class="mask"></div>
            <div>
                <div class="inlinebox label" style="height: 46px; line-height: 46px;">
                    <div class="inlinebox" style="border-bottom: 2px solid #aaa; height: 24px; line-height: 24px;"><b>客戶需求</b></div>
                </div>
            </div>
            <div class="business_data_row">
                <div class="inlinebox label">* 客戶名稱</div><!--
             --><div class="inlinebox long_input"><input type="text" id="clientName" name="clientName" value="<?php echo $opportunity['business_client_name']; ?>" /></div><!--
         --></div>
            <div class="business_data_row">
                <div class="inlinebox label">* 產品規格</div><!--
             --><div class="inlinebox long_input"><input type="text" id="requireProductStandard" name="requireProductStandard" value="<?php echo $opportunity['business_product_require_standard']; ?>" /></div><!--
         --></div>
            <div class="business_data_row description">
                <div class="inlinebox label">說明</div><!--
             --><div class="inlinebox textarea_input"><textarea id="requireDescription" name="requireDescription"><?php echo $opportunity['business_product_require_description']; ?></textarea></div><!--
         --></div>
            <div class="business_data_row">
                <div class="inlinebox label">* 需求數量</div><!--
             --><div class="inlinebox short_input"><input type="text" id="requireAmount" name="requireAmount" value="<?php echo $opportunity['business_product_require_amount']; ?>" /></div><div class="inlinebox label">需求日期</div><!--
             --><div class="inlinebox short_input"><input type="text" id="requireDate" class="pick-Date" name="requireDate" value="<?php if( $opportunity['business_product_require_date'] != 0) echo date('Y/m/d', $opportunity['business_product_require_date']); ?>" /></div><!--
         --></div>
            <div class="business_data_row">
                <div class="inlinebox label">產品應用</div><!--
             --><div class="inlinebox short_input"><input type="text" id="application" name="application" value="<?php echo $opportunity['business_product_application']; ?>" /></div><!--
             --><div class="inlinebox label">銷售區域</div><!--
             --><div class="inlinebox short_input"><input type="text" id="salesArea" name="salesArea" value="<?php echo $opportunity['business_product_sales_area']; ?>"/></div><!--
         --></div>
            <div class="business_data_row">
                <div class="inlinebox label">競爭者</div><!--
             --><div class="inlinebox short_input"><input type="text" id="competitor" name="competitor" value="<?php echo $opportunity['business_product_competitor']; ?>" /></div><!--
             --><div class="inlinebox label">未來預估量</div><!--
             --><div class="inlinebox short_input"><input type="text" id="expectedAmount" name="expectedAmount" value="<?php echo $opportunity['business_product_expected_amount'] ?>" /></div><!--
         --></div>
            <div>
                <div class="inlinebox label" style=" margin-top: 16px; height: 46px; line-height: 46px;">
                    <div class="inlinebox" style="border-bottom: 2px solid #aaa; height: 24px; line-height: 24px;"><b>我的提案</b></div>
                </div>
            </div>
            <div class="business_data_row">
                <div class="inlinebox label">* 產品規格</div><!--
             --><div class="inlinebox short_input"><input type="text" id="proposalProductStandard" name="proposalProductStandard" value="<?php echo $opportunity['business_product_proposal_standard']; ?>" /></div><!--
             --><div class="inlinebox label">型號</div><!--
             --><div class="inlinebox short_input"><input type="text" id="typeNumber" name="typeNumber" value="<?php echo $opportunity['business_product_type_number']; ?>" /></div><!--
         --></div>
            <div class="business_data_row">
                <div class="inlinebox label">* 產品售價</div><!--
             --><div class="inlinebox short_input"><input type="text" id="productPrice" name="productPrice" value="<?php echo $opportunity['business_product_price']; ?>" /></div><!--
             --><div class="inlinebox label">最小訂購量</div><!--
             --><div class="inlinebox short_input"><input type="text" id="minOrderNum" name="minOrderNum" value="<?php echo $opportunity['business_product_min_order_num']; ?>" /></div><!--
         --></div>
            <div class="business_data_row">
                <div class="inlinebox label">* 銷售成本</div><!--
             --><div class="inlinebox short_input"><input type="text" id="productCost" name="productCost" value="<?php echo $opportunity['business_product_cost']; ?>" /></div><!--
             --><div class="inlinebox label">交期(LT)</div><!--
             --><div class="inlinebox short_input"><input type="text" id="deliverDate" class="pick-Date" name="deliverDate" value="<?php if( $opportunity['business_product_deliver_date'] != 0 )echo date('Y/m/d', $opportunity['business_product_deliver_date']); ?>" /></div><!--
         --></div>
            <div class="business_data_row">
                <div class="inlinebox label">供應商</div><!--
             --><div class="inlinebox short_input"><input type="text" id="supplier" name="supplier" value="<?php echo $opportunity['business_product_supplier']; ?>" /></div><!--
             --><div class="inlinebox label">付款條件</div><!--
             --><div class="inlinebox short_input"><input type="text" id="paymentCondition" name="paymentCondition" value="<?php echo $opportunity['business_product_payment_condition']; ?>" /></div><!--
         --></div>
            <div class="business_data_row description">
                <div class="inlinebox label">說明</div><!--
             --><div class="inlinebox textarea_input"><textarea id="proposalDescription" name="proposalDescription"><?php echo $opportunity['business_product_proposal_description']; ?></textarea></div><!--
             --><div style="text-align: right; padding-right: 24px; height: 14px; line-height: 14px;">
                    <div class="inlinebox" style="font-size: 12px;">*為必填項目</div>
                </div>
            </div>
            <div style="text-align: right; padding-top: 10px; padding-right: 25px; height: 48px;">
                <a href="javascript:;" class="button edit-submit" style="padding: 3px 7px; vertical-align: bottom;" onClick="editOpportunity();">確 定</a>
            </div>
        </form>
    </div><!--
 --><div id="operation" class="inlinebox" style="width: 290px;">
        <a href="javascript:;" class="business_button button" onClick="addOpportunityStep1();">新增</a>
    <?php
    if( $thisBusinessNo && $businessNum ) {
    ?>
        <a href="javascript:;" class="business_button button" onClick="activateEditing();">編輯</a>
        <a href="javascript:;" class="business_button button" onClick="deleteOpportunity();">刪除</a>
    <?php
    }
    ?>
    </div>        
</div>

<script type="text/javascript">
$(function() {
    $('.search').on('click', function() { search(); });
    $('.analysis').on('click', function() { analysis(); });

    $('#opportunities.masked input, #opportunities.masked textarea').prop('readonly', true).disableSelection();

    Date.firstDayOfWeek = 0;
    Date.format = 'yyyy/mm/dd';

    $('.pick-Date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: -1, horizontalOffset: 165 });
});
</script>

<script type="text/javascript">
var clientName = '';
var requireProductStandard = '';
var requireAmount = 0;
var proposalProductStandard = '';
var productPrice = 0;
var productCost = 0;
var status = 0;
function addOpportunityStep1() {
    var step = '<div class="inlinebox" style="margin-top: 16px;"><img src="job/img/add_opportunity_step1.png"/></div>';
    var form = $.ajax({
        type: 'GET',       
        url: "job/business/business_cpts/addopportunitystep1.html",
        dataType: 'html',
        global: false,
        async:false,
        success: function(data) {
            return data;
        }
    }).responseText;

    $.confirm({
        'title'     : step,
        'content'   : form,
        'width'     : '340',
        'offset'    : -200,
        'unmask'    : true,
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'closeAction': 'clearTemp()',
        'loadAction' : function() {
            if( clientName != '' && requireProductStandard != '' && requireAmount != '' ) {
                $('#client_name').val( clientName );
                $('#product_standard').val( requireProductStandard );
                $('#require_amount').val( requireAmount );
            }
            $('#client_name').setfocus();
        },
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'nextAction' : function() { addOpportunityStep2(); },
                'action': function(){
                    clientName = $.trim( $('#client_name').val() );
                    requireProductStandard = $.trim( $('#product_standard').val() );
                    requireAmount = $.trim( $('#require_amount').val() );
                    if( clientName == '' || requireProductStandard == '' || requireAmount == '' || !$.isNumeric(requireAmount) ) {
                        $('.warningbox').fadeOut(50).fadeIn(100);
                        return false;
                    }
                    //alert(clientName+':'+requireProductStandard+':'+requireAmount);
                    return true;
                }
            }
        }
    });
}

function addOpportunityStep2() {
    var step = '<div class="inlinebox" style="margin-top: 16px;"><img src="job/img/add_opportunity_step2.png"/></div>';
    var form = $.ajax({
        type: 'GET',       
        url: "job/business/business_cpts/addopportunitystep2.html",
        dataType: 'html',
        global: false,
        async:false,
        success: function(data) {
            return data;
        }
    }).responseText;

    $.confirm({
        'title'     : step,
        'content'   : form,
        'width'     : '340',
        'offset'    : -200,
        'unmask'    : true,
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'closeAction': 'clearTemp()',
        'loadAction' : function() {
            if( proposalProductStandard != '' || productPrice != '' || productCost != '' ) {
                $('#product_standard').val( proposalProductStandard );
                $('#product_price').val( productPrice );
                $('#product_cost').val( productCost );
            }
            $('#product_standard').setfocus();
        },
        'buttons'   : {
            '< 返回' : {
                'nextAction' : function() { addOpportunityStep1(); },
                'action': function() {
                    proposalProductStandard = $.trim( $('#product_standard').val() );
                    productPrice = $.trim( $('#product_price').val() );
                    productCost = $.trim( $('#product_cost').val() );
                    return true;
                }
            },
            '確定'   : {
                'class' : 'gray',
                'nextAction' : function() { addOpportunityStep3(); },
                'action': function(){
                    proposalProductStandard = $.trim( $('#product_standard').val() );
                    productPrice = $.trim( $('#product_price').val() );
                    productCost = $.trim( $('#product_cost').val() );
                    if( proposalProductStandard == '' || productPrice == '' || productCost == '' || !$.isNumeric(productPrice) || !$.isNumeric(productCost) ) {
                        $('.warningbox').fadeOut(50).fadeIn(100);
                        return false;
                    }
                    return true;
                }
            }
        }
    });
}

function addOpportunityStep3() {
    var step = '<div class="inlinebox" style="margin-top: 16px;"><img src="job/img/add_opportunity_step3.png"/></div>';
    var form = $.ajax({
        type: 'GET',       
        url: "job/business/business_cpts/addopportunitystep3.html",
        dataType: 'html',
        global: false,
        async:false,
        success: function(data) {
            return data;
        }
    }).responseText;

    $.confirm({
        'title'     : step,
        'content'   : form,
        'width'     : '340',
        'offset'    : -200,
        'unmask'    : true,
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'closeAction': 'clearTemp()',
        'loadAction' : function() {
            if( status != '' ) {
                //alert(status);
                $('input[name=status_choice][value='+status+']').prop('checked', true);
            }
        },
        'buttons'   : {
            '< 返回' : {
                'nextAction' : function() { addOpportunityStep2(); },
                'action': function() {
                    status = $('input[name=status_choice]:checked').val();
                    return true;
                }
            },
            '確定'   : {
                'class' : 'gray',
                'action': function(){
                    if( !$('input[name=status_choice]:checked').length ) {
                        $('.warningbox').fadeOut(50).fadeIn(100);
                        return false;
                    }
                    status = $('input[name=status_choice]:checked').val();

                    var form = ['<form id="addOpportunity" method="post" action="job/business/business_functions/opportunities/opportunity_saving.php" style="display: none;">',
                                    //'<input type="hidden" name="businessNo" value="'+(parseInt($('#businessNo').text())+1)+'" />',
                                    '<input type="hidden" name="businessNo" value="'+<?php echo ($businessMax+1); ?>+'" />',
                                    '<input type="hidden" name="clientName" value="'+clientName+'" />',
                                    '<input type="hidden" name="requireProductStandard" value="'+requireProductStandard+'" />',
                                    '<input type="hidden" name="requireAmount" value="'+requireAmount+'" />',
                                    '<input type="hidden" name="proposalProductStandard" value="'+proposalProductStandard+'" />',
                                    '<input type="hidden" name="productPrice" value="'+productPrice+'" />',
                                    '<input type="hidden" name="productCost" value="'+productCost+'" />',
                                    '<input type="hidden" name="status" value="'+status+'" />',
                                '</form>'].join('');

                    //alert(form);
                    $('body').append(form);
                    $('#addOpportunity').submit();

                    return true;
                }
            }
        }
    });
}

function clearTemp() {
    clientName = '';
    requireProductStandard = '';
    requireAmount = 0;
    proposalProductStandard = '';
    productPrice = 0;
    productCost = 0;
    status = 0;
}

function changeStatus() {
    var change_status = $('#status').val();
    //alert(change_status);
    $.ajax({
        type:"POST",
        data: { 'businessNo': parseInt($('#businessNo').text()), 'changeStatus': change_status },
        url:"job/business/business_functions/opportunities/opportunity_updating.php",
        dateType:"json",
        error:function(){
            alert("Failed.");
        },
        success:function( data ){
            if( data.match(/^success/) ) {
            }
        }

    });
}

function activateEditing() {
    $('#opportunities.masked input:not(.pick-Date), #opportunities.masked textarea').prop('readonly', false).enableSelection();;
    $('#opportunities.masked').removeClass('masked');
    //$('#clientName').setfocus();
}

function editOpportunity() {
    $('#edit-form').submit();
}

function deleteOpportunity() {
    $.confirm({
        'title'     : '<div class="inlinebox" style="height: 18px;">&nbsp;</div>',
        'content'   : '<div style="text-align: left; padding-left: 16px;">請確認是否刪除?</div>',
        'width'     : '240',
        //'messageIcon' : 'job/img/exclamation.png',
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'action': function(){
                    var form = ['<form id="deleteOpportunity" method="post" action="job/business/business_functions/opportunities/opportunity_deleting.php" style="display: none;">',
                    '<input type="hidden" name="no" value="'+(parseInt($('#businessNo').text()))+'" />',
                '</form>'].join('');

                    $('body').append(form);
                    $('#deleteOpportunity').submit();
                    return true;
                }
            },
            '取消'    : {
                'class' : 'gray',
                'action': function(){ return true; }  // Nothing to do in this case. You can as well omit the action property.
            }
        }
    });
}

function search() {
    var title = '<div class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 14px; height: 24px;"><b>查詢商機</b></div>';
    var form = $.ajax({
        type: 'GET',       
        url: "job/business/business_cpts/search_form.html",
        dataType: 'html',
        global: false,
        async:false,
        success: function(data) {
            return data;
        }
    }).responseText;

    var result;

    $.confirm({
        'title'     : title,
        'content'   : form,
        'width'     : '330',
        'position'  : 'absolute',
        'offset'    : (document.body.offsetWidth / 2) - 105,
        'voffset'   : 300,
        'unmask'    : false,
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() {
            $('.start-date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 22, horizontalOffset: 0 });
            $('.end-date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 22, horizontalOffset: 0 });
            $('.start-date').on( 'dpClosed', function(e, selectedDates) {
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        $('.end-date').dpSetStartDate(d.addDays(0).asString());
                    }
            });
            $('.end-date').on( 'dpClosed', function(e, selectedDates) {
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        $('.start-date').dpSetEndDate(d.addDays(0).asString());
                    }
            });
        },
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'nextAction' : function() { showSearchResult( result ); /*alert( result.resultTable );*/ },
                'action': function(){
                    var params = [];
                    var test = '';
                    $('#search-form input').each(function() {
                        var tclass = $(this).prop('class').split(/\s+/);
                        tclass = tclass[0].replace(/search-/,'');
                        var tvalue = $.trim( $(this).val() );

                        params.push( { 'name': tclass, 'value': tvalue } );
                    });
                    params.push( { 'name': 'status', 'value': $('#search-form .search-status').val() } );
                    $.ajax({
                        type: 'POST',       
                        url: "job/business/business_functions/opportunities/opportunities_searching.php",
                        data: params,
                        dataType: 'json',
                        global: false,
                        async:false,
                        success: function(data) {
                            result = data;
                            return data;
                        }
                    });
                    return true;
                }
            }
        }
    });
}

function showSearchResult( result ) {
    var title = '<div class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 14px; height: 24px;"><b>查詢結果</b></div><div class="inlinebox" style="position: relative; top: 4px; left:65px; font-size: 14px; height: 24px;"><b>共計 '+result.num+' 筆</b></div>';
    $.confirm({
        'title'     : title,
        'content'   : result.resultTable,
        'width'     : 750,
        'position'  : 'absolute',
        'offset'    : (document.body.offsetWidth / 2) - 256,
        'voffset'   : 280,
        'unmask'    : false,
        //'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() {
            $('.search-results .data-row').on('click', function() {
                var form = ['<form id="searchFor" method="post" action="?dept=job&ma=business&sa=opportunities">','<input type="hidden" name="searchFor" value="',$(this).find('.b_no').text(),'" />','</form>'].join('');
                $('body').append(form);
                $('#searchFor').submit();
            });
        },
        'buttons'   : false
    });

}

function analysis() {
    var title = '<div class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 14px; height: 24px;"><b>銷售分析</b></div>';
    var form = $.ajax({
        type: 'GET',       
        url: "job/business/business_cpts/analysis_form.html",
        dataType: 'html',
        global: false,
        async:false,
        success: function(data) {
            return data;
        }
    }).responseText;

    $.confirm({
        'title'     : title,
        'content'   : form,
        'width'     : '330',
        'position'  : 'absolute',
        'offset'    : (document.body.offsetWidth / 2) - 105,
        'voffset'   : 300,
        'unmask'    : false,
        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
        'loadAction' : function() {
            $('.start-date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 22, horizontalOffset: 0 });
            $('.end-date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: 22, horizontalOffset: 0 });
            $('.start-date').on( 'dpClosed', function(e, selectedDates) {
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        $('.end-date').dpSetStartDate(d.addDays(0).asString());
                    }
            });
            getListOfPoC(0, 0);
        },
        'buttons'   : {
            '確定'   : {
                'class' : 'gray',
                'action': function(){
                    if( $.trim($('.list').val()) == '' || $.trim( $('.start-date').val() ) == '' || $.trim( $('.end-date').val() ) == '' ) {
                        $('.warningbox').fadeOut(50).fadeIn(100);
                        return false;
                    }
                    var form = ['<form id="analysisFor" method="post" action="?dept=job&ma=business&sa=analysis">',
                                    '<input type="hidden" name="selectedStatus" value="',$.trim($('.selectedStatus').val()),'" />',
                                    '<input type="hidden" name="classPoC" value="',$.trim($('.classPoC').val()),'" />',
                                    '<input type="hidden" name="namePoC" value="',$.trim($('.list').val()),'" />',
                                    '<input type="hidden" name="sdate" value="',$.trim($('.start-date').val()),'" />',
                                    '<input type="hidden" name="edate" value="',$.trim($('.end-date').val()),'" />',
                                '</form>'].join('');
                    $('body').append(form);
                    $('#analysisFor').submit();
                    return true;
                }
            }
        }
    });
}

function changeList() {
    var selectedStatus = $('.selectedStatus').val();
    var classPoC = $('.classPoC').val();
    getListOfPoC( selectedStatus, classPoC );
}

// Get list of Product or Client
function getListOfPoC( selectedStatus, classPoC ) {
    $.ajax({
        type: 'POST',       
        url: "job/business/business_functions/opportunities/opportunities_analysis.php",
        data: { 'status': selectedStatus, 'class': classPoC },
        dataType: 'json',
        global: false,
        async:false,
        success: function(data) {      
            $('.list').html('');   
            for( var key in data.list ) {
                $('.list').append('<option>'+data.list[key].name+'</option>');
            }
            return true;
        }
    });
}

(function($)  
{  
    jQuery.fn.setfocus = function()  
    {  
        return this.each(function()  
        {  
            var dom = this;  
            setTimeout(function()  
            {  
                try { dom.focus(); } catch (e) { }   
            }, 0);  
        });  
    };  
})(jQuery);  
</script>
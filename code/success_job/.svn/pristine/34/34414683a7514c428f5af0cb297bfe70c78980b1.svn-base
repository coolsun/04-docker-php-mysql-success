<?php
header("Cache-control: private");
$limit_length = 200;

$get_jobnote_sql = 'SELECT `jobnote_id`, `jobnote_title`, `jobnote_content`, `created_datetime` FROM `jobnotes` WHERE `user_id`=? ';
$get_jobnote_params = array($_SESSION['userid']);

if( isset($_POST['selectedDate']) && $_POST['selectedDate'] != '' ) {
	$get_jobnote_sql .= 'AND (`created_datetime` BETWEEN ? AND ?) ';
	array_push( $get_jobnote_params, date('Y-m-d 00:00:00', strtotime($_POST['selectedDate'])) );
	array_push( $get_jobnote_params, date('Y-m-d 23:59:59', strtotime($_POST['selectedDate'])) );
}
elseif( isset($_POST['sdate']) && $_POST['sdate'] != '' && isset($_POST['edate']) && $_POST['edate'] != '' ) {
	$get_jobnote_sql .= 'AND (`created_datetime` BETWEEN ? AND ?) ';
	array_push( $get_jobnote_params, date('Y-m-d 00:00:00', strtotime($_POST['sdate'])) );
	array_push( $get_jobnote_params, date('Y-m-d 23:59:59', strtotime($_POST['edate'])) );
}

$get_jobnote_sql .= 'ORDER BY `created_datetime` DESC;';
$get_jobnote = $dbh->prepare($get_jobnote_sql);
$get_jobnote->execute( $get_jobnote_params );
$jobnotes = $get_jobnote->fetchAll(PDO::FETCH_ASSOC);

function splitParagraph($html){
	//return preg_split('/<[^>]*[^\/]>/i', $html, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE);
	return preg_split('/<p>|<\/p>|<div>|<\/div>/i', $html, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
}
function splitHTML($html) {
	/*$startfromtag = false;
	if( preg_match('/^<[^>]+>/i', $html, $tags) ) {
		$startfromtag = true;
	}*/
	//preg_match('/(\<[^>]+\>.*)\<[^>]+\>/s', $html, $tags);
	$html = preg_split('/(<[^>]+\>)/is', $html, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
	return $html;
}
?>
<table cellspacing='0' class="jobnote_table data_table center" style="width: 873px; vertical-align: top;">
	<thead>
		<tr>
			<td class="operation">
				<a href="?dept=job&ma=jobnote&sa=edit" id="addnew" class="button">新增</a>
				<a href="javascript:;" id="search" class="button">搜尋</a>
			</td>
		</tr>
	</thred>
</table>
<div class="jobnotes">
<?php
if(!count($jobnotes)) {
?>
<div style="text-align:center; line-height: 32px; font-size: 16px;">
<?php
	if($_POST['selectedDate']) {
		echo "於 ". $_POST['selectedDate'] ."<br>";
	}
	elseif($_POST['sdate'] && $_POST['edate']) {
		echo "於 ". $_POST['sdate'] ."~". $_POST['edate'] ."<br>";
	}
?>
查無日誌</div>
<?php
}
foreach( $jobnotes as $jobnote ) {
?>
	<div class="jobnote">
		<div class="meta">
			<div class="title">
				<a href="?dept=job&ma=jobnote&sa=view&jn=<?php echo $jobnote['jobnote_id']; ?>" style="font-size: 16px;">
					<?php echo $jobnote['jobnote_title'] ?>
				</a>
			</div>
			<div class="date" style="font-size: 14px;"><?php echo date('Y/m/d', strtotime($jobnote['created_datetime'])); ?></div>
		</div>
		<div class="content">
			<?php
				$jobnote['jobnote_content'] = preg_replace("/\\n|\\r/ius", "", $jobnote['jobnote_content']);
				$decoded_contnet = html_entity_decode($jobnote['jobnote_content'], ENT_QUOTES, 'UTF-8');
				$content_length = mb_strlen( strip_tags( $decoded_contnet ), 'UTF-8' );
				
				if( $content_length < 1 ) {
					echo $jobnote['jobnote_content'];	
				}
				else {
					$paragraphs = splitParagraph($decoded_contnet);
					//var_dump( convertHtmlTag($paragraphs) );
					$sum_length = 0;
					foreach($paragraphs as $paragraph) {
						$paragraph_length = mb_strlen( strip_tags( $paragraph ), 'UTF-8' );
						$sum_length += $paragraph_length;
						//echo '<p>'. strip_tags( $paragraph, '<ol><ul><li><br><strong><b><i><em><u>' ) .'</p>';
						if($sum_length > $limit_length) {
							//echo '<p>'. mb_substr(strip_tags( $paragraph, '<br>' ), 0, $paragraph_length - ($sum_length - $limit_length), 'UTF-8');
							//echo ' ......<a href="?dept=job&ma=jobnote&sa=view&jn='. $jobnote['jobnote_id'] .'" style="color:#2C5DC3;">查看更多</a></p>';
							$lastParagraphHTML = splitHTML($paragraph);
							$nested = array();
							$prev_sum_length = $sum_length - $paragraph_length;
							foreach( $lastParagraphHTML as $element ) {
								if(preg_match('/^<[^>]+>/', $element)) {
									if( $element == "<br>" ) {
									}
									elseif( preg_match('/^<\//i', $element) ) {
										array_pop($nested);
									}
									else {
										array_push($nested, str_replace('<', '</', $element));
									}
									echo $element;
								}
								else {
									$text_length = mb_strlen( $element, 'UTF-8' );
									$prev_sum_length += $text_length;
									if( $prev_sum_length > $limit_length ) {
										echo mb_substr($element, 0, $text_length - ($prev_sum_length - $limit_length), 'UTF-8');
										echo ' <span style="font-weight:normal;font-style: normal;">......<a href="?dept=job&ma=jobnote&sa=view&jn='. $jobnote['jobnote_id'] .'" style="color:#2C5DC3;">查看更多</a></span>';
										foreach( $nested as $tag ) {
											echo $tag;
										}
										break;
									}
									else{
										echo $element;
									}
								}
							}
							break;
						}
						else {
							echo '<p>'. strip_tags( $paragraph, '<ol><ul><li><br><strong><b><i><em><u>' ) .'</p>';
						}
					}
				}
			?>
		</div>
	</div>
<?php
}
?>
</div>
<script type="text/javascript">
$(function() {
	$('#search').on('click', function() {
		var form = $.ajax({
		    type: 'GET',       
		    url: "job/jobnote/jobnote_cpts/search_form.html",
		    dataType: 'html',
		    global: false,
		    async:false,
		    success: function(data) {
		        return data;
		    }
		}).responseText;

		$.confirm({
			'title'     : '<div class="inlinebox" style="position: relative; top: 4px; left:10px; font-size: 14px; height: 24px;"><b>查詢日誌</b></div>',
	        'content'   : form,
	        'width'     : '330',
	        'position'  : 'absolute',
	        'offset'    : (document.body.offsetWidth / 2) - 105,
	        'voffset'   : 300,
	        'unmask'    : false,
	        'buttonDivCss': 'text-align: right; padding-right: 5px; margin-top: 10px;',
	        'loadAction' : function() {
	        	$('.pick-Date').datePicker({startDate: '1991/01/01', clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: -1, horizontalOffset: 180 });
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
	                'action': function(){
	                	var check = false;
	                	if( $('input[name=selectedDate]').val().match(/^\d{4}\/\d{2}\/\d{2}$/) ||
	                		($('input[name=sdate]').val().match(/^\d{4}\/\d{2}\/\d{2}$/) &&
	                		 $('input[name=edate]').val().match(/^\d{4}\/\d{2}\/\d{2}$/)) ) {
	                		return $('#search-form').submit();
	                	}
	                	$('.warningbox').show();
	                	return false;
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
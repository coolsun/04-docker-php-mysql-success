function accounts_ajax(func_name,func_params){
	if(window['accounts_ajax_post_'+func_name]===undefined){
		alert('參數錯誤');
		return;
	}
	window['accounts_ajax_post_'+func_name](func_params);
}
function accounts_ajax_post_bank_account_add(postdata){
	var postdata_json=JSON.stringify(postdata);
	$.ajax({
			'async':false,
			'url':'finance/accounts/accounts_functions/list/new.php',
			'data':{
				'data':postdata_json
			},
			'type':'POST',
			'dataType':'json',
			'success':function(returndata){
				if(returndata.status){
					accounts_ajax_return_bank_account_add(returndata);
				}else{
					alert(returndata.emsg);
				}
				
			},
			'error':function(){
			 alert('資料讀取失敗');
			}
	});
}

function accounts_ajax_return_bank_account_add(returndata){
	alert('操作成功,返回結果:'+JSON.stringify(returndata));
}
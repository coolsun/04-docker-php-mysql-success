var global_reg_required_signed_integer=/^[\d\-]{1}[\d]*$/;
var global_reg_optional_signed_integer=/(^$)|(^[\d\-]{1}[\d]*$)/;
var global_reg_required_unsigned_integer=/^[\d]{1}[\d]*$/;
var global_reg_optional_unsigned_integer=/(^$)|(^[\d]{1}[\d]*$)/;

function reg_validate_data(reg_name,thedata){
	if(window['global_reg_'+reg_name]===undefined){
		alert('°Ñ¼Æ¿ù»~');
		return false;
	}
	if(window['global_reg_'+reg_name].test(thedata)){
		return true;
	}else{
		return false;
	}
}
// 方便firefox直接跳出錯誤訊息
onerror = handleErr;
function handleErr(msg,url,l) {
    var handleErr_txt="";
    handleErr_txt  = "There was an error on this page.\n\n";
    handleErr_txt += "Error: " + msg + "\n";
    handleErr_txt += "URL: " + url + "\n";
    handleErr_txt += "Line: " + l + "\n\n";
    handleErr_txt += "Click OK to continue.\n\n";
    alert(handleErr_txt);
    return true;
}

// 檢查字串是否為指定格式
function check_string(str, type) {
    var pattern;
    switch ( type ) {
        case 'account': // 帳號
            pattern = /^[a-zA-Z0-9_]+$/;
            break;
        case 'phone': // 電話
            pattern = /^[0-9\(\)\-\s\#]+$/;
            break;
        case 'email': // email
            pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            break;
        case 'url': // url
            pattern = /https?:\/\/([-\w\.]+)+(:\d+)?(\/([\w\/_\.]*(\?\S+)?)?)?/;
            break;
        case 'nonnegative': // 非負數
            pattern = /^\d+(\.\d+)?$/;
            break;
        case 'number': // 0-9數字組合(非負整數)
            pattern = /^\d+$/;
            pattern = /^[0-9]*\.[0-9]+$|^[0-9]+$/;
            break;
        case 'natural': // 正整數
            pattern = /^[1-9]\d*$/;
            break;
        case 'integer': // 整數
            pattern = /^-?[1-9]\d*$/;
            break;
        case 'alnum': // 英數
            pattern = /^[A-Za-z0-9]+$/;
            break;
        case 'english': // 英文
            pattern = /^[A-Za-z]+$/;
            break;
        case 'uppercase': // 大寫英文
            pattern = /^[A-Z]+$/;
            break;
        case 'lowercase': // 小寫英文
            pattern = /^[a-z]+$/;
            break;
        case 'bank_account': // 銀行帳號
            pattern = /^[0-9\-]+$/;
            break;
    }

    if ( str == '' || pattern.test(str) ) {
        return true;
    }
    return false;
}

// 檢查 textarea 輸入長度是否超過限制, 若超過則刪除超過部份並提醒
function check_textarea_length(tObj, length) {
    if ( tObj.value.length > length ) {
        tObj.value = tObj.value.substr(0, length);
        alert('提醒您！您填入字數已達上限 '+length+' 字。');
    }
}

// 檢查 textarea 輸入字數是否超過限制, 若超過則提醒
function check_textarea_words(iwin,obj,max_num){
    var word = obj.value;
    if ( word == null ) {
        return false;  
    }
    var words_arr = word.match(/[\u4E00-\u9FA5]|\w+/g);
    if ( words_arr == null ) {
        return false;  
    }
  
    if ( words_arr.length > max_num ) {
        alert('「$column_name」欄位字數超過限制，請重新確認。'.replace('$column_name', iwin));
    }
}

// 計算 checkbox 被勾選的個數
function get_checked_count(tObj) {
    var counter = 0;
    if ( tObj.checked != undefined ) {
        return tObj.checked;
    }
    else {
        for ( var i=0; i<tObj.length; i++ ) {
            if ( tObj[i].checked == true ) {
                counter++;
            }
        }
    }
    return counter;
}

// 傳回 checkbox 被勾選的項目
function get_checked_items(tObj) {
    var items = new Array();
    if ( tObj.checked != undefined ) {
        if ( tObj.checked == true ) {
            items[0] = tObj.value;
        }
    }
    else {
        var counter = 0;
        for ( var i=0; i<tObj.length; i++ ) {
            if ( tObj[i].checked == true ) {
                items[counter++] = tObj[i].value;
            }
        }
    }
    return items;
}

// 一次勾選或取消指定名稱checkbox
function select_all_checkbox(fObj, status) {
    for ( var i=0; i<fObj.length; i++ ) {
        if ( fObj[i].type != 'checkbox' ) {
            continue;
        }
        fObj[i].checked = ( status == 1 ) ? true : false;
    }
}

// 擷取 radio 選項的值
function get_radio_value(rObj){
    if ( rObj.length == undefined ) {
        if ( rObj.checked ) {
            return rObj.value;
        }
    }
    else {
        for ( var i=0; i<rObj.length; i++) {
            if ( rObj[i].checked ) {
                return rObj[i].value;
            }
        }
    }
    return false;
}

// 從 str 字串中移除 keyword 字串後回傳, 若 str 中不存在 keyword 則回傳 false
function str_remove(str, keyword) {
    if ( str.indexOf(keyword) != -1 ) {
        var new_str = str.substring(0, str.indexOf(keyword))
                    + str.substring(str.indexOf(keyword)+keyword.length, str.length);
        return new_str;
    }
    else {
        return false;
    }
}

// 產生彈跳視窗
function show_popup(class_code, func, formname, parameter, keyword) {
    window.open("index.php?act_m=popup&class=" + class_code + "&func=" + func + "&formname=" +formname + "&parameter=" + parameter + "&keyword=" + keyword, "popup", "toolbar=0,location=no, directories=no, status=yes, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=600, height=700");
    //if (navigator.appName == 'Netscape') 
        //popup.focus();
}

// 彈跳視窗將指定變數值帶回原網頁
function sub_set_para(formname, parameter, parameter_value, if_submit) {
    var f = window.opener.document.forms[formname];
    f.elements[parameter].value = parameter_value;
    if ( if_submit == 1 ) {
        f.submit();
    }
    window.close();
}

// 仿 php 同名函數
function number_format(number, decimals, dec_point, thousands_sep) {
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 0 : decimals;
    var d = dec_point == undefined ? "." : dec_point;
    var t = thousands_sep == undefined ? "," : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

// 仿 php 同名函數
function trim(str) {
    while ( str.substring(0,1) == ' ' ) {
        str = str.substring(1, str.length);
    }
    while ( str.substring(str.length-1, str.length) == ' ' ) {
        str = str.substring(0, str.length-1);
    }
    return str;
}

// 仿 php 同名函數
function in_array(str, array) {
    for ( var i=0; i<array.length; i++ ) {
        this_str = array[i].toString();
        if ( this_str == str ) {
            return true;
        }
    }
    return false;
}

// 產生日期選單
function date_select_menu_init(yearObj, monthObj, dateObj, startYear, endYear, curYear, curMonth, curDate) {
    //var yearValue = ( curYear == '' ) ? startYear : curYear;
    //var monthValue = ( curMonth == '' ) ? 0 : curMonth;
    var dateValue = ( curDate == '' ) ? 0 : curDate;

    for ( i = startYear; i <= endYear; i++) {
        var nObj = new Option();
        nObj.text = i;
        nObj.value = i;
        yearObj.options[yearObj.length] = nObj;

        if ( curYear == i ) {
        //if ( yearValue == i ) {
            yearObj.selectedIndex = yearObj.length-1;
        }
    }

    var month_str;
    for ( i = 1; i <= 12; i++) {
        month_str = i;
        if ( i <= 9 ) {
            month_str = '0'+i;
        }
        var nObj = new Option();
        nObj.text = month_str;
        nObj.value = month_str;
        monthObj.options[monthObj.length] = nObj;
        
        if ( curMonth == i ) {
        //if ( monthValue == i ) {
            monthObj.selectedIndex = monthObj.length-1;
        }
    }

    populate_date(yearObj, monthObj, dateObj);
    
    dateObj.selectedIndex = dateValue;
}

// 產生日期選單時決定該月有幾天
function populate_date(yearObj, monthObj, dateObj) {
    timeA = new Date(yearObj.options[yearObj.selectedIndex].text, monthObj.options[monthObj.selectedIndex].value,1);
    timeDifference = timeA - 86400000;
    timeB = new Date(timeDifference);
    var daysInMonth = timeB.getDate();
    for ( var i = dateObj.length; i > 0; i-- ) {
        dateObj.remove(i);
    }

    var date_str;
    if ( yearObj.options[yearObj.selectedIndex].text != '' && monthObj.options[monthObj.selectedIndex].text != '' ) {
        dateObj.options[0] = new Option(0);
        dateObj.options[0].text = '請選擇';
        dateObj.options[0].value = '';
        for ( var i = 1; i <= daysInMonth; i++ ) {
            date_str = i;
            if ( i <= 9 ) {
                date_str = '0'+i;
            }

            dateObj.options[i] = new Option(i);
            dateObj.options[i].text = date_str;
            dateObj.options[i].value = date_str;
        }
    }
    dateObj.options[0].selected = true;
}
// 彈性複選區塊設定功能增加項目
function add_block_info(item_select_max_count, var_prefix) {
    var item_select_max_idx = -1;
    for ( var i=0; i<item_select_max_count; i++ ) {
        if ( document.getElementById(var_prefix+'_'+i).style.display != 'none' ) {
            item_select_max_idx = i;
        }
    }

    var add_idx = item_select_max_idx + 1;
    if ( add_idx < item_select_max_count ) {
        document.getElementById(var_prefix+'_'+add_idx).style.display = 'block';
        return add_idx;
    }
    else {
        return -1;
    }
}


// 彈性複選區塊設定功能刪除項目
function delete_block_info(item_select_count, var_prefix, idx) {
    var item_select_display_count = 0;
    for ( var i=0; i<item_select_count; i++ ) {
        if ( document.getElementById(var_prefix+'_'+i).style.display != 'none' ) {
            item_select_display_count++;
        }
    }
    if ( item_select_display_count == 1 ) {
        alert('此欄位為必填!');
        return false;
    }
    
    document.getElementById(var_prefix+'_'+idx).style.display = 'none';
    return true;
}

function strip_year(date_arr) {
    var md_arr = [];
    for ( i in date_arr ) {
        if ( date_arr[i].length == 10 ) {
            md_arr[i] = date_arr[i].substring(5, 10);
        }
    }
    return md_arr;
}

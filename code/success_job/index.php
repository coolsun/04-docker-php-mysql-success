<?php
ob_start("ob_gzhandler");

session_start();
header('Content-Type:text/html; charset=utf-8');
require "config_conn.inc.php";


// 這邊要加上判斷是否會員已登入, 若尚未登入則導到登入畫面



// 先臨時假裝已經登入
$_SESSION['userid'] = 1;
$_SESSION['usersex'] = '01';
$_SESSION['userdata'] = '1975-01-01';


// 目前單元位置
$dept = ( isset($_REQUEST['dept']) ) ? $_REQUEST['dept'] : '';
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<title>Success</title>
<link href="css/reset.css" rel="stylesheet" />
<link href="css/header.css" rel="stylesheet" />
<link href="css/layout.css" rel="stylesheet" />
</head>


<body>
    <div class='topbar'>
        <div id='header'>
            <ul id='global-nav'>
                <li class='logo'><a href='index.php'>success</a></li>
                <li class='job'><a href='index.php?dept=job' <?php if($dept=='job') echo "class='current'"?>>工作</a></li>
                <li class='finance'><a href='index.php?dept=finance' <?php if($dept=='finance') echo "class='current'"?>>財務</a></li>
                <li class='health'><a href='index.php?dept=health' <?php if($dept=='health') echo "class='current'"?>>健康</a></li>
                <li class='friend'><a href='index.php?dept=friend' <?php if($dept=='friend') echo "class='current'"?>>朋友</a></li>
            </ul>            
            <ul id='global-member'>
<?php
require ( 'header_right.php' );
?>
            </ul>
        </div>
    </div>
    <div id='container'>        
<?php
if ( is_dir($dept) && file_exists($dept.'/index.php') ) {
    include ( $dept.'/index.php' );
}
?>
    </div>
</body>
</html>

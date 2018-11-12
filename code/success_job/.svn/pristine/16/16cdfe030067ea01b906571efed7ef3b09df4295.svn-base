<link href="job/css/job.css" rel="stylesheet" />
<script type="text/javascript" src="job/js/jquery.min.js"></script>
<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<link href="js/datePicker/datePicker.css" rel="stylesheet" />

<script type="text/javascript" src="job/js/chosen/chosen.jquery.js"></script>
<link href="job/js/chosen/chosen.css" rel="stylesheet" />

<script type="text/javascript" src="job/js/popup/popup.js"></script>
<link href="job/js/popup/popup.css" rel="stylesheet" />

<?php
/*
 Show Error msg
*/
?>
<!--<div style="text-align: center; color: red;"><b><?php if( isset( $_SESSION['Error_msg'] ) ) { echo $_SESSION['Error_msg']; unset($_SESSION['Error_msg']); } ?></b></div>-->

<?php
    /* Avoid XSS */
    function convertHtmlTag( $str ) {
      if( is_array( $str ) ) {
        $temp = array();
        foreach( $str as $key => $value ) {
          $key = preg_replace('/[^\d\w_]/', '', $key);
          $temp[ $key ] = convertHtmlTag( $value );
        }
        return $temp;
      }
      return htmlspecialchars( $str );
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
      //echo $e->getMessage();
      exit();
    }

    /*
     $_GET['ma'] : Main Action
     $_GET['sa'] : Sub Action
    */

    /*
     Main Actions
    */
    $mas = array( 'engine'   => '工作引擎',
                  'plan'     => '工作計畫',
                  'business' => '業務商機',
                  'jobnote'  => '工作日誌' 
    );
    /*
     Sub Actions
    */
    $sas = array( 'engine' => array( 'engine' => '引擎',
                                     'result' => '結果'),
                  'plan' => array( 'planning'    => '計畫',
                                   'map'         => '地圖',
                                   'schedule'    => '時程',
                                   'performance' => '效能'),
                  'business' => array( 'opportunities' => '商機',
                                       'search'        => '查詢',
                                       'analysis'      => '分析' ),
                  'jobnote'  => array( 'list' => '日誌',
                                       'edit' => '編輯',
                                       'view' => '查看' )
    );
    /*
     Default sa of ma
    */
    $default_sas = array( 'engine'   => 'engine',
                          'plan'     => 'planning',
                          'business' => 'opportunities',
                          'jobnote'  => 'list' );

    /*
     Check and Set ma and sa
     Default ma : Engine
    */
    if( !( isset( $_GET['ma'] ) && trim( $_GET['ma'] ) != '' ) ){
        $_GET['ma'] = 'engine';
    }
    if( !isset( $mas[ $_GET['ma'] ] ) ){
        /*echo "<div class='error_msg'>Error !!</div>";
        echo "<div class='error_msg'><b>ma</b> is invalid.</div>";
        exit();*/
        $_GET['ma'] = 'engine';
    }
    $ma = $_GET['ma'];

    if( isset( $_GET['sa'] ) && isset( $sas[ $ma ][ $_GET['sa'] ] ) ){
        $sa = $_GET['sa'];
    }
    else{
        $sa = $default_sas[ $ma ];
    }

?>
<div id='left-content'>
    <?php /* Produce Menu */ ?>
    <ul class='menu'>
        <?php
            foreach( $mas as $action => $action_name ) {
        ?>
            <li class="<?php if( $_GET['ma'] == $action ) echo 'current';  ?>">
                <a href="?dept=job&ma=<?php echo $action; ?>" title="<?php echo $action_name; ?>"><?php echo $action_name; ?></a>
            </li>
        <?php
            }
        ?>
    </ul>
</div>
<div id='top-content'></div>
<div id='main-content'>
    <?php include( $ma.'/'.$sa.'.php' ) ?>
</div>

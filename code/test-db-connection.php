<?php
# Fill our vars and run on cli
# $ php -f db-connect-test.php
$dbname = 'success_health';
$dbuser = 'root';
$dbpass = 'password';
$dbhost = 'mysql5.6-3346';
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Unable to Connect to '$dbhost'"); //Connection variable


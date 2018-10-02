<?php
require dirname(__FILE__) . "/../config_conn.inc.php";

function connect_success_db($db_model)
{
    global $DB_connection_array;

    switch($db_model)
    {
      case 'health':
        return connect_pdo($DB_connection_array['health']['driver_name'],
                            $DB_connection_array['health']['host'],
                            $DB_connection_array['health']['db_name'],
                            $DB_connection_array['health']['user_name'],
                            $DB_connection_array['health']['password']);
        break;
      default:
        return false;
    }
    return false;
}


function connect_pdo($driver, $host, $db_name, $user_name, $password)
{
    try
    {
        $dbh = new PDO("$driver:host=$host;dbname=$db_name", $user_name, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("SET NAMES 'utf8';");
        return $dbh;
    }
    catch ( PDOException $e ) {
        error_log($e->getMessage());
        return false;
    }
}



?>

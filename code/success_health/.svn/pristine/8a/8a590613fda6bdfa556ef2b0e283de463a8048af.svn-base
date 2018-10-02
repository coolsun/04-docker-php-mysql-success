<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$exercise_date = isset($_POST['newExerciseDate']) ? $_POST['newExerciseDate'] : false;
$exercise_sport_id = isset($_POST['newSportId']) ? $_POST['newSportId'] : false;
$exercise_mins = isset($_POST['newMins']) ? $_POST['newMins'] : false;
$uid = $_SESSION['userid'];

function new_record($dbh, $user_id, $exercise_date, $exercise_sport_id, $exercise_mins, $kcal)
{
    $kcal = round($kcal, 2);
    $insert_query_string = "INSERT INTO `exercises`(`user_id`, `date`, `sport_id`, `mins`, `kcal`, `created_at`) VALUES (?,?,?,?,?,?)";
    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array(
        $user_id,
        $exercise_date,
        $exercise_sport_id,
        $exercise_mins,
        $kcal,
        date("Y-m-d H:i:s")
    ));

    return ($insert_query->rowCount() == 1);
}

function get_sport_mets($dbh, $sport_id)
{
  $query_string = 'SELECT  `id`, mets, `category`, `cht_descriptions` FROM `sports` where(id=?)';
  $query = $dbh->prepare( $query_string );
  $query->execute(array($sport_id));
  $sports = $query->fetchAll( PDO::FETCH_ASSOC );
  $mets = isset($sports[0]) ? $sports[0]['mets'] : 0;
  return($mets);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($exercise_date && $exercise_sport_id && $exercise_mins)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            $last_weight = 0;
            $query_string = 'SELECT `weight` FROM `user_weights` WHERE `user_id` = ? AND `date` <= ? ORDER BY `date` desc limit 1';
            $query = $dbh->prepare( $query_string );
            $query->execute( array( $uid, $exercise_date ) );
            $weights = $query->fetchAll( PDO::FETCH_ASSOC );
            if (1 == count($weights))
            {
              $last_weight = $weights[0]['weight'];
            }

            $kcal = get_sport_mets($dbh, $exercise_sport_id) * $last_weight * ($exercise_mins / 60);
            if (new_record($dbh, $uid, $exercise_date, $exercise_sport_id, $exercise_mins, $kcal))
            {
                $b_success = true;
            }
            else
            {
                $s_err_message = "Error: Can't insert data to database.";
            }
        }
        else
        {
            $s_err_message = "Error: Can't connect the database.";
        }
    }
    else
    {
        $s_err_message = "Error: Can't find the user.";
    }
}
else
{
    $s_err_message = "Error: Loss some params.";
}

$data = array('success' => $b_success, 'msg' => $s_err_message);
echo json_encode($data);

?>
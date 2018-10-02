<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$meal_id = isset($_POST['id']) ? $_POST['id'] : false;
$meal_units = isset($_POST['newMealUnit']) ? $_POST['newMealUnit'] : false;
$meal_grams = isset($_POST['newMealGram']) ? $_POST['newMealGram'] : false;
$meal_energ_kcal = isset($_POST['newMealEnergKcal']) ? $_POST['newMealEnergKcal'] : false;
$meal_protein = isset($_POST['newMealProtein']) ? $_POST['newMealProtein'] : false;
$meal_lipid_tot = isset($_POST['newMealLipidTot']) ? $_POST['newMealLipidTot'] : false;
$meal_carbohydrt = isset($_POST['newMealCarbohydrt']) ? $_POST['newMealCarbohydrt'] : false;
$uid = $_SESSION['userid'];

function record_update($dbh, $id, $user_id, $meal_units, $meal_grams, $meal_energ_kcal, $meal_protein, $meal_lipid_tot, $meal_carbohydrt)
{
    $update_query_string = "UPDATE `meals` SET `unit`=?, `gram`=?, `energ_kcal`=?, `protein`=?, `lipid_tot`=?, `carbohydrt`=? WHERE `id`=? AND `user_id`=?";
    $update_query = $dbh->prepare($update_query_string);
    $b_success = $update_query->execute(array(
        $meal_units,
        $meal_grams,
        $meal_energ_kcal,
        $meal_protein,
        $meal_lipid_tot,
        $meal_carbohydrt,
        $id,
        $user_id,
    ));

    return ($b_success);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if (!empty($meal_id) && is_numeric($meal_units) && is_numeric($meal_grams) && is_numeric($meal_energ_kcal) && is_numeric($meal_protein) && is_numeric($meal_lipid_tot) && is_numeric($meal_carbohydrt))
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (record_update($dbh, $meal_id, $uid, $meal_units, $meal_grams, $meal_energ_kcal, $meal_protein, $meal_lipid_tot, $meal_carbohydrt))
            {
                $b_success = true;
            }
            else
            {
                $s_err_message = "Error: Can't update data to database.";
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
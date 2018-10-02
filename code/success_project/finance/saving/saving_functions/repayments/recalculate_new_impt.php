<?php
/* Ajax calculate impt */

header( "Content-Type: application/json", true );

require_once "../../lib/ipmt_ppmt_for_success_project.php";

/* Connect to DB */
$status = false;
$emsg = '';
$data = json_decode($_POST['data'], true);

try
{
    if (!is_array($data))
    {
        $data = array($data);
    }

    foreach ($data as $key => $value) {
      $result = new PpmtLoanMoneyForSuccessProject($value["balance"], $value["yrate"], $value['tmonthlength'], $value["dstart"]);

      $data[$key]['pmt'] = $result->get_pmt();
      $data[$key]['total_interest'] = $result->get_total_interest();
      $data[$key]['data'] = $result->get_all_period_data();

      if (0 == ($data[$key]['data'][0]["remain"]))
      {
          $data[$key]['deadline_time'] = date('Y-m');
      }
    }

    $status = true;
}
catch (PDOException $e)
{
  echo $e->getMessage();
  exit();
}

$result = array('status' => $status, 'result' => $data, 'emsg' => $emsg);
echo json_encode ($result);

?>

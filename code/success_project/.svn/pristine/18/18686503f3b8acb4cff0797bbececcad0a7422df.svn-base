<?php
/// IPMT/PPMT
/// For success project
/// actor: 李俞興 (YuXing, Lee)
// last updated date: 2016/9/30
  class PpmtLoanMoneyForSuccessProject{
    // actor: 李俞興 (YuXing, Lee)
    // last updated date: 2016/9/30

    private $amount = 0;
    private $year_rate = 0;
    private $period = 0;
    private $month_rate = 0;

    private $pmt = 0;               //每期償還
    private $arr_amount = Array();  //本金
    private $arr_ipmt = Array();    //本期利息
    private $arr_ppmt = Array();    //本期償還本金
    private $arr_remain_amount = Array();
    private $total_interest = 0;
    private $start_date;

    public function __construct($amount, $year_rate, $period, $start_date = '0000-00-00'){
      $this->amount = $amount;
      $this->year_rate = $year_rate / 100;
      $this->period = $period;
      $this->month_rate = $this->year_rate / 12;
      $this->pmt = self::pmt_calculate();
      $this->start_date = date("Y-m-d", strtotime($start_date));

      self::all_period_calculate($period);
    }

    public function __destruct(){
      $this->amount = null;
      $this->year_rate = null;
      $this->period = null;
      $this->month_rate = null;
      $this->pmt = null;
      $this->arr_amount = null;
      $this->arr_ipmt = null;
      $this->arr_ppmt = null;
      $this->arr_remain_amount = null;
    }

    public function get_pmt(){
      return $this->pmt;
    }

    public function get_total_interest(){
      return $this->total_interest;
    }

    public function get_target_date($target_period){
      //償還日期
      $date = new DateTime($this->start_date);
      $date->setDate($date->format('Y'), $date->format('m'), 1);

      return (date('Y-m', strtotime( $date->format('Y-m-d') . "+$target_period month")));
    }

    public function get_all_period_data(){
      //回傳array, 各時間點的資料
      $data = array();

      for ($arr_index = 0; $arr_index <= $this->period; $arr_index++)
      {
        array_push($data, array(
          "amount" => $this->arr_amount[$arr_index],
          "ipmt" => $this->arr_ipmt[$arr_index],
          "ppmt" => $this->arr_ppmt[$arr_index],
          "remain" => $this->arr_remain_amount[$arr_index],
          "date" => $this->get_target_date($arr_index)
        ));
      }

      return $data;
    }

    private function pmt_calculate(){
      // 每期付款金額
      return ($this->amount * (($this->month_rate * pow((1 + $this->month_rate), $this->period)) / (pow((1 + $this->month_rate), $this->period) -1)));
    }

    private function all_period_calculate($target_period){
      for ($arr_index = 0; $arr_index <= $target_period; $arr_index++)
      {
        if (!isset($this->arr_amount[$arr_index]) || !isset($this->arr_ipmt[$arr_index]) || !isset($this->arr_ppmt[$arr_index]))
        {
          if (0 == $arr_index)
          {
            $this->arr_amount[$arr_index] = $this->amount;
            $this->arr_ipmt[$arr_index] = 0;
            $this->arr_ppmt[$arr_index] = 0;
          }
          else
          {
            $this->arr_amount[$arr_index] = $this->arr_remain_amount[$arr_index - 1];
            $this->arr_ipmt[$arr_index] = ($this->arr_amount[$arr_index] * $this->month_rate);
            $this->arr_ppmt[$arr_index] = ($this->pmt - ($this->arr_amount[$arr_index] * $this->month_rate));
          }

          $this->arr_remain_amount[$arr_index] = $this->arr_amount[$arr_index] - $this->arr_ppmt[$arr_index];
        }
      }

      $this->total_interest = array_sum($this->arr_ipmt);
    }
  }
?>
<?php

namespace App\Services;


class UtilitiesService
{
  public static function loanCalculator($loan_amount, $tenor, $rate_per_day, $startdate = null)
  {
    if (!$startdate) {
      $startdate = date('Y-m-d');
    }

    if (!$rate_per_day) {
      $rate_per_day = 0.0025;
    }

    $insurance_rate = 0.05;

    $expectedenddate = $actualtenor = $interestperday = $insurance = $disbursementfees = $interest = $monthlyrepayment = "";

    $date = date('Y-m-d', strtotime('+' . $tenor . ' months', strtotime($startdate)));

    $endyear = date('Y', strtotime($date));
    $endmonth = date('m', strtotime($date));
    $expectedenddate = date('Y-m-d', strtotime(self::last_day($endmonth, $endyear) . ' + 10 days'));

    $date1 = date_create($startdate);
    $date2 = date_create($expectedenddate);
    $datediff = date_diff($date1, $date2);
    $actualtenor = $datediff->days;
    $interestperday = $rate_per_day * $actualtenor;
    $disbursementfees = 2750;
    if ($loan_amount > 75000) {
      $disbursementfees = (0.05 * $loan_amount) + 150;
    }
    $insurance = $insurance_rate * $loan_amount;

    $totalinterest = ($interestperday * $loan_amount);
    $monthlyrepayment = ($totalinterest + $loan_amount + $insurance + $disbursementfees) / $tenor;
    $monthlyrepayment = $monthlyrepayment;
    $interest = $totalinterest / $tenor;
    $fees = $disbursementfees + $insurance;

    return ['status' => 'success', 'message' => 'successfull', 'monthlyrepayment' => $monthlyrepayment, 'interest' => $interest, 'fees' => $fees, 'expectedenddate' => $expectedenddate, 'startdate' => $startdate, 'actualtenor' => $actualtenor, 'tenor' => $tenor, 'amount' => $loan_amount, 'disbursementfees' => $disbursementfees, 'insurance' => $insurance, 'rate' => $rate_per_day, 'totalinterest' => $totalinterest];
  }


  public static function last_day($month = '', $year = '')
  {
    if (empty($month)) {
      $month = date('m');
    }

    if (empty($year)) {
      $year = date('Y');
    }

    $result = strtotime("{$year}-{$month}-01");
    $result = strtotime('-1 second', strtotime('+1 month', $result));

    return date('Y-m-d', $result);
  }
}

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

  public static function getBankName($bankcode)
  {
    $banks = [
      [
        "name" => "78 FINANCE COMPANY LIMITED",
        "code" => "110072",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "110072"
      ],
      [
        "name" => "9 PAYMENT SOLUTIONS BANK",
        "code" => "120001",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "120001"
      ],
      [
        "name" => "9JAPAY MICROFINANCE BANK",
        "code" => "090629",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090629"
      ],
      [
        "name" => "AB MICROFINANCE BANK ",
        "code" => "090270",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090270"
      ],
      [
        "name" => "ABBEY MORTGAGE BANK",
        "code" => "070010",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070010"
      ],
      [
        "name" => "ABOVE ONLY MICROFINANCE BANK ",
        "code" => "090260",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090260"
      ],
      [
        "name" => "ABU MICROFINANCE BANK ",
        "code" => "090197",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090197"
      ],
      [
        "name" => "Access bank",
        "code" => "044",
        "ussdTemplate" => "*901*Amount*AccountNumber#",
        "baseUssdCode" => "*901#",
        "transferUssdTemplate" => "*901*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000014"
      ],
      [
        "name" => "ACCESS MONEY",
        "code" => "927",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100013"
      ],
      [
        "name" => "ACCESS YELLO & BETA",
        "code" => "100052",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100052"
      ],
      [
        "name" => "ACCION MICROFINANCE BANK",
        "code" => "090134",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090134"
      ],
      [
        "name" => "ADA MICROFINANCE BANK",
        "code" => "090483",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090483"
      ],
      [
        "name" => "ADDOSSER MICROFINANCE BANK",
        "code" => "090160",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090160"
      ],
      [
        "name" => "ADEYEMI COLLEGE STAFF MICROFINANCE BANK",
        "code" => "090268",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090268"
      ],
      [
        "name" => "AELLA MFB",
        "code" => "090614",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090614"
      ],
      [
        "name" => "AFEKHAFE MICROFINANCE BANK",
        "code" => "090292",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090292"
      ],
      [
        "name" => "AG MORTGAGE BANK",
        "code" => "100028",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100028"
      ],
      [
        "name" => "AKALABO MFB",
        "code" => "090698",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090698"
      ],
      [
        "name" => "AKU Microfinance Bank",
        "code" => "090531",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090531"
      ],
      [
        "name" => "AL-BARAKAH MICROFINANCE BANK",
        "code" => "090133",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090133"
      ],
      [
        "name" => "ALEKUN MICROFINANCE BANK",
        "code" => "090259",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090259"
      ],
      [
        "name" => "ALERT MICROFINANCE BANK",
        "code" => "090297",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090297"
      ],
      [
        "name" => "ALLWORKERS MICROFINANCE BANK",
        "code" => "090131",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090131"
      ],
      [
        "name" => "ALPHA KAPITAL MICROFINANCE BANK ",
        "code" => "090169",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090169"
      ],
      [
        "name" => "AMML MICROFINANCE BANK ",
        "code" => "914",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090116"
      ],
      [
        "name" => "Amucha Microfinance Bank",
        "code" => "090645",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090645"
      ],
      [
        "name" => "APEKS MICROFINANCE BANK",
        "code" => "090143",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090143"
      ],
      [
        "name" => "ARISE MICROFINANCE BANK",
        "code" => "090282",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090282"
      ],
      [
        "name" => "ASO SAVINGS",
        "code" => "905",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090001"
      ],
      [
        "name" => "ASSETMATRIX MICROFINANCE BANK",
        "code" => "090287",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090287"
      ],
      [
        "name" => "ASSETS MFB",
        "code" => "090473",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090473"
      ],
      [
        "name" => "ASTRAPOLARIS MICROFINANCE BANK",
        "code" => "090172",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090172"
      ],
      [
        "name" => "AUCHI MICROFINANCE BANK ",
        "code" => "090264",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090264"
      ],
      [
        "name" => "AVUENEGBE MICROFINANCE BANK",
        "code" => "090478",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090478"
      ],
      [
        "name" => "AWACASH MICROFINANCE BANK",
        "code" => "51351",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090633"
      ],
      [
        "name" => "BAINES CREDIT MICROFINANCE BANK",
        "code" => "090188",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090188"
      ],
      [
        "name" => "BALOGUN GAMBARI MICROFINANCE BANK",
        "code" => "090326",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090326"
      ],
      [
        "name" => "BAM MICROFINANCE BANK",
        "code" => "090651",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090651"
      ],
      [
        "name" => "BANKLY MFB",
        "code" => "090529",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090529"
      ],
      [
        "name" => "BAOBAB MICROFINANCE BANK",
        "code" => "090136",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090136"
      ],
      [
        "name" => "BC KASH MICROFINANCE BANK",
        "code" => "090127",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090127"
      ],
      [
        "name" => "Beststar MFB",
        "code" => "090615",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090615"
      ],
      [
        "name" => "BETHEL MICROFINANCE BANK",
        "code" => "090683",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090683"
      ],
      [
        "name" => "BIPC MICROFINANCE BANK",
        "code" => "090336",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090336"
      ],
      [
        "name" => "BOCTRUST MICROFINANCE BANK LIMITED",
        "code" => "952",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090117"
      ],
      [
        "name" => "BOKKOS MFB",
        "code" => "090703",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090703"
      ],
      [
        "name" => "BOROMU MICROFINANCE BANK",
        "code" => "090501",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090501"
      ],
      [
        "name" => "BOSAK MICROFINANCE BANK",
        "code" => "090176",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090176"
      ],
      [
        "name" => "Bowen Microfinance Bank",
        "code" => "50931",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090148"
      ],
      [
        "name" => "Branch International Financial Services",
        "code" => "005",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "050006"
      ],
      [
        "name" => "BRENT MORTGAGE BANK",
        "code" => "070015",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070015"
      ],
      [
        "name" => "BRIGHTWAY MICROFINANCE BANK",
        "code" => "090308",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090308"
      ],
      [
        "name" => "BUILD MICROFINANCE BANK",
        "code" => "090613",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090613"
      ],
      [
        "name" => "BUYPOWER MICROFINANCE BANK",
        "code" => "090682",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090682"
      ],
      [
        "name" => "CAPITALMETRIQ",
        "code" => "51319",
        "ussdTemplate" => "*#**",
        "baseUssdCode" => "*#**",
        "transferUssdTemplate" => "*#**AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "51319"
      ],
      [
        "name" => "CARBON",
        "code" => "940",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100026"
      ],
      [
        "name" => "CASHBRIDGE MICROFINANCE BANK",
        "code" => "090634",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090634"
      ],
      [
        "name" => "CASHCONNECT MICROFINANCE BANK",
        "code" => "090360",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090360"
      ],
      [
        "name" => "CELLULANT",
        "code" => "919",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100005"
      ],
      [
        "name" => "CEMCS Microfinance Bank",
        "code" => "50823",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090154"
      ],
      [
        "name" => "CHAMS MOBILE",
        "code" => "929",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100015"
      ],
      [
        "name" => "CHIKUM MICROFINANCE BANK",
        "code" => "090141",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090141"
      ],
      [
        "name" => "Citibank Nigeria",
        "code" => "023",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000009"
      ],
      [
        "name" => "CITYCODE MORTGAGE BANK",
        "code" => "070027",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070027"
      ],
      [
        "name" => "Clearpay Microfinance Bank",
        "code" => "090482",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090482"
      ],
      [
        "name" => "COASTLINE MICROFINANCE BANK",
        "code" => "090374",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090374"
      ],
      [
        "name" => "CONPRO MICROFINANCE BANK",
        "code" => "090380",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090380"
      ],
      [
        "name" => "CONSUMER MICROFINANCE BANK",
        "code" => "090130",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090130"
      ],
      [
        "name" => "CONTEC GLOBAL INFOTECH LIMITED(NOWNOW)",
        "code" => "100032",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100032"
      ],
      [
        "name" => "CORESTEP MICROFINANCE BANK",
        "code" => "090365",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090365"
      ],
      [
        "name" => "Coronation Bank",
        "code" => "946",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "060001"
      ],
      [
        "name" => "County Finance Limited",
        "code" => "050001",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "050001"
      ],
      [
        "name" => "COVENANT MFB",
        "code" => "949",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070006"
      ],
      [
        "name" => "CREDIT AFRIQUE MICROFINANCE BANK",
        "code" => "090159",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090159"
      ],
      [
        "name" => "CRUST MICROFINANCE BANK",
        "code" => "090560",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090560"
      ],
      [
        "name" => "CRUTECH  MFB",
        "code" => "090414",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090414"
      ],
      [
        "name" => "CSD MICROFINANCE BANK",
        "code" => "090686",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090686"
      ],
      [
        "name" => "DAL MFB",
        "code" => "090596",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090596"
      ],
      [
        "name" => "DAVENPORT MICROFINANCE BANK",
        "code" => "090673",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090673"
      ],
      [
        "name" => "DAVODANI  MICROFINANCE BANK",
        "code" => "090391",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090391"
      ],
      [
        "name" => "DAYLIGHT MICROFINANCE BANK",
        "code" => "090167",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090167"
      ],
      [
        "name" => "DESTINY MFB",
        "code" => "090723",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090723"
      ],
      [
        "name" => "Diamond bank",
        "code" => "063",
        "ussdTemplate" => "*710*777*AccountNumber*Amount#",
        "baseUssdCode" => "*710#",
        "transferUssdTemplate" => "*710*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000005"
      ],
      [
        "name" => "DOJE Microfinance Bank Limited",
        "code" => "090404",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090404"
      ],
      [
        "name" => "E-BARCS MICROFINANCE BANK",
        "code" => "090156",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090156"
      ],
      [
        "name" => "EAGLE FLIGHT MICROFINANCE BANK",
        "code" => "090294",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090294"
      ],
      [
        "name" => "Earnwell MICROFINANCE BANK",
        "code" => "090674",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090674"
      ],
      [
        "name" => "EARTHOLEUM",
        "code" => "935",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100021"
      ],
      [
        "name" => "Ecobank Nigeria Plc",
        "code" => "050",
        "ussdTemplate" => null,
        "baseUssdCode" => "*326#",
        "transferUssdTemplate" => "*326*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000010"
      ],
      [
        "name" => "ECOBANK XPRESS ACCOUNT",
        "code" => "922",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100008"
      ],
      [
        "name" => "ECOMOBILE",
        "code" => "307",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100030"
      ],
      [
        "name" => "EJINDU MFB",
        "code" => "090694",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090694"
      ],
      [
        "name" => "EK-RELIABLE MICROFINANCE BANK",
        "code" => "090389",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090389"
      ],
      [
        "name" => "EKIMOGUN MFB",
        "code" => "090552",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090552"
      ],
      [
        "name" => "EKONDO MICROFINANCE BANK",
        "code" => "090097",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090097"
      ],
      [
        "name" => "EMERALD MICROFINANCE BANK",
        "code" => "090273",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090273"
      ],
      [
        "name" => "EMPIRE TRUST MICROFINANCE BANK",
        "code" => "913",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090114"
      ],
      [
        "name" => "ENTERPRISE BANK",
        "code" => "084",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000019"
      ],
      [
        "name" => "ESO-E MICROFINANCE BANK",
        "code" => "090166",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090166"
      ],
      [
        "name" => "eTRANZACT",
        "code" => "920",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100006"
      ],
      [
        "name" => "EVANGEL MICROFINANCE BANK ",
        "code" => "090304",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090304"
      ],
      [
        "name" => "EVERGREEN MICROFINANCE BANK",
        "code" => "090332",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090332"
      ],
      [
        "name" => "EXCEL MICROFINANCE BANK",
        "code" => "090678",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090678"
      ],
      [
        "name" => "Eyowo",
        "code" => "50126",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090328"
      ],
      [
        "name" => "FairMoney",
        "code" => "51318",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090551"
      ],
      [
        "name" => "FAST MICROFINANCE BANK",
        "code" => "090179",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090179"
      ],
      [
        "name" => "FBNQUEST MERCHANT BANK",
        "code" => "911",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "060002"
      ],
      [
        "name" => "FCMB MOBILE",
        "code" => "100031",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100031"
      ],
      [
        "name" => "FCT MICROFINANCE BANK",
        "code" => "090290",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090290"
      ],
      [
        "name" => "FEDPOLY NASARAWA MICROFINANCE BANK",
        "code" => "090298",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090298"
      ],
      [
        "name" => "FETS",
        "code" => "915",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100001"
      ],
      [
        "name" => "FEWCHORE FINANCE COMAPNY LIMITED",
        "code" => "050002",
        "ussdTemplate" => "*#",
        "baseUssdCode" => "*#",
        "transferUssdTemplate" => "**AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "050002"
      ],
      [
        "name" => "FFS MICROFINANCE BANK",
        "code" => "090153",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090153"
      ],
      [
        "name" => "Fidelity bank",
        "code" => "070",
        "ussdTemplate" => "*770*AccountNumber*Amount#",
        "baseUssdCode" => "*770#",
        "transferUssdTemplate" => "*770*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000007"
      ],
      [
        "name" => "FIDELITY MOBILE",
        "code" => "933",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100019"
      ],
      [
        "name" => "FIDFUND MICROFINANCE Bank",
        "code" => "090126",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090126"
      ],
      [
        "name" => "FINATRUST MICROFINANCE BANK",
        "code" => "090111",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090111"
      ],
      [
        "name" => "FINCA MICROFINANCE BANK",
        "code" => "090400",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090400"
      ],
      [
        "name" => "FIRMUS MICROFINANCE BANK",
        "code" => "090366",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090366"
      ],
      [
        "name" => "First bank",
        "code" => "011",
        "ussdTemplate" => "*894*Amount*AccountNumber#",
        "baseUssdCode" => "*894#",
        "transferUssdTemplate" => "*894*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000016"
      ],
      [
        "name" => "First City Monument Bank Plc",
        "code" => "214",
        "ussdTemplate" => "*329*Amount*AccountNumber#",
        "baseUssdCode" => "*329#",
        "transferUssdTemplate" => "*329*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000003"
      ],
      [
        "name" => "FIRST GENERATION MORTGAGE BANK",
        "code" => "070014",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070014"
      ],
      [
        "name" => "FIRST OPTION MICROFINANCE BANK",
        "code" => "090285",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090285"
      ],
      [
        "name" => "FIRST ROYAL MICROFINANCE BANK",
        "code" => "090164",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090164"
      ],
      [
        "name" => "FIRST TRUST MORTGAGE BANK PLC",
        "code" => "910",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090107"
      ],
      [
        "name" => "FIRSTMONIE WALLET",
        "code" => "928",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100014"
      ],
      [
        "name" => "FLUTTERWAVE TECHNOLOGY SOLUTIONS LIMITED",
        "code" => "110002",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "110002"
      ],
      [
        "name" => "FOCUS MFB",
        "code" => "090709",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => null
      ],
      [
        "name" => "FORTIS MICROFINANCE BANK",
        "code" => "948",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070002"
      ],
      [
        "name" => "FORTIS MOBILE",
        "code" => "930",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100016"
      ],
      [
        "name" => "FSDH",
        "code" => "400001",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "400001"
      ],
      [
        "name" => "FULLRANGE MICROFINANCE BANK",
        "code" => "090145",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090145"
      ],
      [
        "name" => "FUTO MICROFINANCE BANK",
        "code" => "090158",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090158"
      ],
      [
        "name" => "Gabsyn Microfinance Bank Limited",
        "code" => "090591",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090591"
      ],
      [
        "name" => "Garun Mallam MFB",
        "code" => "090691",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090691"
      ],
      [
        "name" => "GATEWAY MORTGAGE BANK",
        "code" => "070009",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070009"
      ],
      [
        "name" => "GDL FINANCE",
        "code" => "050026",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "050026"
      ],
      [
        "name" => "Globus",
        "code" => "00103",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "103"
      ],
      [
        "name" => "Globus Bank",
        "code" => "103",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000027"
      ],
      [
        "name" => "GLORY MICROFINANCE BANK",
        "code" => "090278",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090278"
      ],
      [
        "name" => "GOLDMAN MICROFINANCE BANK",
        "code" => "50356",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090574"
      ],
      [
        "name" => "GOOD SHEPHERD MICROFINANCE BANK",
        "code" => "090664",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090664"
      ],
      [
        "name" => "GOODNEWS MICROFINANCE BANK",
        "code" => "090495",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090495"
      ],
      [
        "name" => "GOSIFECHUKWU MFB",
        "code" => "090687",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090687"
      ],
      [
        "name" => "GOWANS MICROFINANCE BANK",
        "code" => "090122",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090122"
      ],
      [
        "name" => "GRANTS MICROFINANCE BANK",
        "code" => "090335",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090335"
      ],
      [
        "name" => "GREENBANK MICROFINANCE BANK",
        "code" => "090178",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090178"
      ],
      [
        "name" => "Greenwich Merchant Bank",
        "code" => "060004",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "060004"
      ],
      [
        "name" => "GROOMING MICROFINANCE BANK",
        "code" => "090195",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090195"
      ],
      [
        "name" => "GT MOBILE",
        "code" => "923",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100009"
      ],
      [
        "name" => "GTBank",
        "code" => "058",
        "ussdTemplate" => "*737*2*Amount*AccountNumber#",
        "baseUssdCode" => "*737#",
        "transferUssdTemplate" => "*737*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000013"
      ],
      [
        "name" => "GTI MICROFINANCE BANK",
        "code" => "090385",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090385"
      ],
      [
        "name" => "Hackman Microfinance Bank",
        "code" => "51251",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090147"
      ],
      [
        "name" => "HAGGAI MORTGAGE BANK LIMITED",
        "code" => "070017",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070017"
      ],
      [
        "name" => "HALO MICROFINANCE BANK",
        "code" => "090539",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090539"
      ],
      [
        "name" => "Hasal Microfinance Bank",
        "code" => "50383",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090121"
      ],
      [
        "name" => "HEADWAY MICROFINANCE BANK",
        "code" => "090363",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090363"
      ],
      [
        "name" => "HEDONMARK",
        "code" => "931",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100017"
      ],
      [
        "name" => "Heritage bank",
        "code" => "030",
        "ussdTemplate" => "*322*030*AccountNumber*Amount#",
        "baseUssdCode" => "*322#",
        "transferUssdTemplate" => "*322*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000020"
      ],
      [
        "name" => "HopePSB",
        "code" => "120002",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "120002"
      ],
      [
        "name" => "Ibile Microfinance Bank",
        "code" => "51244",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090118"
      ],
      [
        "name" => "IHIALA MFB",
        "code" => "090725",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090725"
      ],
      [
        "name" => "IKENNE MICROFINANCE BANK",
        "code" => "090324",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090324"
      ],
      [
        "name" => "IKIRE MICROFINANCE BANK",
        "code" => "090275",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090275"
      ],
      [
        "name" => "IKIRE MICROFINANCE BANK",
        "code" => "090279",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090279"
      ],
      [
        "name" => "IKOYI ILE MICROFINANCE BANK",
        "code" => "090681",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090681"
      ],
      [
        "name" => "ILISAN MICROFINANCE BANK",
        "code" => "090370",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090370"
      ],
      [
        "name" => "IMO STATE MICROFINANCE BANK",
        "code" => "090258",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090258"
      ],
      [
        "name" => "IMPERIAL HOMES MORTGAGE BANK",
        "code" => "938",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100024"
      ],
      [
        "name" => "IMSU MICROFINANCE BANK",
        "code" => "090670",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090670"
      ],
      [
        "name" => "Infinity MFB",
        "code" => "50457",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090157"
      ],
      [
        "name" => "INFINITY TRUST MORTGAGE BANK",
        "code" => "070016",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070016"
      ],
      [
        "name" => "INNOVECTIVES KESH",
        "code" => "100029",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100029"
      ],
      [
        "name" => "INSIGHT MICROFINANCE BANK",
        "code" => "090434",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090434"
      ],
      [
        "name" => "INTELLFIN",
        "code" => "941",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100027"
      ],
      [
        "name" => "INTERLAND MICROFINANCE BANK",
        "code" => "090386",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090386"
      ],
      [
        "name" => "IRL MICROFINANCE BANK",
        "code" => "090149",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090149"
      ],
      [
        "name" => "ISALEOYO MICROFINANCE BANK",
        "code" => "090377",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090377"
      ],
      [
        "name" => "ISUA MFB",
        "code" => "090701",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090701"
      ],
      [
        "name" => "ISUOFIA MICROFINANCE BANK",
        "code" => "090353",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090353"
      ],
      [
        "name" => "JAIZ BANK",
        "code" => "301",
        "ussdTemplate" => "*389*301*AccountNumber*Amount#",
        "baseUssdCode" => "*389#",
        "transferUssdTemplate" => "*389*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000006"
      ],
      [
        "name" => "JUBILEE LIFE",
        "code" => "906",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090003"
      ],
      [
        "name" => "KADPOLY MICROFINANCE BANK",
        "code" => "090320",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090320"
      ],
      [
        "name" => "KADUPE MICROFINANCE BANK",
        "code" => "090669",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090669"
      ],
      [
        "name" => "KAYI MICROFINANCE BANK",
        "code" => "090667",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090667"
      ],
      [
        "name" => "Kayvee MICROFINANCE BANK",
        "code" => "090554",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090554"
      ],
      [
        "name" => "Kenechukwu microfinance bank",
        "code" => "513",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090602"
      ],
      [
        "name" => "Keystone bank",
        "code" => "082",
        "ussdTemplate" => "*7111*Amount*AccountNumber#",
        "baseUssdCode" => "*7111#",
        "transferUssdTemplate" => "*7111*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000002"
      ],
      [
        "name" => "KONTAGORA MICROFINANCE BANK",
        "code" => "090299",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090299"
      ],
      [
        "name" => "Kuda MFB",
        "code" => "090267",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "50211"
      ],
      [
        "name" => "Kuda Microfinance Bank",
        "code" => "50211",
        "ussdTemplate" => null,
        "baseUssdCode" => "*5573#",
        "transferUssdTemplate" => "*5573*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "090267"
      ],
      [
        "name" => "LAGOS BUILDING AND INVESTMENT COMPANY",
        "code" => "070012",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070012"
      ],
      [
        "name" => "Lagos Building Investment Company Plc.",
        "code" => "90052",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "90052"
      ],
      [
        "name" => "LAPO MICROFINANCE BANK",
        "code" => "090177",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090177"
      ],
      [
        "name" => "LAVENDER MICROFINANCE BANK",
        "code" => "090271",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090271"
      ],
      [
        "name" => "LEGEND MICROFINANCE BANK",
        "code" => "090372",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090372"
      ],
      [
        "name" => "Letshego MFB",
        "code" => "216",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090420"
      ],
      [
        "name" => "Links Microfinance Bank",
        "code" => "090435",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090435"
      ],
      [
        "name" => "LOMA MICROFINANCE BANK",
        "code" => "090620",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090620"
      ],
      [
        "name" => "LOTUS Bank",
        "code" => "303",
        "ussdTemplate" => "*303#",
        "baseUssdCode" => "",
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000029"
      ],
      [
        "name" => "LOVONUS MICROFINANCE BANK",
        "code" => "090265",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090265"
      ],
      [
        "name" => "M&M MICROFINANCE BANK",
        "code" => "090685",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090685"
      ],
      [
        "name" => "M36",
        "code" => "100035",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100035"
      ],
      [
        "name" => "Madobi MFB",
        "code" => "090605",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => null
      ],
      [
        "name" => "MAINSTREET MICROFINANCE BANK",
        "code" => "090171",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090171"
      ],
      [
        "name" => "MANNY MICROFINANCE BANK",
        "code" => "090383",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090383"
      ],
      [
        "name" => "MAYFAIR MICROFINANCE BANK",
        "code" => "090321",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090321"
      ],
      [
        "name" => "MAYFRESH MORTGAGE BANK",
        "code" => "070019",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070019"
      ],
      [
        "name" => "MEGAPRAISE MICROFINANCE BANK",
        "code" => "090280",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090280"
      ],
      [
        "name" => "MICROVIS MICROFINANCE BANK ",
        "code" => "090113",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090113"
      ],
      [
        "name" => "MINT-FINEX MFB",
        "code" => "090281",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090281"
      ],
      [
        "name" => "MOLUSI MICROFINANCE BANK",
        "code" => "090362",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090362"
      ],
      [
        "name" => "MoMo PSB",
        "code" => "120003",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "120003"
      ],
      [
        "name" => "MONEY BOX",
        "code" => "934",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100020"
      ],
      [
        "name" => "MONEY TRUST MICROFINANCE BANK",
        "code" => "963",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090129"
      ],
      [
        "name" => "MONEYFIELD MICROFINANCE BANK",
        "code" => "090144",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090144"
      ],
      [
        "name" => "Moneymaster PSB",
        "code" => "120005",
        "ussdTemplate" => "*0000#",
        "baseUssdCode" => "",
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "120005"
      ],
      [
        "name" => "Moniepoint Microfinance Bank",
        "code" => "50515",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090405"
      ],
      [
        "name" => "MOZFIN MICROFINANCE BANK",
        "code" => "090392",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090392"
      ],
      [
        "name" => "MUTUAL ALLIANCE MORTGAGE BANK",
        "code" => "070028",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070028"
      ],
      [
        "name" => "MUTUAL BENEFITS MFB",
        "code" => "090190",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090190"
      ],
      [
        "name" => "MUTUAL TRUST MICROFINANCE BANK",
        "code" => "090151",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090151"
      ],
      [
        "name" => "NDDC MICROFINANCE BANK",
        "code" => "90679",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "90679"
      ],
      [
        "name" => "NDIORAH MICROFINANCE BANK",
        "code" => "090128",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090128"
      ],
      [
        "name" => "NEPTUNE MICROFINANCE BANK",
        "code" => "090329",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090329"
      ],
      [
        "name" => "NET MFB",
        "code" => "90675",
        "ussdTemplate" => "0001",
        "baseUssdCode" => "",
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "90675"
      ],
      [
        "name" => "NET MFB",
        "code" => "090675",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090675"
      ],
      [
        "name" => "NEW DAWN MICROFINANCE BANK",
        "code" => "090205",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090205"
      ],
      [
        "name" => "NEW GOLDEN PASTURES MICROFINANCE BANK",
        "code" => "090378",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090378"
      ],
      [
        "name" => "NIGERIAN NAVY MICROFINANCE BANK ",
        "code" => "090263",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090263"
      ],
      [
        "name" => "NIRSAL NATIONAL MICROFINANCE BANK",
        "code" => "090194",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090194"
      ],
      [
        "name" => "NNEW WOMEN MICROFINANCE BANK",
        "code" => "090283",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090283"
      ],
      [
        "name" => "NOVA MERCHANT BANK",
        "code" => "637",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "060003"
      ],
      [
        "name" => "NOVUS MFB",
        "code" => "090734",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090734"
      ],
      [
        "name" => "NPF MICROFINANCE BANK",
        "code" => "947",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070001"
      ],
      [
        "name" => "NUGGETS MFB",
        "code" => "090676",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090676"
      ],
      [
        "name" => "NUTURE MICROFINANCE BANK",
        "code" => "090364",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090364"
      ],
      [
        "name" => "NWANNEGADI MICROFINANCE BANK",
        "code" => "090399",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090399"
      ],
      [
        "name" => "OCHE MICROFINANCE BANK",
        "code" => "090333",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090333"
      ],
      [
        "name" => "OCTOPUS MICROFINANCE BANK",
        "code" => "090576",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090576"
      ],
      [
        "name" => "OHAFIA MICROFINANCE BANK",
        "code" => "090119",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090119"
      ],
      [
        "name" => "OK MICROFINANCE BANK",
        "code" => "090567",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090567"
      ],
      [
        "name" => "OKENGWE MICROFINANCE BANK",
        "code" => "090646",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090646"
      ],
      [
        "name" => "OKPOGA MICROFINANCE BANK",
        "code" => "090161",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090161"
      ],
      [
        "name" => "OLABISI ONABANJO UNIVERSITY MICROFINANCE ",
        "code" => "090272",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090272"
      ],
      [
        "name" => "OLIVE MFB",
        "code" => "090696",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090696"
      ],
      [
        "name" => "OMIYE MICROFINANCE BANK",
        "code" => "090295",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090295"
      ],
      [
        "name" => "OMOLUABI",
        "code" => "950",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070007"
      ],
      [
        "name" => "OPAY 3",
        "code" => "999992",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "999992"
      ],
      [
        "name" => "OPTIMUS BANK",
        "code" => "00107",
        "ussdTemplate" => "0000",
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000036"
      ],
      [
        "name" => "OSCOTECH MICROFINANCE BANK",
        "code" => "090396",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090396"
      ],
      [
        "name" => "OTUO MICROFINANCE BANK",
        "code" => "090542",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090542"
      ],
      [
        "name" => "PAGA",
        "code" => "327",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100002"
      ],
      [
        "name" => "PAGA - 100002",
        "code" => "100002",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "327"
      ],
      [
        "name" => "PAGE MFBank",
        "code" => "951",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070008"
      ],
      [
        "name" => "PALMPAY",
        "code" => "100033",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100033"
      ],
      [
        "name" => "PARALLEX",
        "code" => "907",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000030"
      ],
      [
        "name" => "PARKWAY-READYCASH",
        "code" => "917",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100003"
      ],
      [
        "name" => "PATHFINDER MICROFINANACE BANK LIMITED",
        "code" => "090680",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090680"
      ],
      [
        "name" => "PATRICKGOLD MICROFINANCE BANK",
        "code" => "090317",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090317"
      ],
      [
        "name" => "PAYATTITUDE ONLINE",
        "code" => "943",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "110001"
      ],
      [
        "name" => "PAYCOM (OPAY)",
        "code" => "305",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100004"
      ],
      [
        "name" => "PAYSTACK PAYMENTS LIMITED",
        "code" => "110006",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "110006"
      ],
      [
        "name" => "PECANTRUST MICROFINANCE BANK",
        "code" => "090137",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090137"
      ],
      [
        "name" => "PENNYWISE MICROFINANCE BANK ",
        "code" => "090196",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090196"
      ],
      [
        "name" => "PERSONAL TRUST MICROFINANCE BANK",
        "code" => "090135",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090135"
      ],
      [
        "name" => "Petra Mircofinance Bank Plc",
        "code" => "50746",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090165"
      ],
      [
        "name" => "PFI FINANCE COMPANY LIMITED",
        "code" => "050021",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "050021"
      ],
      [
        "name" => "PILLAR MICROFINANCE BANK",
        "code" => "090289",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090289"
      ],
      [
        "name" => "PLATINUM MORTGAGE BANK",
        "code" => "070013",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070013"
      ],
      [
        "name" => "Polaris Bank",
        "code" => "076",
        "ussdTemplate" => "*833*Amount*AccountNumber#",
        "baseUssdCode" => "*833#",
        "transferUssdTemplate" => "*833*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000008"
      ],
      [
        "name" => "POLYIBADAN MFB",
        "code" => "090534",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090534"
      ],
      [
        "name" => "POLYUNWANA MICROFINANCE BANK",
        "code" => "090296",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090296"
      ],
      [
        "name" => "Premium Trust Bank",
        "code" => "105",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000031"
      ],
      [
        "name" => "PRESTIGE MICROFINANCE BANK",
        "code" => "090274",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090274"
      ],
      [
        "name" => "PROSPECTS MFB",
        "code" => "090689",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090689"
      ],
      [
        "name" => "PROSPERITY MFB",
        "code" => "090642",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090642"
      ],
      [
        "name" => "Providus Bank",
        "code" => "101",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000023"
      ],
      [
        "name" => "PRUDENT MICROFINANCE BANK",
        "code" => "090690",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090690"
      ],
      [
        "name" => "PURPLEMONEY MICROFINANCE BANK",
        "code" => "090303",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090303"
      ],
      [
        "name" => "Qube Microfinance Bank",
        "code" => "090569",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090569"
      ],
      [
        "name" => "QUICKFUND MICROFINANCE BANK",
        "code" => "090261",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090261"
      ],
      [
        "name" => "RAND MERCHANT BANK",
        "code" => "502",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000024"
      ],
      [
        "name" => "RANDALPHA MICROFINANCE BANK",
        "code" => "90496",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "90496"
      ],
      [
        "name" => "Randalpha Microfinance Bank",
        "code" => "090496",
        "ussdTemplate" => "*#*",
        "baseUssdCode" => "*#*",
        "transferUssdTemplate" => "*#*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "090496"
      ],
      [
        "name" => "REFUGE MORTGAGE BANK",
        "code" => "070011",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "070011"
      ],
      [
        "name" => "REGENT MICROFINANCE BANK",
        "code" => "955",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090125"
      ],
      [
        "name" => "Rehoboth Microfinance bank",
        "code" => "090463",
        "ussdTemplate" => "*0000*AccountNumber*Amount#",
        "baseUssdCode" => "*000#",
        "transferUssdTemplate" => "*000*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "090463"
      ],
      [
        "name" => "RENMONEY MICROFINANCE BANK ",
        "code" => "090198",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090198"
      ],
      [
        "name" => "REPHIDIM MICROFINANCE BANK",
        "code" => "090322",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090322"
      ],
      [
        "name" => "REX Microfinance Bank",
        "code" => "090449",
        "ussdTemplate" => "090449",
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => null
      ],
      [
        "name" => "RICHWAY MICROFINANCE BANK",
        "code" => "090132",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090132"
      ],
      [
        "name" => "ROCKSHIELD MICROFINANCE BANK",
        "code" => "090547",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090547"
      ],
      [
        "name" => "ROYAL EXCHANGE MICROFINANCE BANK",
        "code" => "090138",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090138"
      ],
      [
        "name" => "RSU MICROFINANCE BANK",
        "code" => "090535",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090535"
      ],
      [
        "name" => "Rubies Micro-finance Bank",
        "code" => "125",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090175"
      ],
      [
        "name" => "SAFE HAVEN MICROFINANCE BANK",
        "code" => "090286",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090286"
      ],
      [
        "name" => "SAFETRUST",
        "code" => "909",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090006"
      ],
      [
        "name" => "SAGAMU MICROFINANCE BANK",
        "code" => "966",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090140"
      ],
      [
        "name" => "SEAP Microfinance Bank",
        "code" => "090513",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090513"
      ],
      [
        "name" => "SEED CAPITAL MICROFINANCE BANK",
        "code" => "609",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090112"
      ],
      [
        "name" => "SEEDVEST MICROFINANCE BANK",
        "code" => "090369",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090369"
      ],
      [
        "name" => "SHALOM MFB",
        "code" => "090502",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090502"
      ],
      [
        "name" => "Signature Bank",
        "code" => "000034",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000034"
      ],
      [
        "name" => "SmartCash",
        "code" => "00803",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "120004"
      ],
      [
        "name" => "Sparkle Microfinance Bank",
        "code" => "51310",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090325"
      ],
      [
        "name" => "STANBIC IBTC @Ease WALLET",
        "code" => "921",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100007"
      ],
      [
        "name" => "Stanbic IBTC Bank Ltd.",
        "code" => "221",
        "ussdTemplate" => "*909*22*Amount*AccountNumber#",
        "baseUssdCode" => "*909#",
        "transferUssdTemplate" => "*909*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000012"
      ],
      [
        "name" => "Standard Chartered Bank Nigeria Ltd.",
        "code" => "068",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000021"
      ],
      [
        "name" => "STANFORD MICROFINANACE BANK",
        "code" => "090162",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090162"
      ],
      [
        "name" => "STELLAS MICROFINANCE BANK ",
        "code" => "090262",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090262"
      ],
      [
        "name" => "Sterling bank",
        "code" => "232",
        "ussdTemplate" => "*822*5*Amount*AccountNumber#",
        "baseUssdCode" => "*822#",
        "transferUssdTemplate" => "*822*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000001"
      ],
      [
        "name" => "STERLING MOBILE",
        "code" => "936",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100022"
      ],
      [
        "name" => "SULSPAP MICROFINANCE BANK",
        "code" => "090305",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090305"
      ],
      [
        "name" => "Suntrust Bank Nigeria Limited",
        "code" => "100",
        "ussdTemplate" => "",
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000022"
      ],
      [
        "name" => "TAGPAY",
        "code" => "937",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100023"
      ],
      [
        "name" => "Taj Bank",
        "code" => "302",
        "ussdTemplate" => null,
        "baseUssdCode" => "*898#",
        "transferUssdTemplate" => "*898*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000026"
      ],
      [
        "name" => "Taj_Pinspay",
        "code" => "080002",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "080002"
      ],
      [
        "name" => "TCF MFB",
        "code" => "51211",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090115"
      ],
      [
        "name" => "TEASY MOBILE",
        "code" => "924",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100010"
      ],
      [
        "name" => "THINK FINANCE MICROFINANCE BANK",
        "code" => "090373",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090373"
      ],
      [
        "name" => "Titan Bank",
        "code" => "102",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "000025"
      ],
      [
        "name" => "TITAN-PAYSTACK MICROFINANCE BANK",
        "code" => "100039",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100039"
      ],
      [
        "name" => "TREASURES MICROFINANCE BANK",
        "code" => "090663",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090663"
      ],
      [
        "name" => "TRIDENT MICROFINANCE BANK",
        "code" => "090146",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090146"
      ],
      [
        "name" => "TRIVES FINANCE COMPANY LTD",
        "code" => "050023",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "050023"
      ],
      [
        "name" => "TRUST MICROFINANCE BANK",
        "code" => "090327",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090327"
      ],
      [
        "name" => "TRUSTBANC J6 MICROFINANCE BANK LIMITED",
        "code" => "090123",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090123"
      ],
      [
        "name" => "TRUSTFUND MICROFINANCE BANK ",
        "code" => "090276",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090276"
      ],
      [
        "name" => "TSANYAWA MICROFINANCE BANK",
        "code" => "090672",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090672"
      ],
      [
        "name" => "U & C MICROFINANCE BANK",
        "code" => "090315",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090315"
      ],
      [
        "name" => "UCEE MFB",
        "code" => "090706",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090706"
      ],
      [
        "name" => "UMUCHINEMERE PROCREDIT MICROFINANCE BANK",
        "code" => "090514",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090514"
      ],
      [
        "name" => "UNAAB MICROFINANCE BANK",
        "code" => "090331",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090331"
      ],
      [
        "name" => "Unical Microfinance Bank",
        "code" => "50871",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090193"
      ],
      [
        "name" => "Union bank",
        "code" => "032",
        "ussdTemplate" => "*826*2*Amount*AccountNumber#",
        "baseUssdCode" => "*826#",
        "transferUssdTemplate" => "*826*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000018"
      ],
      [
        "name" => "United Bank For Africa Plc",
        "code" => "033",
        "ussdTemplate" => "*919*4*AccountNumber*Amount#",
        "baseUssdCode" => "*919#",
        "transferUssdTemplate" => "*919*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000004"
      ],
      [
        "name" => "Unity Bank Plc",
        "code" => "215",
        "ussdTemplate" => "*7799*2*AccountNumber*Amount#",
        "baseUssdCode" => "*7799#",
        "transferUssdTemplate" => "*7799*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000011"
      ],
      [
        "name" => "UNIUYO MICROFINANCE BANK",
        "code" => "090338",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090338"
      ],
      [
        "name" => "UNIVERSITY OF NIGERIA, NSUKKA MICROFINANCE BANK",
        "code" => "090251",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090251"
      ],
      [
        "name" => "URE MICROFINANCE BANK",
        "code" => "090619",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090619"
      ],
      [
        "name" => "VENTURE GARDEN NIGERIA LIMITED",
        "code" => "110009",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "110009"
      ],
      [
        "name" => "VFD microfinance bank",
        "code" => "566",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090110"
      ],
      [
        "name" => "VIRTUE MICROFINANCE BANK",
        "code" => "090150",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090150"
      ],
      [
        "name" => "VISA MICROFINANCE BANK",
        "code" => "090139",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090139"
      ],
      [
        "name" => "VT NETWORKS",
        "code" => "926",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100012"
      ],
      [
        "name" => "Wema bank",
        "code" => "035",
        "ussdTemplate" => "*945*AccountNumber*Amount#",
        "baseUssdCode" => "*945#",
        "transferUssdTemplate" => "*945*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000017"
      ],
      [
        "name" => "WESLEY MFB",
        "code" => "090699",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090699"
      ],
      [
        "name" => "WETLAND  MICROFINANCE BANK LIMITED",
        "code" => "954",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090120"
      ],
      [
        "name" => "WRA MFB",
        "code" => "090631",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090631"
      ],
      [
        "name" => "WUDIL MICROFINANCE BANK",
        "code" => "090253",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090253"
      ],
      [
        "name" => "Xpress Wallet",
        "code" => "100040",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100040"
      ],
      [
        "name" => "XSLNCE MICROFINANCE BANK",
        "code" => "090124",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090124"
      ],
      [
        "name" => "YES MICROFINANCE BANK",
        "code" => "090142",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090142"
      ],
      [
        "name" => "YOBE MICROFINANCE  BANK",
        "code" => "090252",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090252"
      ],
      [
        "name" => "Zenith bank",
        "code" => "057",
        "ussdTemplate" => "*966*Amount*AccountNumber#",
        "baseUssdCode" => "*966#",
        "transferUssdTemplate" => "*966*AccountNumber#",
        "bankId" => null,
        "nipBankCode" => "000015"
      ],
      [
        "name" => "ZENITH MOBILE",
        "code" => "932",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100018"
      ],
      [
        "name" => "ZINTERNET - KONGAPAY",
        "code" => "939",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "100025"
      ],
      [
        "name" => "Zitra MfB",
        "code" => "090718",
        "ussdTemplate" => null,
        "baseUssdCode" => null,
        "transferUssdTemplate" => null,
        "bankId" => null,
        "nipBankCode" => "090718"
      ]
    ];

    $banks = collect($banks);
    $bank = $banks->firstWhere('code', $bankcode);

    return $bank['name'] ?? 'Bank not found';
  }
}

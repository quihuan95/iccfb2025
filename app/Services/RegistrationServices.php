<?php

namespace App\Services;

use App\Mail\RegistrationConfirmed;
use App\Mail\RegistrationWireTransfer;
use App\Models\Registration;
use Illuminate\Support\Facades\Mail;

class RegistrationServices
{
  public $registration;

  public function __construct(Registration $registration)
  {
    $this->registration = $registration;
  }

  public function create($data = [])
  {
    return $this->registration->create($data);
  }

  public function sendMail($registration)
  {
    Mail::to($registration->email)
      ->cc([
        'iccfb@hcmut.edu.vn',
        'vicky@hoabinhtourist.com',
        'dh.qt2@hoabinh-group.com',
      ])
      ->send(new RegistrationConfirmed($registration->toArray()));
  }

  public function sendMailWireTransfer($registration)
  {
    Mail::to($registration->email)
      ->cc([
        'iccfb@hcmut.edu.vn',
        'vicky@hoabinhtourist.com',
        'dh.qt2@hoabinh-group.com',
      ])
      ->send(new RegistrationWireTransfer($registration->toArray()));
  }

  public function makeOnepayUrl($data)
  {
    $SECURE_SECRET = "E89978A34FCD1E64B44DB6F063068771";
    $vpcURL = "https://onepay.vn/vpcpay/vpcpay.op?";

    $data['amount'] = json_decode($data['display_conference'])->fee;
    $data['currency'] = json_decode($data['display_conference'])->currency;
    $vpc_AccessCode = '7763F5C5';
    $vpc_Merchant = 'HOABINHTOUR2';
    if ($data['currency'] == 'VND') {
      $vpc_AccessCode = '37A07C2E';
      $vpc_Merchant = 'HBTOUR2';
      $SECURE_SECRET = '2A15C553DC9DBC44284A2020DD489C42';
    }

    // dd($data);

    $amount = $data['amount'] * "106"; // nhân 100 để đổi sang cent + phí 6%
    $queryString = http_build_query($data);
    $returnUrl = config('app.url') . '/registration/payment-response?' . $queryString;
    $onepay = [
      'vpc_Version' => '2',
      'vpc_Command' => 'pay',
      'vpc_AccessCode' => $vpc_AccessCode,
      'vpc_Merchant' => $vpc_Merchant,
      'vpc_Locale' => 'en',
      'vpc_Currency' => $data['currency'],
      'vpc_ReturnURL' => $returnUrl,
      'vpc_MerchTxnRef' => time(),
      'vpc_OrderInfo' => $data['registration_code'],
      'vpc_Amount' => $amount,
    ];

    ksort($onepay);
    $hashData = '';
    $queryString = '';

    foreach ($onepay as $key => $value) {
      if ($value !== '') {
        $queryString .= urlencode($key) . '=' . urlencode($value) . '&';
        $hashData .= $key . '=' . $value . '&';
      }
    }

    // Cắt dấu & cuối
    $queryString = rtrim($queryString, '&');
    $hashData = rtrim($hashData, '&');

    // Tạo chuỗi hash
    $secureHash = strtoupper(hash_hmac('SHA256', $hashData, pack('H*', $SECURE_SECRET)));

    // Thêm hash và kiểu hash vào query
    $queryString .= '&vpc_SecureHash=' . $secureHash;
    $queryString .= '&vpc_SecureHashType=SHA256';

    return $vpcURL . $queryString;
  }
}
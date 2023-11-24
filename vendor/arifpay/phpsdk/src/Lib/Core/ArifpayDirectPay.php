<?php

namespace Arifpay\Phpsdk\Lib\Core;

use Arifpay\Phpsdk\Lib\Core\DirectPay\ArifpayAwash;
use Arifpay\Phpsdk\Lib\Core\DirectPay\ArifpayAwashWallet;
use Arifpay\Phpsdk\Lib\Core\DirectPay\ArifpayTelebirr;

class ArifpayDirectPay
{
    // TODO: transactionStatus: string; change to enum
    // TODO: paymentType: string; change to enum


    public $http_client;

    public $telebirr;
    public $awash;
    public $awash_wallet;

    public function __construct($http_client)
    {
        $this->http_client = $http_client;
        $this->telebirr = new ArifpayTelebirr($this->http_client);
        $this->awash = new ArifpayAwash($this->http_client);
        $this->awash_wallet = new ArifpayAwashWallet($this->http_client);
    }
}

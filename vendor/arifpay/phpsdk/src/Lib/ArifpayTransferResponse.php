<?php

namespace Arifpay\Phpsdk\Lib;

use JsonSerializable;

class ArifpayTransferResponse implements JsonSerializable
{
    public $session_id;
    public $url;
    public $otp;
    public $transcation;

    public function __construct(
        $session_id,
        $url,
        $otp,
        $transaction
    ) {
        $this->transaction = $transaction;
        $this->session_id = $session_id;
        $this->url = $url;
        $this->otp = $otp;
    }

    public function jsonSerialize()
    {
        return [
            "session_id" => $this->session_id,
            "url" => $this->url,
            "otp" => $this->otp,
            "transaction" => $this->transaction,
        ];
    }

    public static function fromJson($data)
    {
        return new ArifpayTransferResponse($data["sessionId"], isset($data["url"]) ? urldecode($data["url"]) : "", isset($data["otp"]) ? urldecode($data["otp"]) : "", isset($json["transaction"]) ? ArifpayTransaction::fromJson($json["transaction"]) : null);
    }
}

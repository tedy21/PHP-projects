<?php

namespace Arifpay\Phpsdk\Helper;

use Arifpay\Phpsdk\Lib\Exception\ArifpayBadRequestException;
use Arifpay\Phpsdk\Lib\Exception\ArifpayException;
use Arifpay\Phpsdk\Lib\Exception\ArifpayNetworkException;
use Arifpay\Phpsdk\Lib\Exception\ArifpayNotFoundException;
use Arifpay\Phpsdk\Lib\Exception\ArifpayUnAuthorizedException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Carbon;

class ArifpaySupport
{
    public static function getExpireDateFromDate(Carbon $date)
    {
        return $date->toDateTimeLocalString();
    }

    public static function __handleException(ClientException $e)
    {
        $response = $e->getResponse();
        if ($response) {
            if ($response->getStatusCode() == 401) {
                throw new ArifpayUnAuthorizedException('Invalid authentication credentials', $e);
            }
            if ($response->getStatusCode() === 400) {
                $responseBodyAsString = $response->getBody()->getContents();
                $msg = "Invalid Request, check your Request body.";
                if (! empty($responseBodyAsString)) {
                    $responseJson = json_decode($responseBodyAsString, true);
                    $msg = $responseJson["msg"];
                }

                throw new ArifpayBadRequestException($msg, $e);
            }
            if ($response->getStatusCode() === 404) {
                $responseBodyAsString = $response->getBody()->getContents();
                $msg = "Invalid Request, Not found.";
                if (! empty($responseBodyAsString)) {
                    $responseJson = json_decode($responseBodyAsString, true);
                    $msg = $responseJson["msg"];
                }

                throw new ArifpayNotFoundException($msg, $e);
            }

            throw new ArifpayException($e->response->data["msg"], $e);
        } else {
            throw new ArifpayNetworkException($e);
        }
    }
}

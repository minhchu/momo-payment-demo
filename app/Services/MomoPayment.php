<?php

namespace App\Services;

use GuzzleHttp\Client;

class MomoPayment
{
    /**
     * @var string
     */
    protected $apiEndpoint;

    /**
     * @var string
     */
    protected $partnerCode;

    /**
     * @var string
     */
    protected $accessKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $notifyUrl;

    /**
     * @var string
     */
    protected $returnUrl;

    /**
     * Http Client
     */
    protected $httpClient;

    /**
     * @param string $apiEndpoint
     * @param string $partnerCode
     * @param string $accessKey
     * @param string $secretKey
     */
    public function __construct(
        $apiEndpoint, 
        $partnerCode, 
        $accessKey,
        $secretKey
    )
    {
        $this->apiEndpoint = $apiEndpoint;
        $this->partnerCode = $partnerCode;
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->httpClient = new Client([
            'base_uri' => $apiEndpoint
        ]);
    }

    /**
     * @param string $url
     *
     * @return MomoPayment
     */
    public function setNotifyUrl($url)
    {
        $this->notifyUrl = $url;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return MomoPayment
     */
    public function setReturnUrl($url)
    {
        $this->returnUrl = $url;

        return $this;
    }

    /**
     * @return namespace Psr\Http\Message;
     */
    public function requestPayment($orderId, $orderInfo, $amount)
    {
        $body = $this->requestObject([
            'orderId'     => $orderId,
            'orderInfo'   => $orderInfo,
            'amount'      => $amount,
            'extraData'   => '',
            'requestId'   => ''.time(),
            'requestType' => 'captureMoMoWallet'
        ]);

        return $this->httpClient->post('gw_payment/transactionProcessor', [
            'body' => json_encode($body)
        ]);
    }

    protected function sign($data, $key)
    {
        return hash_hmac('sha256', $data, $key);
    }

    protected function requestObject($params)
    {
        $data = [
            'partnerCode' => $this->partnerCode,
            'accessKey'   => $this->accessKey,
            'returnUrl'   => $this->returnUrl,
            'notifyUrl'   => $this->notifyUrl,
            'requestId'   => '',
            'amount'      => '',
            'orderId'     => '',
            'orderInfo'   => '',
            'requestType' => '',
            'signature'   => '',
            'extraData'   => ''
        ];

        $data['requestId']   = $params['requestId'];
        $data['requestType'] = $params['requestType'];
        $data['amount']      = $params['amount'];
        $data['orderId']     = $params['orderId'];
        $data['orderInfo']   = $params['orderInfo'];
        $data['extraData']   = $params['extraData'];

        $signature = "partnerCode={$data['partnerCode']}&accessKey={$data['accessKey']}&requestId={$data['requestId']}&amount={$data['amount']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&returnUrl={$data['returnUrl']}&notifyUrl={$data['notifyUrl']}&extraData={$data['extraData']}";

        $data['signature'] = $this->sign($signature, $this->secretKey);

        return $data;
    }
}

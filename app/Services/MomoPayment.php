<?php

namespace App\Services;

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
    }
}

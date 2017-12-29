<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use GuzzleHttp\Client;
use Yamilovs\Bundle\SmsBundle\Exception\SmsAeroException;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class SmsAeroProvider implements ProviderInterface
{
    const BASE_URI = 'https://gate.smsaero.ru';
    const SMS_SEND_URI = '/v2/sms/send';

    /**
     * @var string
     */
    private $user;
    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $sign;
    /**
     * @var string
     */
    private $channel;

    public function __construct(string $user, string $apiKey, string $sign, string $channel)
    {
        $this->user = $user;
        $this->apiKey = $apiKey;
        $this->sign = $sign;
        $this->channel = $channel;
    }

    public function send(SmsInterface $sms)
    {
        $data = [
            'headers' => [
                'accept' => 'application/json'
            ],
            'auth' => [
                $this->user,
                $this->apiKey
            ],
            'form_params' => [
                'sign' => $this->sign,
                'channel' => $this->channel,
                'number' => $sms->getPhoneNumber(),
                'text' => $sms->getMessage(),
            ]
        ];

        $client = new Client(['base_uri' => self::BASE_URI, 'timeout' => 10,]);
        $response = $client->post(self::SMS_SEND_URI, $data);
        $jsonResponse = json_decode($response->getBody()->getContents());

        if (!$jsonResponse->success === true) {
            throw new SmsAeroException(json_encode($jsonResponse));
        }

        return true;
    }
}
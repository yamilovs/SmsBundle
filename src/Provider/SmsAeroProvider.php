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

    /**
     * @param string $user
     *
     * @return SmsAeroProvider
     */
    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param string $apiKey
     *
     * @return SmsAeroProvider
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param string $sign
     *
     * @return SmsAeroProvider
     */
    public function setSign(string $sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    /**
     * @param string $channel
     *
     * @return SmsAeroProvider
     */
    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
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
                'dateSend' => $sms->getDateTime()->getTimestamp(),
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
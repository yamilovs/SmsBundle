<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Yamilovs\Bundle\SmsBundle\Exception\SmsAeroException;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class SmsAeroProvider implements ProviderInterface
{
    private const SMS_SEND_URI = 'https://gate.smsaero.ru/v2/sms/send';

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
     * @var ClientInterface
     */
    private $client;

    public function __construct()
    {
        $this->setClient(new Client());
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function setSign(string $sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    private function getPostData(SmsInterface $sms): array
    {
        return [
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
    }

    public function send(SmsInterface $sms): bool
    {
        $response = $this->client->request('POST', self::SMS_SEND_URI, $this->getPostData($sms));
        $jsonResponse = json_decode($response->getBody()->getContents());

        if (!$jsonResponse->success === true) {
            throw new SmsAeroException(json_encode($jsonResponse));
        }

        return true;
    }
}
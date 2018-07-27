<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Yamilovs\Bundle\SmsBundle\Exception\SmsRuException;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class SmsRuProvider implements ProviderInterface
{
    private const SMS_SEND_URI = 'https://sms.ru/sms/send';

    /**
     * @var string
     */
    private $apiId;

    /**
     * @var string
     */
    private $from;

    /**
     * @var bool
     */
    private $test;

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct()
    {
        $this->setClient(new Client());
    }

    public function setApiId(string $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }

    public function setFrom(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function setTest(bool $test): self
    {
        $this->test = $test;

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
            'form_params' => [
                'api_id' => $this->apiId,
                'from' => $this->from,
                'to' => $sms->getPhoneNumber(),
                'msg' => $sms->getMessage(),
                'time' => $sms->getDateTime()->getTimestamp(),
                'test' => (int)$this->test,
            ],
        ];
    }

    public function send(SmsInterface $sms): bool
    {
        $response = $this->client->request('POST', self::SMS_SEND_URI, $this->getPostData($sms));
        $responseCode = (int)$response->getBody()->read(3);

        if ($responseCode != 100) {
            throw new SmsRuException($responseCode);
        }

        return true;
    }
}
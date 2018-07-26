<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use GuzzleHttp\Client;
use Yamilovs\Bundle\SmsBundle\Exception\SmsRuException;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class SmsRuProvider implements ProviderInterface
{
    const BASE_URI = 'https://sms.ru';
    const SMS_SEND_URI = '/sms/send';

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
     * @param string $apiId
     *
     * @return SmsRuProvider
     */
    public function setApiId(string $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }

    /**
     * @param string $from
     *
     * @return SmsRuProvider
     */
    public function setFrom(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param bool $test
     *
     * @return SmsRuProvider
     */
    public function setTest(bool $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function send(SmsInterface $sms)
    {
        $data = [
            'form_params' => [
                'api_id' => $this->apiId,
                'from' => $this->from,
                'to' => $sms->getPhoneNumber(),
                'msg' => $sms->getMessage(),
                'time' => $sms->getDateTime()->getTimestamp(),
            ]
        ];

        if ($this->test) {
            $data['form_params']['test'] = 1;
        }

        $client = new Client(['base_uri' => self::BASE_URI, 'timeout' => 10,]);
        $response = $client->post(self::SMS_SEND_URI, $data);
        $responseCode = (int) $response->getBody()->read(3);

        if ($responseCode != 100) {
            throw new SmsRuException($responseCode);
        }

        return true;
    }
}
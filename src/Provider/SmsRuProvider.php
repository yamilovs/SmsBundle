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

    public function __construct(string $apiId, string $from, bool $test)
    {
        $this->apiId = $apiId;
        $this->from = $from;
        $this->test = $test;
    }

    public function send(SmsInterface $sms)
    {
        $postData = [
            'form_params' => [
                'api_id' => $this->apiId,
                'from' => $this->from,
                'to' => $sms->getPhoneNumber(),
                'msg' => $sms->getMessage(),
            ]
        ];

        if ($this->test) {
            $postData[0]['test'] = 1;
        }

        $client = new Client(['base_uri' => self::BASE_URI, 'timeout' => 10,]);
        $response = $client->post(self::SMS_SEND_URI, $postData);
        $responseCode = (int) $response->getBody()->read(3);

        if ($responseCode != 100) {
            throw new SmsRuException($responseCode);
        }

        return true;
    }
}
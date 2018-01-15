<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use GuzzleHttp\Client;
use Yamilovs\Bundle\SmsBundle\Exception\SmsCenterException;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class SmsCenterProvider implements ProviderInterface
{
    const BASE_URI = 'https://smsc.ru';
    const SMS_SEND_URI = '/sys/send.php';

    const RESPONSE_FORMAT = [
        'STRING' => 0, // "OK - 1 SMS, ID - 12345", where 1 - message count and 12345 message id
        'INTEGER' => 1, // "12345,1"
        'XML' => 2, // response in XML format
        'JSON' => 3, // response in json format
    ];
    const MESSAGE_CHARSET = [
        'WINDOWS-1251' => 'windows-1251',
        'UTF-8' => 'utf-8',
        'KOI8-R' => 'koi8-r',
    ];

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var null|string
     */
    private $sender;

    /**
     * @var bool
     */
    private $flash;

    public function __construct(string $login, string $password, ?string $sender, bool $flash)
    {
        $this->login = $login;
        $this->password = $password;
        $this->sender = $sender;
        $this->flash = $flash;
    }

    public function send(SmsInterface $sms)
    {
        $data = [
            'form_params' => [
                'login' => $this->login,
                'psw' => mb_strtolower(md5($this->password)),
                'phones' => $sms->getPhoneNumber(),
                'mes' => $sms->getMessage(),
                'time' => '0'.$sms->getDateTime()->getTimestamp(), // Use timestamp time format
                'fmt' => self::RESPONSE_FORMAT['JSON'], // Get response in json format
                'charset' => self::MESSAGE_CHARSET['UTF-8'], // Use unicode charset in message text
            ]
        ];

        if ($this->sender) {
            $data['form_params']['sender'] = $this->sender;
        }

        if ($this->flash) {
            $data['form_params']['flash'] = 1;
        }

        $client = new Client(['base_uri' => self::BASE_URI, 'timeout' => 10,]);
        $response = $client->post(self::SMS_SEND_URI, $data);
        $jsonResponse = json_decode($response->getBody()->getContents());

        if (property_exists($jsonResponse, 'error_code')) {
            throw new SmsCenterException($jsonResponse->error_code);
        }

        return true;
    }
}
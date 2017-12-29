<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use GuzzleHttp\Client;
use Yamilovs\Bundle\SmsBundle\Exception\SmsDiscountException;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class SmsDiscountProvider implements ProviderInterface
{
    const BASE_URI = 'http://api.iqsms.ru';
    const SMS_SEND_URI = '/messages/v2/send/';

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
            'auth' => [
                $this->login,
                $this->password
            ],
            'form_params' => [
                'phone' => $sms->getPhoneNumber(),
                'text' => $sms->getMessage(),
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
        $responseData = explode($response->getBody()->getContents(), ';');

        if ($responseData[0] != 'accepted') {
            throw new SmsDiscountException($responseData[1]);
        }

        return true;
    }
}
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

    /**
     * @param string $login
     *
     * @return SmsDiscountProvider
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return SmsDiscountProvider
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param null|string $sender
     *
     * @return SmsDiscountProvider
     */
    public function setSender(?string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @param bool $flash
     *
     * @return SmsDiscountProvider
     */
    public function setFlash(bool $flash): self
    {
        $this->flash = $flash;

        return $this;
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
                'scheduleTime' => $sms->getDateTime()->format(\DateTime::RFC3339)
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
        $responseData = explode(';', $response->getBody()->getContents());

        if ($responseData[0] != 'accepted') {
            throw new SmsDiscountException($responseData[1]);
        }

        return true;
    }
}
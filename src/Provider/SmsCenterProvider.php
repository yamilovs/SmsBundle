<?php

namespace Yamilovs\Bundle\SmsBundle\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Yamilovs\Bundle\SmsBundle\Exception\SmsCenterException;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class SmsCenterProvider implements ProviderInterface
{
    private const SMS_SEND_URI = 'https://smsc.ru/sys/send.php';

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
     * @var ClientInterface
     */
    private $client;

    public function __construct()
    {
        $this->setClient(new Client());
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setSender(?string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function setFlash(bool $flash): self
    {
        $this->flash = $flash;

        return $this;
    }

    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    private function getTime(\DateTime $dateTime): string
    {
        // Zero at returned string mean that we send timestamp time format
        return sprintf('0%s', $dateTime->getTimestamp());
    }

    private function getPassword(): string
    {
        return mb_strtolower(md5($this->password));
    }

    private function getPostData(SmsInterface $sms): array
    {
        $post = [
            'form_params' => [
                'login' => $this->login,
                'psw' => $this->getPassword(),
                'phones' => $sms->getPhoneNumber(),
                'mes' => $sms->getMessage(),
                'time' => $this->getTime($sms->getDateTime()),
                'flash' => (int)$this->flash,
                'fmt' => 3, // Get response in json format
                'charset' => 'utf-8', // Use unicode charset in message text
            ]
        ];

        if ($this->sender) {
            $post['form_params']['sender'] = $this->sender;
        }

        return $post;
    }

    public function send(SmsInterface $sms): bool
    {
        $response = $this->client->request('POST', self::SMS_SEND_URI, $this->getPostData($sms));
        $jsonResponse = json_decode($response->getBody()->getContents());

        if (property_exists($jsonResponse, 'error_code')) {
            throw new SmsCenterException($jsonResponse->error_code);
        }

        return true;
    }
}
<?php

declare(strict_types=1);

namespace Yamilovs\Bundle\SmsBundle\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Yamilovs\Bundle\SmsBundle\Exception\MessageBirdException;
use Yamilovs\Bundle\SmsBundle\Sms\SmsInterface;

class MessageBirdProvider implements ProviderInterface
{
    private const SMS_SEND_URI = 'https://rest.messagebird.com/messages';

    /**
     * @var string
     */
    private $accessKey;

    /**
     * @var string
     */
    private $originator;

    /**
     * @var string
     */
    private $type;

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct()
    {
        $this->setClient(new Client());
    }

    public function setAccessKey(string $accessKey): self
    {
        $this->accessKey = $accessKey;

        return $this;
    }

    public function setOriginator(string $originator): self
    {
        $this->originator = $originator;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
                'Authorization' => sprintf('AccessKey %s', $this->accessKey)
            ],
            'form_params' => [
                'originator' => $this->originator,
                'body' => $sms->getMessage(),
                'recipients' => $sms->getPhoneNumber(),
                'type' => $this->type,
                'scheduledDatetime' => $sms->getDateTime()->format(\DateTime::RFC3339),
            ],
        ];
    }

    public function send(SmsInterface $sms): bool
    {
        try {
            $this->client->request('POST', self::SMS_SEND_URI, $this->getPostData($sms));
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error = current($response->errors);

            throw new MessageBirdException($error->code, $error->description, $error->parameter);
        }

        return true;
    }
}
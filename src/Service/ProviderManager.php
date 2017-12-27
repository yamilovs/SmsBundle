<?php

namespace Yamilovs\Bundle\SmsBundle\Service;

use Yamilovs\Bundle\SmsBundle\Provider\ProviderInterface;

class ProviderManager
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers;

    public function addProvider(string $providerName, ProviderInterface $provider): void
    {
        $this->providers[$providerName] = $provider;
    }

    public function getProvider(string $providerName): ProviderInterface
    {
        if (isset($this->providers[$providerName])) {
            throw new \OutOfBoundsException(sprintf('Could not find provider "%s"', $providerName));
        }

        return $this->providers[$providerName];
    }
}
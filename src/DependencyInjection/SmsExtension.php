<?php

namespace Yamilovs\Bundle\SmsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\ProviderFactoryInterface;

class SmsExtension extends Extension
{
    /**
     * @var ProviderFactoryInterface[]
     */
    private $providerFactoryMap = [];

    public function addProviderFactory(ProviderFactoryInterface $providerFactory)
    {
        $this->providerFactoryMap[$providerFactory->getName()] = $providerFactory;
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($this->providerFactoryMap);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);

        // load bundle's services
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // setting up configuration
        $this->loadProviders($config['providers'], $container);
    }

    private function loadProviders(array $config, ContainerBuilder $container)
    {
        foreach ($config as $providerName => $providerConfig) {
            $factoryName = key($providerConfig);
            $factory = $this->providerFactoryMap[$factoryName];

            $factory->create($container, $providerName, $providerConfig[$factoryName]);
        }
    }
}

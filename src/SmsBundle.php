<?php

namespace Yamilovs\Bundle\SmsBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Compiler\ProviderCompilerPass;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Factory\Provider\{
    SmsAeroProviderFactory, SmsCenterProviderFactory, SmsDiscountProviderFactory, SmsRuProviderFactory
};
use Yamilovs\Bundle\SmsBundle\DependencyInjection\SmsExtension;

class SmsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ProviderCompilerPass());
    }

    public function getContainerExtension()
    {
        $extension = new SmsExtension();
        $extension->addProviderFactory(new SmsRuProviderFactory());
        $extension->addProviderFactory(new SmsAeroProviderFactory());
        $extension->addProviderFactory(new SmsDiscountProviderFactory());
        $extension->addProviderFactory(new SmsCenterProviderFactory());

        return $extension;
    }
}

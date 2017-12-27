<?php

namespace Yamilovs\Bundle\SmsBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Yamilovs\Bundle\SmsBundle\DependencyInjection\Compiler\ProviderCompilerPass;

class SmsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ProviderCompilerPass());
    }
}

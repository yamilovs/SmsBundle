<?php

namespace Yamilovs\Bundle\SmsBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Yamilovs\Bundle\SmsBundle\Service\ProviderManager;
use Yamilovs\Bundle\SmsBundle\Sms\Sms;

class TestDeliveryCommand extends Command
{
    private $providerManager;

    public function __construct(ProviderManager $providerManager)
    {
        $this->providerManager = $providerManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('yamilovs:sms:delivery:test')
            ->setDescription('Instant delivery an sms message through the selected provider.')
            ->addArgument('provider-name', InputArgument::REQUIRED)
            ->addArgument('phone-number', InputArgument::REQUIRED)
            ->addArgument('message', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $providerName = $input->getArgument('provider-name');
        $phoneNumber = $input->getArgument('phone-number');
        $message = $input->getArgument('message');
        $provider = $this->providerManager->getProvider($providerName);

        if ($provider->send(new Sms($phoneNumber, $message))) {
            $io->success(sprintf("Message '%s' was successfully sent to '%s'", $message, $phoneNumber));
        }
    }
}
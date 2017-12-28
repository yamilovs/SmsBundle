<?php

namespace Yamilovs\Bundle\SmsBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yamilovs\Bundle\SmsBundle\Service\ProviderManager;

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
            ->setDescription('Sends an sms message through the selected provider.')
            ->addArgument('phone-number', InputArgument::REQUIRED)
            ->addArgument('message', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $phoneNumber = $input->getArgument('phone-number');
        $message = $input->getArgument('message');

        $output->writeln(sprintf('Phone number: <info>%s</info>. Message: <info>%s</info>', [$phoneNumber, $message]));
    }
}
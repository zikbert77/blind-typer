<?php

namespace App\Command;

use App\Entity\LiqpaySubscriptions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UnsubscribeCommand extends Command
{
    private $_em;

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        $this->_em = $em;
        parent::__construct($name);
    }

    protected static $defaultName = 'subscription:unsubscribe';

    protected function configure()
    {
        $this->setDescription('Unsubscribed users.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Planned expired subscriptions checker started...');
        $expiredSubscriptions = $this->_em->getRepository(LiqpaySubscriptions::class)->findExpired();
        $output->writeln([
            'Founded ' . count($expiredSubscriptions) . ' expired subscriptions',
            ''
        ]);
        $this->unsubscribing($output, $expiredSubscriptions);
    }

    private function unsubscribing(OutputInterface $output, array $expiredSubscriptions)
    {
        /** @var LiqpaySubscriptions $subscription */
        foreach ($expiredSubscriptions as $subscription) {
            $output->writeln([
                '',
                "Unsubscribing subscription #{$subscription->getId()}"
            ]);
            $result = $this->_em->getRepository(LiqpaySubscriptions::class)->unsubscribe([], $subscription);
            if (!$result['status']) {
                $output->writeln("!!!Subscription unsubscribing #{$subscription->getId()} has failed, error: {$result['error']}");
            } else {
                $output->writeln("Subscription #{$subscription->getId()} has been unsubscribed");
            }
        }
    }
}
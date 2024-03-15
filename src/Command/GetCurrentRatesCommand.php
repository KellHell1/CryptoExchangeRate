<?php

namespace App\Command;

use App\Entity\CurrencyPair;
use App\Service\RateHistoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:get-current-rates-command',
    description: 'Get current rates and save in DB',
)]
class GetCurrentRatesCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RateHistoryService $rateHistoryService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $pairs = $this->entityManager->getRepository(CurrencyPair::class)->findAll();

        foreach ($pairs as $pair) {
            // в идеале в очереди вынести, так как крона будет часто работать, а пар может быть много
            try {
                $rate = $this->rateHistoryService->getRateByApi($pair);

                $io->text('From ' . $pair->getCurrencyFrom()->getCode() . ' to ' . $pair->getCurrencyTo()->getCode());

                if (!empty($rate)) {
                    $rateHistory = $this->rateHistoryService->saveRateHistory($pair, $rate);
                    $io->text('Current rate is ===== ' . $rateHistory->getRate());
                } else {
                    $io->text('Got empty result from API ===> check the logs');
                }
            } catch (\Exception $exception) {
                // пишем в логи о ошибке
            }
        }

        $io->success('SUCCESS');

        return Command::SUCCESS;
    }
}

<?php

namespace App\Command;

use App\Entity\Alliance;
use App\Service\ApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportAllianceCommand extends Command
{
    protected static $defaultName = 'app:import:alliance';
    protected static $defaultDescription = 'Import Alliances';
    private $apiService;
    private $em;

    public function __construct(ApiService $apiService, EntityManagerInterface $em)
    {
        $this->apiService = $apiService;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $alliances = $this->apiService->getAlliances();

        foreach ($alliances as $key => $allianceId) {
            $alliance = $this->em->getRepository(Alliance::class)->findOneByAllianceId($allianceId);
            if ($alliance === null) {
                $alliance = new Alliance();
            }

            $allianceInfos = $this->apiService->getAllianceId($allianceId);
            $alliance->setAllianceId($allianceId);
            $alliance->setName($allianceInfos['name']);
            $alliance->setTicker($allianceInfos['ticker']);
            $this->em->persist($alliance);

            if ($key == 20) {
                break;
            }
        }

        $this->em->flush();

        $io = new SymfonyStyle($input, $output);
        $io->success('Alliance imported.');

        return Command::SUCCESS;
    }
}

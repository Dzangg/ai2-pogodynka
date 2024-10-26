<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'location:get-by-country-and-name',
    description: 'Add a short description for your command',
)]
class LocationGetByCountryAndNameCommand extends Command
{
    private LocationRepository $locationRepository;

    public function __construct(
        LocationRepository $locationRepository,
    )
    {
        $this->locationRepository = $locationRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('countryCode', InputArgument::REQUIRED, 'CountryCode for Localization')
            ->addArgument('name', InputArgument::REQUIRED, 'City name for Localization')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('countryCode');
        $name = $input->getArgument('name');
        $location = $this->locationRepository->findByCountryCodeAndName($countryCode, $name);

        $io->writeln(sprintf('Location: %s %s', $countryCode, $name));
        $io->writeln(sprintf("\tLatitude: %s",
            $location->getLatitude(),
        ));
        $io->writeln(sprintf("\tLongitude: %s",
            $location->getLongitude(),
        ));

        return Command::SUCCESS;
    }
}

<?php

namespace App\Command;

use App\Entity\City;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

class LoadCitiesCommand extends Command
{
    private const ID = "fias_id";
    private const REGION = "region";
    private const POSTAL_CODE = "postal_code";
    private const CITY = "city";
    private const LATITUDE = "geo_lat";
    private const LONGITUDE = "geo_lon";

    public function __construct(
        private EntityManagerInterface $entityManager,
        private CityRepository $cityRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName("cities:load");
        $this->setDescription("Загрузка списка городов из CSV");

        $this->addArgument("file", InputArgument::REQUIRED, "Путь к файлу CSV");
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument("file");

        if (!file_exists($file) || !is_file($file)) {
            throw new Exception("File not found");
        }

        $serializer = $this->makeSerializer();

        $data = $serializer->decode(file_get_contents($file), "csv");

        $progress = new ProgressBar($output, count($data));

        foreach ($data as $item) {
            $city = $this->cityRepository->find($item[self::ID]);

            if (empty($city)) {
                $city = new City();
                $city->id = $item[self::ID];
            }

            $city->name = !empty($item[self::CITY]) ? $item[self::CITY] : $item[self::REGION];
            $city->postalCode = $item[self::POSTAL_CODE];
            $city->latitude = $item[self::LATITUDE];
            $city->longitude = $item[self::LONGITUDE];

            $this->entityManager->persist($city);
            $progress->advance();
        }

        $this->entityManager->flush();
        $output->writeln("");


        return Command::SUCCESS;
    }

    private function makeSerializer(): Serializer
    {
        return new Serializer(encoders: [new CsvEncoder()]);
    }
}

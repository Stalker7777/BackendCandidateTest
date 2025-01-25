<?php

namespace App\Console;

use App\Helper\ImportXlsxFromFile;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Ads;
use App\Models\AdsAdset;
use avadim\FastExcelReader\Excel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Models\AdsCampaign;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ImportCsvAds extends Command
{
    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('import-csv-ads')
            ->setDescription('import-csv-ads command');
    }

    // TODO: Реализовать алгоритм для обработки файла ads.xlsx
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $logFilePath =  __DIR__ . "\\..\\..\\storage\\logs\\" . date("d-m-Y") . ".log";
        $xlsxFilePath = 'var\excel\ads.xlsx';

        $importXlsxFromFile = new ImportXlsxFromFile();
        $importXlsxFromFile->runImport($xlsxFilePath, $logFilePath);

        return 1;
    }
}
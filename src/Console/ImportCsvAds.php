<?php

namespace App\Console;

use App\Models\Ads;
use App\Models\AdsAdset;
use avadim\FastExcelReader\Excel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Models\AdsCampaign;

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
        $file = __DIR__ . '\..\..\var\excel\ads.xlsx';

        $excel = Excel::open($file);

        $sheet = $excel->sheet();

        $sheet->setReadArea('A2');

        foreach ($sheet->nextRow() as $rowNum => $rowData) {

            $companies_id = (int)$rowData['E'];
            $companies_name = $rowData['F'];

            if(AdsCampaign::existsRow($companies_id)) {
                AdsCampaign::updateRow($companies_id, [
                    'name' => $companies_name
                ]);
            }
            else {
                AdsCampaign::insertRow([
                    'id' => $companies_id,
                    'name' => $companies_name
                ]);
            }

            $groups_id = (int)$rowData['G'];
            $groups_name = $rowData['H'];

            if(AdsAdset::existsRow($groups_id)) {
                AdsAdset::updateRow($groups_id, [
                    'name' => $groups_name
                ]);
            }
            else {
                AdsAdset::insertRow([
                    'id' => $groups_id,
                    'name' => $groups_name
                ]);
            }

            $ads_id = (int)$rowData['C'];
            $ads_name = $rowData['D'];
            $date_consumption = $rowData['A'];
            $amount_consumption = $rowData['B'];
            $shows = $rowData['I'];
            $clicks = $rowData['J'];

            if(Ads::existsRow($ads_id)) {
                Ads::updateRow($ads_id, [
                    'name' => $ads_name,
                    'date_consumption' => $date_consumption,
                    'amount_consumption' => $amount_consumption,
                    'shows' => $shows,
                    'clicks' => $clicks
                ]);
            }
            else {
                Ads::insertRow([
                    'id' => $ads_id,
                    'name' => $ads_name,
                    'companies_id' => $companies_id,
                    'groups_id' => $groups_id,
                    'date_consumption' => $date_consumption,
                    'amount_consumption' => $amount_consumption,
                    'shows' => $shows,
                    'clicks' => $clicks
                ]);
            }


        }

        return 1;
    }
}
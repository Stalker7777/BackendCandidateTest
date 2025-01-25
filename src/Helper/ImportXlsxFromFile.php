<?php
namespace App\Helper;

use App\Models\Ads;
use App\Models\AdsAdset;
use App\Models\AdsCampaign;
use avadim\FastExcelReader\Excel;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ImportXlsxFromFile
{
    public function runImport(string $xlsxFilePath, string $logFilePath, bool $fileProcessingMode = false): void
    {
        $logger = new Logger("daily");
        $stream_handler = new StreamHandler($logFilePath);
        $logger->pushHandler($stream_handler);

        $rows_companies = [];
        $rows_groups = [];
        $rows_ads = [];

        $excel = Excel::open($xlsxFilePath);

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
                $row_insert_companies = [
                    'id' => $companies_id,
                    'name' => $companies_name
                ];

                if($fileProcessingMode) {
                    if(! $this->row_in_array($companies_id, $rows_companies)) {
                        $rows_companies[] = $row_insert_companies;
                    }
                }
                else {
                    AdsCampaign::insertRow($row_insert_companies);
                    $logger->info('Table companies INSERT single', $row_insert_companies);
                }
            }

            $groups_id = (int)$rowData['G'];
            $groups_name = $rowData['H'];

            if(AdsAdset::existsRow($groups_id)) {
                AdsAdset::updateRow($groups_id, [
                    'name' => $groups_name
                ]);
            }
            else {
                $row_insert_groups = [
                    'id' => $groups_id,
                    'name' => $groups_name
                ];

                if($fileProcessingMode) {
                    if(! $this->row_in_array($groups_id, $rows_groups)) {
                        $rows_groups[] = $row_insert_groups;
                    }
                }
                else {
                    AdsAdset::insertRow($row_insert_groups);
                    $logger->info('Table companies INSERT single', $row_insert_groups);
                }
            }

            $ads_id = (int)$rowData['C'];
            $ads_name = $rowData['D'];
            $date_consumption = $rowData['A'];
            $amount_consumption = $rowData['B'];
            $shows = $rowData['I'];
            $clicks = $rowData['J'];

            if(Ads::existsRow($ads_id, $date_consumption)) {
                Ads::updateRow($ads_id, $date_consumption, [
                    'name' => $ads_name,
                    'amount_consumption' => $amount_consumption,
                    'shows' => $shows,
                    'clicks' => $clicks
                ]);
            }
            else {
                $row_insert_ads = [
                    'id' => $ads_id,
                    'name' => $ads_name,
                    'companies_id' => $companies_id,
                    'groups_id' => $groups_id,
                    'date_consumption' => $date_consumption,
                    'amount_consumption' => $amount_consumption,
                    'shows' => $shows,
                    'clicks' => $clicks
                ];

                if($fileProcessingMode) {
                    $rows_ads[] = $row_insert_ads;
                }
                else {
                    Ads::insertRow($row_insert_ads);
                    $logger->info('Table ads INSERT single', $row_insert_ads);
                }
            }
        }

        if($fileProcessingMode) {
            if(count($rows_companies) > 0) {
                AdsCampaign::insertRow($rows_companies);
                foreach ($rows_companies as $row_log) {
                    $logger->info('Table companies INSERT multi', $row_log);
                }
            }

            if(count($rows_groups) > 0) {
                AdsAdset::insertRow($rows_groups);
                foreach ($rows_groups as $row_log) {
                    $logger->info('Table groups INSERT multi', $row_log);
                }
            }

            if(count($rows_ads) > 0) {
                Ads::insertRow($rows_ads);
                foreach ($rows_ads as $row_log) {
                    $logger->info('Table ads INSERT multi', $row_log);
                }
            }
        }

    }

    private function row_in_array(int $id, array $array): bool
    {
        foreach ($array as $row) {
            if($row['id'] == $id) {
                return true;
            }
        }

        return false;
    }

}
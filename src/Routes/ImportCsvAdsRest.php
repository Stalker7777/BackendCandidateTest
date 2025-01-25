<?php

namespace App\Routes;

use App\Helper\ImportXlsxFromFile;
use App\Models\AdsAdset;
use avadim\FastExcelReader\Excel;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use App\Controller\RestController;
use Psr\Http\Message\ResponseInterface;

class ImportCsvAdsRest extends RestController
{
    public function action(): ResponseInterface
    {
        $logFilePath =  __DIR__ . "/../../storage/logs/" . date('d-m-Y') . ".log";
        $xlsxFilePath = $_SERVER['DOCUMENT_ROOT'] . '/../var/excel/ads.xlsx';

        $importXlsxFromFile = new ImportXlsxFromFile();
        $importXlsxFromFile->runImport($xlsxFilePath, $logFilePath);

        return $this->response;
    }
}
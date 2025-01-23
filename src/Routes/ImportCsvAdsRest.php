<?php

namespace App\Routes;

use App\Controller\RestController;
use Psr\Http\Message\ResponseInterface;

class ImportCsvAdsRest extends RestController
{
    public function action(): ResponseInterface
    {
        return $this->response;
    }
}
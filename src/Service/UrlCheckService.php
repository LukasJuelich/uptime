<?php

namespace App\Service;

use App\Entity\UptimeResult;
use App\Service\UrlService;
use App\Service\UptimeResultService;
use GuzzleHttp\Client;
use PhpParser\Node\Expr\Cast\String_;

class UrlCheckService
{
    private $urlService;
    private $uptimeResultService;

    public function __construct(UrlService $urlService, UptimeResultService $uptimeResultService)
    {
        $this->urlService = $urlService;
        $this->uptimeResultService = $uptimeResultService;
    }

    public function checkUrl($urlString): UptimeResult
    {
        $client = new Client();

        $url = $this->urlService->retrieveUrlbyUrlString($urlString);
        if(empty($url))
        {
            return false;
        }
        $result = $client
                    ->request('GET', $urlString)
                    ->getStatusCode()
                ;

        return $this->uptimeResultService->createUptimeResult($result, $url);
    }

    public function getAllUptimeResults($urlString)
    {
        $url = $this->urlService->retrieveUrlbyUrlString($urlString);
        return $this->uptimeResultService->retrieveAllUptimeResults($url);
    }
}
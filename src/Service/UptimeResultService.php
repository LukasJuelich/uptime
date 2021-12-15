<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UptimeResult;
use App\Entity\URL;

class UptimeResultService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createUptimeResult($result, $url): UptimeResult
    {
        $currentTime = new \DateTime('now');
        $currentTime->format('Y-m-d H:i:s');

        $upTimeResult = new UptimeResult();
        $upTimeResult->setStatusCode($result);
        $upTimeResult->setDate($currentTime);
        $upTimeResult->setUrl($url);

        $this->entityManager->persist($upTimeResult);
        $this->entityManager->flush();

        return $upTimeResult;
    }

    public function retrieveUptimeResultByUrl($url): UptimeResult
    {
        return $this->entityManager
            ->getRepository(UptimeResult::class)
            ->findOneBy(['url' => $url]);
    }

    public function retrieveAllUptimeResults($url)
    {
        return $this->entityManager
            ->getRepository(UptimeResult::class)
            ->findBy(['url' => $url]);
    }
}
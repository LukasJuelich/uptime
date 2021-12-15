<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\URL;


class UrlService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createUrl(string $urlString): URL
    {
        //TODO: validate url

        $url = new URL();
        $url->setUrlString($urlString);

        $this->entityManager->persist($url);
        $this->entityManager->flush();
        return $url;
    }

    public function retrieveUrlbyId(int $id): URL
    {
        $url = $this->entityManager
                ->getRepository(URL::class)
                ->findOneBy(['id' => $id]);

        return $url;
    }

    public function retrieveUrlbyUrlString($urlString): URL
    {
        $url = $this->entityManager
                ->getRepository(URL::class)
                ->findOneBy(['urlString' => $urlString]);

        return $url;
    }

    public function deleteUrlbyId($id): bool
    {
        $url = $this->retrieveUrlbyId($id);
        
        if(empty($url))
        {
            return false;
        }

        $this->entityManager->remove($url);
        $this->entityManager->flush();
        return true;
    }
}
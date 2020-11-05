<?php

namespace App\Manager;

use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;

class RequestManager
{
    /**
     * @var RequestRepository
     */
    public $requestRepository;

    /**
     * @var EntityManagerInterface
     */
    public $entityManager;


    /**
     * Construct Request Manager
     *
     * @param RequestRepository $requestRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(RequestRepository $requestRepository, EntityManagerInterface $entityManager)
    {
        $this->requestRepository = $requestRepository;
        $this->entityManager = $entityManager;
    }


    public function removeAll()
    {
        $entities = $this->requestRepository->findBy(["deletedAt" => null]);

        foreach ($entities as $entity) {
            $this->entityManager->remove($entity);
        }

        $this->entityManager->flush();

    }
}

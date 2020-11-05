<?php

namespace App\Manager;

use App\Entity\PreconfigureResponse;
use App\Entity\Request as SimulatorRequest;
use App\Repository\PreconfigureResponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouterManager
{
    /**
     * @var PreconfigureResponseRepository
     */
    public $preconfigureResponseRepository;

    /**
     * @var EntityManagerInterface
     */
    public $entityManager;


    /**
     * Construct Router Manager
     *
     * @param PreconfigureResponseRepository $preconfigureResponseRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(PreconfigureResponseRepository $preconfigureResponseRepository, EntityManagerInterface $entityManager)
    {
        $this->preconfigureResponseRepository = $preconfigureResponseRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * @param Request $request
     *
     * @return Response
     */
    public function trackRoute(Request $request)
    {
        $responseFound = null;

        $responses = $this->preconfigureResponseRepository->findBy(['deletedAt' => null], ['priority' => "DESC"]);

        foreach($responses as $response) {
            preg_match($response->getRegex(), $request->getRequestUri(), $matches);
            if (!empty($matches) && strtolower($request->getMethod()) === $response->getHttpVerb()) {
                $responseFound = $response;
                break;
            }
        }

        $this->saveRequestWithResponse($request, $responseFound);

        return $this->generateResponse($responseFound);

    }

    /**
     * @param Request $request
     * @param PreconfigureResponse|null $preconfigureResponse
     *
     */
    public function saveRequestWithResponse(Request $request, ?PreconfigureResponse $preconfigureResponse)
    {
        $now = new \DateTime("now");

        $newRequest = new SimulatorRequest();

        $newRequest->setHttpVerb($request->getMethod());
        $newRequest->setHeaderRequest(json_encode($request->headers->all()));
        $newRequest->setBodyRequest($request->getContent());
        $newRequest->setUrl($request->getRequestUri());
        $newRequest->setCallAt($now);

        if ($preconfigureResponse) {
            $newRequest->setRegex($preconfigureResponse->getRegex());
            $newRequest->setHeaderResponse($preconfigureResponse->getHeaders());
            $newRequest->setBodyResponse($preconfigureResponse->getBody());
        }

        $this->entityManager->persist($newRequest);
        $this->entityManager->flush();

    }

    /**
     * @param PreconfigureResponse|null $preconfigureResponse
     *
     * @return Response
     */
    private function generateResponse(?PreconfigureResponse $preconfigureResponse)
    {
        $response = new Response();

        if (!$preconfigureResponse) {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            return $response;
        }

        $response->setStatusCode($preconfigureResponse->getCode());
        $response->headers->add(json_decode($preconfigureResponse->getHeaders(), true));
        $response->setContent($preconfigureResponse->getBody());

        return $response;
    }

}

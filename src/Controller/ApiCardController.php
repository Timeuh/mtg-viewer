<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/card', name: 'api_card_')]
#[OA\Tag(name: 'Card', description: 'Routes for all about cards')]
class ApiCardController extends AbstractController {
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger
    ) {
    }

    #[Route('/all', name: 'List all cards', methods: ['GET'])]
    #[OA\Put(description: 'Return all cards in the database')]
    #[OA\Response(response: 200, description: 'List all cards')]
    public function cardAll(): Response {
        $cards = $this->entityManager->getRepository(Card::class)->findAll();
        $this->logger->info('Get all cards');
        return $this->json($cards);
    }


    #[Route('/name/{name}', name: 'List cards by name', methods: ['GET'])]
    #[OA\Parameter(name: 'name', description: 'Name of the card', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Put(description: 'Return all cards by name')]
    #[OA\Response(response: 200, description: 'List all cards by name')]
    #[OA\Response(response: 404, description: 'Card not found')]
    public function cardsByName(string $name): Response {
        $repository = $this->entityManager->getRepository(Card::class);
        $queryBuilder = $repository->createQueryBuilder('c');

        $query = $queryBuilder
            ->where($queryBuilder->expr()->like('c.name', ':name'))
            ->setParameter('name',  $name . '%')
            ->getQuery();

        $cards = $query->getResult();

        return $this->json($cards);
    }

    #[Route('/{uuid}', name: 'Show card', methods: ['GET'])]
    #[OA\Parameter(name: 'uuid', description: 'UUID of the card', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Put(description: 'Get a card by UUID')]
    #[OA\Response(response: 200, description: 'Show card')]
    #[OA\Response(response: 404, description: 'Card not found')]
    public function cardShow(string $uuid): Response {
        $card = $this->entityManager->getRepository(Card::class)->findOneBy(['uuid' => $uuid]);
        if (!$card) {
            $this->logger->error('Card ' . $uuid . ' not found');
            return $this->json(['error' => 'Card not found'], 404);
        }
        $this->logger->info('Get card ' . $uuid);
        return $this->json($card);
    }

}

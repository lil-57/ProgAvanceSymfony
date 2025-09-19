<?php

namespace App\Controller;

use App\Entity\Pain;
use App\Repository\PainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PainController extends AbstractController
{
    #[Route('/pains', name: 'pain_index')]
    public function index(PainRepository $painRepository): Response
    {
        $pains = $painRepository->findAll();
        return $this->render('pain/index.html.twig', [
            'pains' => $pains,
        ]);
    }

    #[Route('/pain/create', name: 'pain_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $pain = new Pain();
        $pain->setName('Pain de mie');

        // Persister et sauvegarder le pain
        $entityManager->persist($pain);
        $entityManager->flush();

        return new Response('Pain créé avec succès !');
    }

    #[Route('/pain/list', name: 'pain_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $pains = $entityManager->getRepository(Pain::class)->findAll();

        $output = '';
        foreach ($pains as $pain) {
            $output .= $pain->getName() . '<br>';
        }

        return new Response($output);
    }
}

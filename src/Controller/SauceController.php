<?php

namespace App\Controller;

use App\Entity\Sauce;
use App\Repository\SauceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SauceController extends AbstractController
{
    #[Route('/sauces', name: 'sauce_index')]
    public function index(SauceRepository $sauceRepository): Response
    {
        $sauces = $sauceRepository->findAll();
        return $this->render('sauce/index.html.twig', [
            'sauces' => $sauces,
        ]);
    }

    #[Route('/sauce/create', name: 'sauce_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $sauce = new Sauce();
        $sauce->setName('Sauce César');

        // Persister et sauvegarder la sauce
        $entityManager->persist($sauce);
        $entityManager->flush();

        return new Response('Sauce créée avec succès !');
    }

    #[Route('/sauce/list', name: 'sauce_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $sauces = $entityManager->getRepository(Sauce::class)->findAll();

        $output = '';
        foreach ($sauces as $sauce) {
            $output .= $sauce->getName() . '<br>';
        }

        return new Response($output);
    }
}
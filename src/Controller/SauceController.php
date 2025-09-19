<?php

namespace App\Controller;

use App\Entity\Sauce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SauceController extends AbstractController
{
    #[Route('/sauce/create', name: 'sauce_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $sauce = new Sauce();
        $sauce->setName('Mayonnaise');

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
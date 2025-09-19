<?php

namespace App\Controller;

use App\Entity\Oignon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OignonController extends AbstractController
{
    #[Route('/oignon/create', name: 'oignon_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $oignon = new Oignon();
        $oignon->setName('Oignon rouge');

        $entityManager->persist($oignon);
        $entityManager->flush();

        return new Response('Oignon créé avec succès !');
    }

    #[Route('/oignon/list', name: 'oignon_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $oignons = $entityManager->getRepository(Oignon::class)->findAll();

        $output = '';
        foreach ($oignons as $oignon) {
            $output .= $oignon->getName() . '<br>';
        }

        return new Response($output);
    }
}

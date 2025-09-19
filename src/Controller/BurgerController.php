<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Entity\Pain;
use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BurgerController extends AbstractController
{
    #[Route('/burger/create', name: 'burger_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
    
        $burger = new Burger();
        $burger->setName('Burger Classic');
        $burger->setPrice('12.99');
        

        $pain = $entityManager->getRepository(Pain::class)->findOneBy([]) ?? new Pain();
        if (!$pain->getId()) {
            $pain->setName('Pain brioché');
            $entityManager->persist($pain);
        }
        $burger->setPain($pain);

        $entityManager->persist($burger);
        $entityManager->flush();

        return new Response('Burger créé avec succès !');
    }

    #[Route('/burger/list', name: 'burger_list_simple')]
    public function listSimple(EntityManagerInterface $entityManager): Response
    {
        $burgers = $entityManager->getRepository(Burger::class)->findAll();

        $output = '';
        foreach ($burgers as $burger) {
            $output .= $burger->getName() . ' - ' . $burger->getPrice() . '€<br>';
        }

        return new Response($output);
    }

    #[Route('/burgers', name: 'burger_list')]
    public function list(): Response
    {
        return $this->render('burgers_list.html.twig');
    }

    #[Route('/burgers/{id}', name: 'burger_show')]
    public function show(int $id): Response
    {
        $burgers = [
            1 => ['nom' => 'Cheese Burger', 'description' => 'Un burger avec double cheddar fondant'],
            2 => ['nom' => 'Bacon Burger', 'description' => 'Un burger garni de bacon croustillant'],
            3 => ['nom' => 'Vegan Burger', 'description' => 'Un burger 100% végétal et délicieux'],
        ];

        $burger = $burgers[$id] ?? null;

        return $this->render('burger_show.html.twig', [
            'id' => $id,
            'burger' => $burger
        ]);
    }
}

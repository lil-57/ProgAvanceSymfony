<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BurgerController extends AbstractController
{
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

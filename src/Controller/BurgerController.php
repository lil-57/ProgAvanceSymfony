<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Entity\Pain;
use App\Entity\Image;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BurgerController extends AbstractController
{
    #[Route('/burgers', name: 'burger_index')]
    public function index(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findAll();
        
        return $this->render('burger/index.html.twig', [
            'burgers' => $burgers,
        ]);
    }

#[Route('/burger/create', name: 'burger_create')]
public function create(EntityManagerInterface $entityManager): Response
{
    $burger = new Burger();
    $burger->setName('Krabby Patty');
    $burger->setPrice(4.99);

    $entityManager->persist($burger);
    $entityManager->flush();

    $this->addFlash('success', 'Burger créé avec succès !');

    return $this->redirectToRoute('burger_list');
}


#[Route('/burgers', name: 'burger_list')]
public function list(EntityManagerInterface $entityManager): Response
{
    $burgers = $entityManager->getRepository(Burger::class)->findAll();

    return $this->render('burger/list.html.twig', [
        'burgers' => $burgers,
    ]);
}

#[Route('/burgers/{id}', name: 'burger_show')]
public function show(EntityManagerInterface $entityManager, int $id): Response
{
    $burger = $entityManager->getRepository(Burger::class)->find($id);

    if (!$burger) {
        throw $this->createNotFoundException("Burger $id non trouvé !");
    }

    return $this->render('burger/show.html.twig', [
        'burger' => $burger,
    ]);
}

}

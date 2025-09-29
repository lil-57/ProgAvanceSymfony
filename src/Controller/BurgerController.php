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

#[Route('/burgers/top/{limit}', name: 'burger_top', requirements: ['limit' => '\d+'])]
public function topBurgers(int $limit, BurgerRepository $burgerRepository): Response
{
    $topBurgers = $burgerRepository->findTopXBurgers($limit);

    return $this->render('burger/top.html.twig', [
        'topBurgers' => $topBurgers,
        'limit' => $limit,
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


#[Route('/ingredient/{name}', name: 'burger_by_ingredient')]
public function findByIngredient(BurgerRepository $burgerRepository, string $name): Response
{
    $burgers = $burgerRepository->findBurgersWithIngredient($name);

    return $this->render('burger/by_ingredient.html.twig', [
        'burgers' => $burgers,
        'ingredient' => $name,
    ]);
}

#[Route('/burgers/without/{type}/{name}', name: 'burger_without_ingredient', requirements: ['type' => 'pain|oignon|sauce'])]
public function findWithoutIngredient(
    string $type, 
    string $name, 
    BurgerRepository $burgerRepository, 
    EntityManagerInterface $entityManager
): Response {
    // Déterminer la classe d'entité selon le type
    $entityClass = match($type) {
        'pain' => 'App\Entity\Pain',
        'oignon' => 'App\Entity\Oignon', 
        'sauce' => 'App\Entity\Sauce',
        default => throw new \InvalidArgumentException('Type d\'ingrédient invalide')
    };
    
    // Rechercher l'ingrédient par son nom
    $ingredient = $entityManager->getRepository($entityClass)->findOneBy(['name' => $name]);
    
    if (!$ingredient) {
        throw $this->createNotFoundException(sprintf('Aucun %s nommé "%s" trouvé', $type, $name));
    }
    
    // Trouver les burgers sans cet ingrédient
    $burgers = $burgerRepository->findBurgersWithoutIngredient($ingredient);
    
    return $this->render('burger/without_ingredient.html.twig', [
        'burgers' => $burgers,
        'ingredient' => $ingredient,
        'type' => $type,
    ]);
}

#[Route('/burgers/minimum/{minIngredients}', name: 'burger_minimum_ingredients', requirements: ['minIngredients' => '\d+'])]
public function findWithMinimumIngredients(int $minIngredients, BurgerRepository $burgerRepository): Response
{
    $burgers = $burgerRepository->findBurgersWithMinimumIngredients($minIngredients);
    
    return $this->render('burger/minimum_ingredients.html.twig', [
        'burgers' => $burgers,
        'minIngredients' => $minIngredients,
    ]);
}

}

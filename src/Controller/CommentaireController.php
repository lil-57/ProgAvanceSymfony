<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaires', name: 'commentaire_index')]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        $commentaires = $commentaireRepository->findAll();
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/commentaire/create', name: 'commentaire_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setName('Excellent burger, je recommande !');

        // Persister et sauvegarder le commentaire
        $entityManager->persist($commentaire);
        $entityManager->flush();

        return new Response('Commentaire créé avec succès !');
    }

    #[Route('/commentaire/list', name: 'commentaire_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager->getRepository(Commentaire::class)->findAll();

        $output = '';
        foreach ($commentaires as $commentaire) {
            $output .= $commentaire->getName() . '<br>';
        }

        return new Response($output);
    }
}

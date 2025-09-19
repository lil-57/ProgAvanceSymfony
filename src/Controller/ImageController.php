<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/images', name: 'image_index')]
    public function index(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();
        return $this->render('image/index.html.twig', [
            'images' => $images,
        ]);
    }

    #[Route('/image/create', name: 'image_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $image->setName('burger-deluxe.jpg');

        // Persister et sauvegarder l'image
        $entityManager->persist($image);
        $entityManager->flush();

        return new Response('Image créée avec succès !');
    }

    #[Route('/image/list', name: 'image_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $images = $entityManager->getRepository(Image::class)->findAll();

        $output = '';
        foreach ($images as $image) {
            $output .= $image->getName() . '<br>';
        }

        return new Response($output);
    }
}

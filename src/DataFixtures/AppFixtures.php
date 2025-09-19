<?php

namespace App\DataFixtures;

use App\Entity\Burger;
use App\Entity\Pain;
use App\Entity\Oignon;
use App\Entity\Sauce;
use App\Entity\Image;
use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $pains = [];
        foreach (['Pain brioché', 'Pain complet', 'Pain sésame'] as $nomPain) {
            $pain = new Pain();
            $pain->setName($nomPain);
            $manager->persist($pain);
            $pains[] = $pain;
        }

    
        $oignons = [];
        foreach (['Oignon rouge', 'Oignon frit', 'Oignon caramélisé'] as $nomOignon) {
            $oignon = new Oignon();
            $oignon->setName($nomOignon);
            $manager->persist($oignon);
            $oignons[] = $oignon;
        }

  
        $sauces = [];
        foreach (['Ketchup', 'Mayonnaise', 'Barbecue', 'Biggy', 'Andalouse'] as $nomSauce) {
            $sauce = new Sauce();
            $sauce->setName($nomSauce);
            $manager->persist($sauce);
            $sauces[] = $sauce;
        }

      
        $images = [];
        foreach (['burger1.jpg', 'burger2.jpg', 'burger3.jpg'] as $file) {
            $image = new Image();
            $image->setName($file);
            $manager->persist($image);
            $images[] = $image;
        }

        for ($i = 1; $i <= 3; $i++) {
            $burger = new Burger();
            $burger->setName("Burger $i");
            $burger->setPrice(mt_rand(8, 15) + 0.99); // Prix aléatoire
            $burger->setPain($pains[array_rand($pains)]);
            $burger->setImage($images[$i - 1]);

           
            $burger->addOignon($oignons[array_rand($oignons)]);

            
            $burger->addSauce($sauces[array_rand($sauces)]);
            $burger->addSauce($sauces[array_rand($sauces)]);

            $manager->persist($burger);

        
            for ($j = 1; $j <= 2; $j++) {
                $commentaire = new Commentaire();
                $commentaire->setName("Commentaire $j du Burger $i");
                $commentaire->setBurger($burger);
                $manager->persist($commentaire);
            }
        }

        $manager->flush();
    }
}

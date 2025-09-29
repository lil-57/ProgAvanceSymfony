<?php

namespace App\Repository;

use App\Entity\Burger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Burger>
 */
class BurgerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Burger::class);
    }

    /**
     * Trouve les burgers qui contiennent un ingrédient spécifique
     * Recherche dans les pains, oignons et sauces
     *
     * @param string $ingredientName
     * @return Burger[]
     */
    public function findBurgersWithIngredient(string $ingredientName): array
    {
        $qb = $this->createQueryBuilder('b');
        
        return $qb
            ->leftJoin('b.pain', 'p')
            ->leftJoin('b.oignons', 'o')
            ->leftJoin('b.sauces', 's')
            ->where(
                $qb->expr()->orX(
                    'LOWER(p.name) LIKE LOWER(:ingredient)',
                    'LOWER(o.name) LIKE LOWER(:ingredient)',
                    'LOWER(s.name) LIKE LOWER(:ingredient)'
                )
            )
            ->setParameter('ingredient', '%' . $ingredientName . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les X burgers les plus chers
     * Utilise DQL pour trier par prix descendant
     *
     * @param int $limit
     * @return Burger[]
     */
    public function findTopXBurgers(int $limit): array
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.price', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les burgers qui ne contiennent pas un ingrédient donné
     * Détecte automatiquement le type d'ingrédient (Pain, Oignon, Sauce) 
     * et fait la jointure appropriée
     *
     * @param object $ingredient
     * @return Burger[]
     */
    public function findBurgersWithoutIngredient(object $ingredient): array
    {
        $qb = $this->createQueryBuilder('b');
        
        // Déterminer le type d'ingrédient et construire la requête appropriée
        $className = get_class($ingredient);
        
        switch ($className) {
            case 'App\Entity\Pain':
                // Pour les pains (relation ManyToOne)
                $qb->where('b.pain != :ingredient OR b.pain IS NULL')
                   ->setParameter('ingredient', $ingredient);
                break;
                
            case 'App\Entity\Oignon':
                // Pour les oignons (relation ManyToMany) - exclure les burgers qui contiennent cet oignon
                $qb->where('b.id NOT IN (
                        SELECT DISTINCT b2.id FROM App\Entity\Burger b2 
                        JOIN b2.oignons o2 
                        WHERE o2.id = :ingredientId
                    )')
                   ->setParameter('ingredientId', $ingredient->getId());
                break;
                
            case 'App\Entity\Sauce':
                // Pour les sauces (relation ManyToMany) - exclure les burgers qui contiennent cette sauce
                $qb->where('b.id NOT IN (
                        SELECT DISTINCT b3.id FROM App\Entity\Burger b3 
                        JOIN b3.sauces s3 
                        WHERE s3.id = :ingredientId
                    )')
                   ->setParameter('ingredientId', $ingredient->getId());
                break;
                
            default:
                throw new \InvalidArgumentException('Type d\'ingrédient non supporté: ' . $className);
        }
        
        return $qb->getQuery()->getResult();
    }

    /**
     * Trouve les burgers ayant au moins un nombre minimum d'ingrédients
     * Compte le pain (s'il existe) + le nombre d'oignons + le nombre de sauces
     *
     * @param int $minIngredients
     * @return Burger[]
     */
    public function findBurgersWithMinimumIngredients(int $minIngredients): array
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->leftJoin('b.oignons', 'o')
            ->leftJoin('b.sauces', 's')
            ->groupBy('b.id')
            ->having('
                (CASE WHEN b.pain IS NOT NULL THEN 1 ELSE 0 END) + 
                COUNT(DISTINCT o.id) + 
                COUNT(DISTINCT s.id) >= :minIngredients
            ')
            ->setParameter('minIngredients', $minIngredients)
            ->orderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

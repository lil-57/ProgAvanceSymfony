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
}

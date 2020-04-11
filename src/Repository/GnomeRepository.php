<?php

namespace App\Repository;

use App\Entity\Gnome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gnome|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gnome|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gnome[]    findAll()
 * @method Gnome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GnomeRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gnome::class);
    }
}

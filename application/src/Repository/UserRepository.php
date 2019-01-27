<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAllBesidesAdminAndSelf($id): array
    {
        // автоматически знает, что надо выбрать Товары
        // "p" - это дополнительное имя, которое вы будете использовать далее в запросе
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.id != :price')
            ->setParameter('price', $id)
            ->getQuery();

        return $qb->execute();

        // чтобы получить только один результат:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }
}

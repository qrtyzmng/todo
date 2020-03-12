<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * 
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }
    
    public function countElements()
    {
        $qb = $this->getEntityManager()->createQueryBuilder('t');
        $qb->select('count(t.id)');
        $qb->from('App:Task', 't');
        return $qb->getQuery()->getSingleScalarResult();
    }
    
    public function fetchAll(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        
        $qb = $this->getEntityManager()->createQueryBuilder('t');
        $qb->select('t');
        $qb->from('App:Task', 't');
        $qb->setMaxResults($perPage);
        $qb->setFirstResult($offset);
        $qb->orderBy('t.id', 'DESC');
        return $qb->getQuery()->getResult();
    }
}

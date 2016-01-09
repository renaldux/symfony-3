<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findLatest($limit = Post::NUM_ITEMS)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('p')
            ->from('AppBundle:Post', 'p');
        return $qb->getQuery()->setMaxResults($limit)->getArrayResult();
    }
}
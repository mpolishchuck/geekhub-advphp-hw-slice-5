<?php

namespace PaulMaxwell\GuestbookBundle\Entity;

use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    public function findSliceAfterId($id, $limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->where('m.id < :id')
            ->setParameter('id', $id)
            ->orderBy('m.postedAt', 'DESC')
            ->addOrderBy('m.id', 'DESC');
        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function findSliceBeforeId($id, $limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->where('m.id > :id')
            ->setParameter('id', $id)
            ->orderBy('m.postedAt', 'ASC')
            ->addOrderBy('m.id', 'ASC');
        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function findFirstSlice($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->orderBy('m.postedAt', 'DESC')
            ->addOrderBy('m.id', 'DESC');
        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function hasMessagesBefore($id)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->where('m.id > :id')
            ->setParameter('id', $id)
            ->orderBy('m.postedAt', 'ASC')
            ->addOrderBy('m.id', 'ASC')
            ->setMaxResults(1);
        return (count($queryBuilder->getQuery()->getResult()) > 0);
    }

    public function hasMessagesAfter($id)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->where('m.id < :id')
            ->setParameter('id', $id)
            ->orderBy('m.postedAt', 'ASC')
            ->addOrderBy('m.id', 'ASC')
            ->setMaxResults(1);
        return (count($queryBuilder->getQuery()->getResult()) > 0);
    }
}

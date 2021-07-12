<?php

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use KimaiPlugin\KimaiQuickbooksBundle\Entity\QBCustomerMapping;

class QBCustomerMappingRepository extends EntityRepository
{
    /**
     * @return QBCustomerMapping[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('kqb')
            ->getQuery()
            ->execute();
    }

    /**
     * @param QBCustomerMapping $mapping
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(QBCustomerMapping $mapping)
    {
        $em = $this->getEntityManager();
        $em->persist($mapping);
        $em->flush();
    }

    /**
     * @param QBCustomerMapping $mapping
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(QBCustomerMapping $mapping)
    {
        $em = $this->getEntityManager();
        $em->remove($mapping);
        $em->flush();
    }
}

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
use KimaiPlugin\KimaiQuickbooksBundle\Entity\QBConnection;

class QBConnectionRepository extends EntityRepository
{
    /**
     * @return QBConnection[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder()
            ->getQuery()
            ->execute();
    }

    /**
     * @param QBConnection $connection
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(QBConnection $connection)
    {
        $em = $this->getEntityManager();
        $em->persist($connection);
        $em->flush();
    }

    /**
     * @param QBConnection $connection
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(QBConnection $connection)
    {
        $em = $this->getEntityManager();
        $em->remove($connection);
        $em->flush();
    }

    /**
     * @param string|null $companyId
     * @return QBConnection|null
     */
    public function hasCompany(string $companyId)
    {
        try {
            $qb = $this->createQueryBuilder('kqb')
                ->select('count(kqb.id) as counter')
                ->andWhere('kqb.companyId = :companyId')
                ->setParameter('companyId', $companyId);

            $counter = (int) $qb->getQuery()->getSingleScalarResult();

            return $counter > 0;
        } catch (NonUniqueResultException $e) {
            // We can ignore that as we have a unique database key for company_id
            return null;
        }
    }
}

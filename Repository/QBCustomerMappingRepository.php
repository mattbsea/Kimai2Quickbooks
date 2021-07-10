<?php

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\Repository;

use App\Entity\Project;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use KimaiPlugin\KimaiQuickbooksBundle\Entity\QBCustomerMapping;

class QBCustomerMappingRepository extends EntityRepository
{
    /**
     * @return QBCustomerMapping[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('spt')
            ->join(Project::class, 'p', Join::WITH, 'spt.project = p')
            ->orderBy('p.name, spt.shareKey', 'ASC')
            ->getQuery()
            ->execute();
    }

    /**
     * @param QBCustomerMapping $sharedProject
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(QBCustomerMapping $sharedProject)
    {
        $em = $this->getEntityManager();
        $em->persist($sharedProject);
        $em->flush();
    }

    /**
     * @param QBCustomerMapping $sharedProject
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(QBCustomerMapping $sharedProject)
    {
        $em = $this->getEntityManager();
        $em->remove($sharedProject);
        $em->flush();
    }

    /**
     * @param Project|int|null $project
     * @param string|null $shareKey
     * @return QBCustomerMapping|null
     */
    public function findByProjectAndShareKey($project, ?string $shareKey)
    {
        try {
            return $this->createQueryBuilder('spt')
                ->where('spt.project = :project')
                ->andWhere('spt.shareKey = :shareKey')
                ->setMaxResults(1)
                ->setParameter('project', $project)
                ->setParameter('shareKey', $shareKey)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            // We can ignore that as we have a unique database key for project and shareKey
            return null;
        }
    }
}

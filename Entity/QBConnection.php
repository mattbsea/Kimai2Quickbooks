<?php

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\Entity;

use App\Entity\Customer;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="kimai2_quickbooks_connections",
 *      indexes={
 *          @ORM\Index(columns={"qb_id", "customer_id"}),
 *          @ORM\Index(columns={"display_name"}),
 *      }
 * )
 * @ORM\Entity(repositoryClass="KimaiPlugin\KimaiQuickbooksBundle\Repository\QBConnectionRepository")
 */
class QBConnection
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="company_id", type="string", nullable=false)
     * @Assert\NotNull()
     */
    protected $companyId;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", nullable=false)
     * @Assert\NotNull()
     */
    protected $accessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", nullable=false)
     * @Assert\NotNull()
     */
    protected $companyName;

    /**
     * @return Customer
     */
    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    /**
     * @param string $companyId
     * @return QBConnection
     */
    public function setCompanyId(string $companyId): QBConnection
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     * @return QBConnection
     */
    public function setAccessToken(string $accessToken): QBConnection
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return QBConnection
     */
    public function setCompanyName(string $companyName): QBConnection
    {
        $this->companyName = $companyName;

        return $this;
    }
}

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
 * @ORM\Table(name="kimai2_quickbooks_customer_mappings",
 *      indexes={
 *          @ORM\Index(columns={"qb_id", "customer_id"}),
 *          @ORM\Index(columns={"display_name"}),
 *      }
 * )
 * @ORM\Entity(repositoryClass="KimaiPlugin\KimaiQuickbooksBundle\Repository\QBCustomerMappingRepository")
 */
class QBCustomerMapping
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
     * @var int
     *
     * @ORM\Column(name="qb_id", type="integer", nullable=false)
     * @Assert\NotNull()
     */
    protected $qb_id;

    /**
     * @var Customer
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Customer")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Assert\NotNull()
     */
    protected $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=255, nullable=false)
     * @Assert\Length(max=255)
     * @Assert\NotNull()
     */
    protected $displayName;

    /**
     * @return Customer
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return QBCustomerMapping
     */
    public function setCustomer(Customer $customer): QBCustomerMapping
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return int
     */
    public function getQBID(): ?int
    {
        return $this->qb_id;
    }

    /**
     * @param int $qb_id
     * @return QBCustomerMapping
     */
    public function setQBID(int $qb_id): QBCustomerMapping
    {
        $this->qb_id = $qb_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return QBCustomerMapping
     */
    // public function setDisplayName(string $displayName): QBCustomerMapping
    // {
    //     $this->displayName = $displayName;

    //     return $this;
    // }
}

<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\Configuration;

use App\Configuration\SystemConfiguration;

final class KimaiQuickbooksConfiguration
{
    /**
     * @var SystemConfiguration
     */
    private $configuration;

    public function __construct(SystemConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getQBClientKey(): string
    {
        return (string) $this->configuration->find('k2qb.client_key');
    }
}

<?php

/*
 * This file is part of the Kimai2Quickbooks for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\EventSubscriber;

use App\Event\SystemConfigurationEvent;
use App\Form\Model\Configuration;
use App\Form\Model\SystemConfiguration as SystemConfigurationModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SystemConfigurationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            SystemConfigurationEvent::class => ['onSystemConfiguration', 100],
        ];
    }

    public function onSystemConfiguration(SystemConfigurationEvent $event)
    {
        $event->addConfiguration(
            (new SystemConfigurationModel())
            ->setSection('k2qb_config')
            ->setConfiguration([
                (new Configuration())
                    ->setName('k2qb.client_key')
                    ->setLabel('k2qb.client_key')
                    ->setTranslationDomain('system-configuration')
                    ->setRequired(false)
                    ->setType(TextType::class),
            ])
        );
    }
}

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
            ->setSection('kimai_quickbooks_config')
            ->setConfiguration([
                (new Configuration())
                    ->setName('kimai_quickbooks.setting_client_id')
                    ->setLabel('kimai_quickbooks.setting_client_id')
                    ->setTranslationDomain('system-configuration')
                    ->setRequired(false)
                    ->setType(TextType::class),
                (new Configuration())
                    ->setName('kimai_quickbooks.setting_client_secret')
                    ->setLabel('kimai_quickbooks.setting_client_secret')
                    ->setTranslationDomain('system-configuration')
                    ->setRequired(false)
                    ->setType(TextType::class),
                (new Configuration())
                    ->setName('kimai_quickbooks.setting_oauth_redirect_uri')
                    ->setLabel('kimai_quickbooks.setting_oauth_redirect_uri')
                    ->setTranslationDomain('system-configuration')
                    ->setRequired(false)
                    ->setType(TextType::class),
                (new Configuration())
                    ->setName('kimai_quickbooks.setting_openid_redirect_uri')
                    ->setLabel('kimai_quickbooks.setting_openid_redirect_uri')
                    ->setTranslationDomain('system-configuration')
                    ->setRequired(false)
                    ->setType(TextType::class),
                (new Configuration())
                    ->setName('kimai_quickbooks.setting_authorization_request_url')
                    ->setLabel('kimai_quickbooks.setting_authorization_request_url')
                    ->setTranslationDomain('system-configuration')
                    ->setRequired(false)
                    ->setType(TextType::class),
                (new Configuration())
                    ->setName('kimai_quickbooks.setting_token_endpoint_url')
                    ->setLabel('kimai_quickbooks.setting_token_endpoint_url')
                    ->setTranslationDomain('system-configuration')
                    ->setRequired(false)
                    ->setType(TextType::class),
            ])
        );
    }
}

<?php

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\EventSubscriber;

use App\Event\ConfigureMainMenuEvent;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;

    /**
     * MenuSubscriber constructor.
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMainMenuEvent::class => ['onMenuConfigure', 100],
        ];
    }

    /**
     * @param \App\Event\ConfigureMainMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMainMenuEvent $event)
    {
        $auth = $this->security;

        if (!$auth->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return;
        }

        if (!$auth->isGranted('kimai_quickbooks')) {
            return;
        }

        $menu = $event->getSystemMenu();

        $menu->addChild(
            new MenuItemModel('kimai_quickbooks', 'Quickbooks', 'kimai_quickbooks', [], 'fas fa-hdd')
        );
    }
}

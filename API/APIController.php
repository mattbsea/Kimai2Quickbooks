<?php

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\API;

use App\API\NotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\Security as ApiSecurity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @RouteResource("Quickbooks")
 * @SWG\Tag(name="Quickbooks")
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
final class APIController extends AbstractFOSRestController
{
    /**
     * Returns one demo entity
     *
     * @SWG\Response(
     *      response=200,
     *      description="Returns one demo entity (if you pass id = 0, a NotFoundException will be thrown)",
     *      @SWG\Schema(
     *          type="string"),
     * )
     *
     * @ApiSecurity(name="apiUser")
     * @ApiSecurity(name="apiToken")
     */
    public function getAction(): Response
    {
        $view = $this->view('OK', 200);

        return $this->handleView($view);
    }

    /**
     * Returns one demo entity
     *
     * @SWG\Response(
     *      response=200,
     *      description="Returns one demo entity (if you pass id = 0, a NotFoundException will be thrown)",
     *      @SWG\Schema(
     *          type="string"),
     * )
     *
     * @ApiSecurity(name="apiUser")
     * @ApiSecurity(name="apiToken")
     */
    public function oauth_redirectAction(Request $request): Response
    {
        $view = $this->view($request->query->get('code'), 200);

        return $this->handleView($view);
    }
}

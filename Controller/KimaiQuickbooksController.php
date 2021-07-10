<?php

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\Controller;

use App\Controller\AbstractController;
use KimaiPlugin\KimaiQuickbooksBundle\Configuration\KimaiQuickbooksConfiguration;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin/quickbooks")
 * @Security("is_granted('kimai_quickbooks')")
 */
final class KimaiQuickbooksController extends AbstractController
{
    public const LOG_FILE_NAME = 'easybackup.log';
    public const LOG_ERROR_PREFIX = 'ERROR';
    public const LOG_WARN_PREFIX = 'WARNING';
    public const LOG_INFO_PREFIX = 'INFO';

    /**
     * @var KimaiQuickbooksConfiguration
     */
    private $configuration;

    /**
     * @var string
     */
    private $filesystem;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(KimaiQuickbooksConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @Route(path="", name="kimai_quickbooks", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $code = $request->query->get('code');
        $realmId = $request->query->get('realmId');
        if( isset($code) && isset($realmId)) {
            $dataService = $this->configuration->getQBDataService();
            $oauthHelper = $dataService->getOAuth2LoginHelper();
            $accessToken = $oauthHelper->exchangeAuthorizationCodeForToken($code, $realmId);
            $dataService->updateOAuth2Token($accessToken);

            $companyInfo = $dataService->getCompanyInfo();

            return $this->render('@KimaiQuickbooks/index.authed.html.twig', [
                'companyInfo' => $companyInfo
            ]);
        } else {
            $authUrl = $this->configuration->getAuthorizationRequestUrl();

            return $this->render('@KimaiQuickbooks/index.html.twig', [
                'authUrl' => $authUrl
            ]);
        }
    }

    /**
     * @Route(path="/oauth_redirect", name="oauth_redirect", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function oauthAction(Request $request): Response
    {
        dump($request);

        return $this->render('@KimaiQuickbooks/index.html.twig', []);
    }
}

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
use KimaiPlugin\KimaiQuickbooksBundle\Repository\QBConnectionRepository;
use KimaiPlugin\KimaiQuickbooksBundle\Entity\QBConnection;
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
    public const LOG_FILE_NAME = 'kimai_quickbooks.log';
    public const LOG_ERROR_PREFIX = 'ERROR';
    public const LOG_WARN_PREFIX = 'WARNING';
    public const LOG_INFO_PREFIX = 'INFO';

    /**
     * @var KimaiQuickbooksConfiguration
     */
    private $configuration;

    /**
     * @var QBConnectionRepository
     */
    private $qbconn_repository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(QBConnectionRepository $qbconn_repository, KimaiQuickbooksConfiguration $configuration)
    {
        $this->configuration = $configuration;
        $this->qbconn_repository = $qbconn_repository;
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
        if (isset($code) && isset($realmId)) {
            $dataService = $this->configuration->getQBDataService();
            $oauthHelper = $dataService->getOAuth2LoginHelper();
            $accessToken = $oauthHelper->exchangeAuthorizationCodeForToken($code, $realmId);
            $dataService->updateOAuth2Token($accessToken);

            $companyInfo = $dataService->getCompanyInfo();

            if($this->qbconn_repository->hasCompany((string) $companyInfo->Id)) {

            } else {
                $qbconn = new QBConnection();
                $qbconn->setCompanyId($companyInfo->Id);
                $qbconn->setAccessToken($accessToken->getAccessToken());
                $qbconn->setCompanyName($companyInfo->CompanyName);
                $this->qbconn_repository->save($qbconn);
            }

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
}

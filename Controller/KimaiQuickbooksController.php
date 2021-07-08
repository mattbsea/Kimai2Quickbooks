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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin/kimai-quickbooks")
 * @Security("is_granted('kimai_quickbooks')")
 */
final class EasyBackupController extends AbstractController
{
    public const LOG_FILE_NAME = 'easybackup.log';
    public const LOG_ERROR_PREFIX = 'ERROR';
    public const LOG_WARN_PREFIX = 'WARNING';
    public const LOG_INFO_PREFIX = 'INFO';

    /**
     * @var string
     */
    private $kimaiRootPath;

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

    public function __construct(string $dataDirectory, KimaiQuickbooksConfiguration $configuration, LoggerInterface $logger = null)
    {
        $this->kimaiRootPath = dirname(dirname($dataDirectory)) . DIRECTORY_SEPARATOR;
        $this->configuration = $configuration;
    }

    /**
     * @Route(path="", name="easy_backup", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('@KimaiQuickbooks/index.html.twig', []);
    }
}

<?php

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\Configuration;

require_once(__DIR__ . '/../vendor/autoload.php');

use App\Configuration\StringAccessibleConfigTrait;
use App\Configuration\SystemBundleConfiguration;
use QuickBooksOnline\API\DataService\DataService;

final class KimaiQuickbooksConfiguration implements SystemBundleConfiguration, \ArrayAccess
{
    use StringAccessibleConfigTrait;

    public const OAUTH_SCOPE = 'com.intuit.quickbooks.accounting';

    public function getPrefix(): string
    {
        return 'kimai_quickbooks';
    }

    public function getClientID(): string
    {
        return (string) $this->find('setting_client_id');
    }

    public function getClientSecret(): string
    {
        return (string) $this->find('setting_client_secret');
    }

    public function getOAuthRedirectUri(): string
    {
        return (string) $this->find('setting_oauth_redirect_uri');
    }

    public function getOpenIDRedirectUri(): string
    {
        return (string) $this->find('setting_openid_redirect_uri');
    }

    public function getAuthorizationRequestUrl(string $base_url): string
    {
        $dataService = $this->getQBDataService($base_url);
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

        return $authUrl;
    }

    public function getTokenEndpointUrl(): string
    {
        return (string) $this->find('setting_token_endpoint_url');
    }

    public function getQBDataService(string $base_url): DataService
    {
        return DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => $this->getClientID(),
            'ClientSecret' => $this->getClientSecret(),
            'RedirectURI' => $this->getOAuthRedirectUri(),
            'scope' => self::OAUTH_SCOPE,
            'baseUrl' => 'development'
        ]);
    }
}

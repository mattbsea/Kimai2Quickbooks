<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\Configuration;

use App\Configuration\StringAccessibleConfigTrait;
use App\Configuration\SystemBundleConfiguration;

final class KimaiQuickbooksConfiguration implements SystemBundleConfiguration, \ArrayAccess
{
    use StringAccessibleConfigTrait;

    public function getPrefix(): string
    {
        return 'kimai_quickbooks';
    }

    public function getClientId(): string
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

    public function getAuthorizationRequestUrl(): string
    {
        return (string) $this->find('setting_authorization_request_url');
    }

    public function getTokenEndpointUrl(): string
    {
        return (string) $this->find('setting_token_endpoint_url');
    }

}

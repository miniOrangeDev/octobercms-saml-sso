<?php
namespace Miniorange\Samlsp\classes\actions;

use Miniorange\Samlsp\Classes\AuthnRequest;
use Miniorange\Samlsp\Helper\Constants;
use Miniorange\Samlsp\Helper\Exception\NoIdentityProviderConfiguredException;
use Miniorange\Samlsp\Helper\PluginSettings;
use Miniorange\Samlsp\Helper\Utilities;
use Flash;
use Redirect;
use URL;
use October\Rain\Exception\ApplicationException;

class SendAuthnRequest
{

    /**
     * Execute function to execute the classes function.
     *
     * @throws \Exception
     * @throws NoIdentityProviderConfiguredException
     */
    public static function execute()
    {
        $pluginSettings = PluginSettings::getPluginSettings();

        $relayState = isset($_REQUEST['RelayState']) ? $_REQUEST['RelayState'] : '/';

        // generate the saml request

        $samlRequest = (new AuthnRequest($pluginSettings->getAcsUrl(), $pluginSettings->getSpEntityId(), $pluginSettings->getSamlLoginUrl(), $pluginSettings->getLoginBindingType(), true, true))->build();
        $bindingType = $pluginSettings->getLoginBindingType();
        // send saml request over
        if (empty($bindingType) || $bindingType == Constants::HTTP_REDIRECT)
            return (new HttpAction())->sendHTTPRedirectRequest($samlRequest, $relayState, $pluginSettings->getSamlLoginUrl());
        else
            (new HttpAction())->sendHTTPPostRequest($samlRequest, $relayState, $pluginSettings->getSamlLoginUrl());
    }
}
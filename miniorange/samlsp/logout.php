<?php
use Miniorange\Samlsp\Helper\Lib\XMLSecLibs\XMLSecurityKey;
use Miniorange\Samlsp\Helper\Lib\XMLSecLibs\XMLSecurityDSig;
use Miniorange\Samlsp\Helper\PluginSettings;
use Miniorange\Samlsp\Classes\Actions\AuthFacadeController;
use Illuminate\Http\Request;

$pluginSettings = PluginSettings::getPluginSettings();
$logout_url =''; //$pluginSettings->getSiteLogoutUrl();

if (isset($_REQUEST['SAMLResponse'])) {
    $samlResponse = $_REQUEST['SAMLResponse'];
    $samlResponse = base64_decode($samlResponse);
    if (array_key_exists('SAMLResponse', $_GET) && ! empty($_GET['SAMLResponse'])) {
        $samlResponse = gzinflate($samlResponse);
    }

    $document = new DOMDocument();
    $document->loadXML($samlResponse);
    $samlResponseXml = $document->firstChild;
    $doc = $document->documentElement;
    $xpath = new DOMXpath($document);
    $xpath->registerNamespace('samlp', 'urn:oasis:names:tc:SAML:2.0:protocol');
    $xpath->registerNamespace('saml', 'urn:oasis:names:tc:SAML:2.0:assertion');
    if ($samlResponseXml->localName == 'LogoutResponse') {
        if ($logout_url == '')
            header('Location: /' . $logout_url);
        else
            header('Location: ' . $logout_url);
        exit();
        /*
         * header('Location: mologout');
         * exit();
         */
    }
}

if (! empty($pluginSettings->getSamlLogoutUrl())) {

    if (isset($_SESSION['email'])) {

        $nameId = $_SESSION['email'];

        session_destroy();

        $issuer = $pluginSettings->getSpEntityId();
        $single_logout_url = $pluginSettings->getSamlLogoutUrl();
        $destination = $single_logout_url;
        // $sessionIndex = '';
        $sessionIndex = $pluginSettings->getSessionIndex();
        //$sendRelayState = $logout_url;
        $sendRelayState = 'test';

        $samlRequest = createLogoutRequest($nameId, $sessionIndex, $issuer, $destination, 'HttpRedirect');

        $samlRequest = 'SAMLRequest=' . $samlRequest . '&RelayState=' . urlencode($sendRelayState) . '&SigAlg=' . urlencode(XMLSecurityKey::RSA_SHA256);

        $param = array(
            'type' => 'private'
        );
        $key = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $param);
        $certFilePath = 'miniorange/sso/resources' . DIRECTORY_SEPARATOR . 'sp-key.key';
        $key->loadKey($certFilePath, TRUE);
        $objXmlSecDSig = new XMLSecurityDSig();
        $signature = $key->signData($samlRequest);
        $signature = base64_encode($signature);
        $redirect = $single_logout_url . "?" . $samlRequest . '&Signature=' . urlencode($signature);
        return Redirect::to($redirect);
    }
}
if (! empty($logout_url)) {
    session_destroy();
    header("Location: $logout_url");
    exit();
}
else{
    header("Location: /");
    exit;
}

function createLogoutRequest($nameId, $issuer, $destination, $slo_binding_type = 'HttpRedirect', $sessionIndex = '')
{
    $requestXmlStr = '<?xml version="1.0" encoding="UTF-8"?>' . '<samlp:LogoutRequest xmlns:samlp="urn:oasis:names:tc:SAML:2.0:protocol" xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion" ID="' . generateID() . '" IssueInstant="' . generateTimestamp() . '" Version="2.0" Destination="' . $destination . '">
                        <saml:Issuer xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion">' . $issuer . '</saml:Issuer>
                        <saml:NameID SPNameQualifier="' . $issuer . '" Format="urn:oasis:names:tc:SAML:2.0:nameid-format:transient" xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion">' . $nameId[0] . '</saml:NameID>';
    if (! empty($sessionIndex)) {
        $requestXmlStr .= '<samlp:SessionIndex>' . $sessionIndex . '</samlp:SessionIndex>';
    }
    $requestXmlStr .= '</samlp:LogoutRequest>';

    if (empty($slo_binding_type) || $slo_binding_type == 'HttpRedirect') {
        $deflatedStr = gzdeflate($requestXmlStr);
        $base64EncodedStr = base64_encode($deflatedStr);
        $urlEncoded = urlencode($base64EncodedStr);
        $requestXmlStr = $urlEncoded;
    }
    return $requestXmlStr;
}

function generateTimestamp($instant = NULL)
{
    if ($instant === NULL) {
        $instant = time();
    }
    return gmdate('Y-m-d\TH:i:s\Z', $instant);
}

function generateID()
{
    return '_' . stringToHex(generateRandomBytes(21));
}

function stringToHex($bytes)
{
    $ret = '';
    for ($i = 0; $i < strlen($bytes); $i ++) {
        $ret .= sprintf('%02x', ord($bytes[$i]));
    }
    return $ret;
}

function generateRandomBytes($length, $fallback = TRUE)
{
    return openssl_random_pseudo_bytes($length);
}
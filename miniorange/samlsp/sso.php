<?php
namespace Miniorange\Samlsp;

use Miniorange\Samlsp\classes\actions\BackendUserAction;
use Miniorange\Samlsp\classes\actions\ProcessResponseAction;
use Miniorange\Samlsp\classes\actions\ProcessUserAction;
use Miniorange\Samlsp\classes\actions\ReadResponseAction;
use Miniorange\Samlsp\classes\actions\TestResultActions;
use Miniorange\Samlsp\Helper\Constants;
use Miniorange\Samlsp\Helper\Messages;
use Miniorange\Samlsp\Helper\PluginSettings;
use Miniorange\Samlsp\Helper\Utilities;
use Illuminate\Support\Facades\Db as Db;
use Illuminate\Support\Facades\Redirect as Redirect;
use Backend as Backend;


        if (array_key_exists('SAMLResponse', $_REQUEST) && ! empty($_REQUEST['SAMLResponse'])) {
            $relayStateUrl = array_key_exists('RelayState', $_REQUEST) ? $_REQUEST['RelayState'] : '/';
            try {
                $samlResponseObj = ReadResponseAction::execute(); // read the samlResponse from IDP
                $responseAction = new ProcessResponseAction($samlResponseObj);
                $responseAction->execute();
                $NameID = current(current($samlResponseObj->getAssertions())->getNameId());
                $attrs = current($samlResponseObj->getAssertions())->getAttributes();
                $attrs['NameID'][0] = $NameID;
                $mappings = getAttributeMapping();
                $entries = array();
                foreach ($mappings as $key => $value){
                    if(array_key_exists($value, $attrs)){
                        $entries[$key] = $attrs[$value][0];
                    }
                }
                $sessionIndex = current($samlResponseObj->getAssertions())->getSessionIndex();

                if (strcasecmp($relayStateUrl, Constants::TEST_RELAYSTATE) == 0) {
                    (new TestResultActions($attrs))->execute(); // show test results
                } elseif (strcasecmp($relayStateUrl, 'backendauth') == 0){
                    return (new BackendUserAction($attrs,$relayStateUrl, $sessionIndex,$entries,$NameID))->execute(); // backend SSO
                }
                else {
                    (new ProcessUserAction($attrs, $relayStateUrl, $sessionIndex,$entries,$NameID))->execute();
                    return Redirect::to('');// process user action
                }
            } catch (\SAMLResponseException $e) {
                if (strcasecmp($relayStateUrl, Constants::TEST_RELAYSTATE) === 0)
                    (new TestResultActions(array(), $e))->execute();
                else
                    Utilities::showErrorMessage($e->getMessage());
            }
        } else {
            Utilities::showErrorMessage(Messages::MISSING_SAML_RESPONSE);
        }

function getAttributeMapping()
{
    $db_obj = Db::table('miniorange_samlsp_saml_config')->select('map_username', 'map_email')->get();
    $mappings = array();
    foreach ($db_obj[0] as $key => $value){
        $mappings[$key] = $value;
    }
    return $mappings;
}


<?php namespace Miniorange\Samlsp\components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use Miniorange\Samlsp\Helper\Utilities as Utilities;
use Auth as Auth;
use Flash;
use System\Classes\CombineAssets as CombineAssets;
 use URL as URL;
use Redirect;
class ssoButton extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'SSO Button',
            'description' => 'Adds Single Sign On button on page.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    /*public function onClick()
    {
        if (!Utilities::isSPConfigured()) {
            Flash::error('No Idp configured. Please contact your administrator.');
            return ;
        }

       // else (new HttpAction())->sendHTTPRedirectRequest($samlRequest, $relayState, $pluginSettings->getSamlLoginUrl());
       //else  frontend_sso();
        //Route::match(['get', 'post'], 'saml_redirect{RelayState?}', function () {
        //SendAuthnRequest::execute();
         //});
         //window.location.replace('<?php echo URL::to('saml_redirect?RelayState=testconfig');?>')
        return redirect('saml_redirect');
       // return Redirect::to('https://google.com')->with('message', 'Login Failed');
         //SendAuthnRequest::execute();
         //return Response::view('miniorange.samlsp::frontend');
    }*/
    /*public function onRun()
    {

        if(Auth::check()) {
            
            $scripts = [
                'miniorange/samlsp/includes/js/hide.js'
            ];
            $this->addJs(CombineAssets::combine($scripts, plugins_path()));
            //frontend_sso();
        }
    }*/
    public function onClick()
    {
        if (!Utilities::isSPConfigured()) {
            Flash::error('No Idp configured. Please contact your administrator.');
            return;
        }
        return redirect('saml_redirect');
    }
    public function onRun()
    {

        if(Auth::check()) {
            $scripts = [
                'miniorange/samlsp/includes/js/hide.js'
            ];
            $this->addJs(CombineAssets::combine($scripts, plugins_path()));
        }
    }
}


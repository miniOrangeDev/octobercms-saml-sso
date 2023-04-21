<?php namespace Miniorange\Samlsp;

use System\Classes\CombineAssets as CombineAssets;
use System\Classes\PluginBase;
use Db;
use Illuminate\Support\Facades\Event as Event;
use Config;
use URL;
use View;
use Redirect;
use Response;
use Miniorange\Samlsp\Helper\Utilities as Utilities;

class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];
    public $elevated = true;

    public function registerComponents()

    {
        if(!Utilities::isSPConfigured())
    {
            return[];
    }
      else
        return [
            '\Miniorange\Samlsp\components\ssoButton' => 'ssoButton'
        ];
    }

    public function boot()
    {
        Event::listen('backend.auth.extendSigninView', function ($controller) {
            return View::make("miniorange.samlsp::sso");
        });
        Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
            if(get_class($controller) == 'Miniorange\Samlsp\Controllers\upgradecontroller' || get_class($controller) == 'Miniorange\Samlsp\Controllers\supportcontroller') {
                $scripts = [
                    'miniorange/samlsp/includes/css/main.css',
                ];
                //$this->addJs(CombineAssets::combine($scripts, plugins_path()));
                $controller->addCss(CombineAssets::combine($scripts,plugins_path()));
            }

            if(get_class($controller)=='Miniorange\Samlsp\Controllers\samlcontroller') {
                $scripts = [
                    'miniorange/samlsp/includes/css/premium.css'
                ];
                $controller->addCss(CombineAssets::combine($scripts, plugins_path()));
            }
            if(get_class($controller)=='Miniorange\Samlsp\Controllers\supportcontroller') {
                $scripts = [
                    'miniorange/samlsp/includes/css/premium.css'
                ];
                $controller->addCss(CombineAssets::combine($scripts, plugins_path()));
            }
            if(get_class($controller)=='Miniorange\Samlsp\Controllers\accountcontroller') {
                $scripts = [
                    'miniorange/samlsp/includes/css/premium.css',
                    'miniorange/samlsp/includes/css/main.css'
                ];
                $controller->addCss(CombineAssets::combine($scripts, plugins_path()));
            }
        });
    }
}

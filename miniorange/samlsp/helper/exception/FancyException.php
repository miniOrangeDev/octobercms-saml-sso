<?php namespace Miniorange\Samlsp\Helper\Exception;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 08-05-2019
 * Time: 13:25
 */
use Illuminate\Support\Facades\App as App;
use Redirect;
class FancyException extends \Exception {}

App::error(function(FancyException $e, $code, $fromConsole)
{
    return Redirect::to('saml_redirect');
    $msg = $e->getMessage();
    Log::error($msg);

    if ( $fromConsole )
    {
        return 'Error '.$code.': '.$msg."\n";
    }

    if (Config::get('app.debug') == false) {
        return Redirect::route('your.login.route');
    }
    else
    {
        //some debug stuff here
    }


});
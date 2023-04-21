<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17-04-2019
 * Time: 17:46
 */
use Miniorange\Samlsp\classes\actions\SendAuthnRequest as SendAuthnRequest;
use Miniorange\Samlsp\Helper\Utilities as Utilities;
use Illuminate\Http\Request;

Route::post('sso', function() {
        return include_once 'sso.php';
})->middleware('web');

Route::match(['get', 'post'], 'saml_redirect{RelayState?}', function () {
        SendAuthnRequest::execute();
});
Route::post('slo_response', function() {
    return include_once 'logout.php';
})->middleware('web');





<?php namespace Miniorange\Samlsp\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\Backend;
use BackendMenu;
use Illuminate\Support\Facades\Redirect;
use Response;
use Flash;

class samlcontroller extends Controller
{
    public $implement = [        'Backend\Behaviors\FormController'    ];
    
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {

        parent::__construct();
        BackendMenu::setContext('Miniorange.Samlsp', 'main-menu-item');

    }
    public function onDownload(){
        return Redirect::to(Backend::url('miniorange/samlsp/samlcontroller/do-download')); //Redirects control to download function below
    }

    public static function doDownload(){
        $path = __DIR__.'/../resources/sp-certificate.crt';
        $headers = [
            'HTTP/1.1 200 OK',
            'Pragma: public',
            'Content-Type: text/cer'
        ];
      return Response::download($path, 'sp-certificate',$headers);
    }
}

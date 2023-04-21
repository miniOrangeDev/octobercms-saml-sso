<?php namespace Miniorange\Samlsp\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class upgradecontroller extends Controller
{
    public $implement = [        'Backend\Behaviors\FormController'    ];
    
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Miniorange.Samlsp', 'main-menu-item', 'side-menu-item');
    }
}

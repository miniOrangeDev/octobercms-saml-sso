<?php namespace Miniorange\Samlsp\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Redirect;
use Backend;
use Miniorange\Samlsp\Classes\Customer as Customer;
use Miniorange\Samlsp\Helper\CustomerDetails as CD;
use Flash;

class LicenseController extends Controller
{
    public $implement = [        'Backend\Behaviors\FormController'    ];
    
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Miniorange.Samlsp', 'main-menu-item', 'side-menu-item');
    }

    public function custLogin(){
        $email = post('email');
        $password = post('password');
        $customer = new Customer();
        $customer->email = $email;
        CD::update_option('cust_email',$email);
        $check_content = json_decode($customer->check_customer(), true);
        if($check_content['status'] == 'CUSTOMER_NOT_FOUND'){
            Flash::error($email.' does not exist');
        }
        elseif ($check_content['status'] == 'SUCCESS'){
            $key_content = json_decode($customer->get_customer_key($password), true);
            if($key_content['status'] == 'SUCCESS'){
                CD::save_customer($key_content);
                Flash::success('Customer retrieved successfully !');
            }
            else{
                Flash::error('It seems like you have entered the incorrect password');
            }
        }
        return Redirect::to(Backend::url('miniorange\samlsp\licensecontroller\update\1'));
    }
    public function removeCustomer(){
            CD::remove_customer();
            return Redirect::to(Backend::url('miniorange\samlsp\licensecontroller\update\1'));
    }

    public function verifyLicense(){
        $code = post('saml_license_key');
        $customer = new Customer();
        $customer->email = CD::get_option('cust_email');
        $check_content = json_decode($customer->check_customer_ln(), true);
        if($check_content['status'] == 'SUCCESS'){
            $ln_content = json_decode($customer->mo_saml_vl($code, false),true);

            /*var_dump($check_content,'!!!!!',$ln_content);exit;*/
            if(strcasecmp($ln_content['status'], 'SUCCESS') == 0){
                CD::update_option('cust_reg_status','verified');
            }
            else{
                Flash::error('License key you have entered has already been used. Please enter a key which has not been used before on any                    other instance or if you have exhausted all your keys, then buy more.');
            }
        }
        else{
            Flash::error('You have not upgraded yet. Please contact support.');
        }
        return Redirect::to(Backend::url('miniorange\samlsp\licensecontroller\update\1'));
    }
}


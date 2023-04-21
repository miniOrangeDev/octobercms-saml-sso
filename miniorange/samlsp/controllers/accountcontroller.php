<?php namespace Miniorange\Samlsp\Controllers;

use Miniorange\Samlsp\Helper\CustomerDetails as CD;
use Miniorange\Samlsp\Classes\CustomerSaml;
use Backend\Classes\Controller;
use Backend\Facades\Backend;
use BackendMenu;
use Flash;
use Redirect;

class accountcontroller extends Controller
{
    public $implement = ['Backend\Behaviors\FormController'];

    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Miniorange.Samlsp', 'main-menu-item');
    }

    public function registerSubmit()
    {
        if (post('register') != '') {
            $email = post('email');
            $password = stripslashes(post('password'));
            $confirmPassword = stripslashes(post('confirmPassword'));

            CD::update_option('cust_email', $email);
            if (strcmp($password, $confirmPassword) == 0) {
                $customer = new CustomerSaml();
                $customer->email = $email;
                $check_content = json_decode($customer->check_customer(), true);
                if (strcasecmp($check_content['status'], 'CUSTOMER_NOT_FOUND') == 0) {
                    $create_content = json_decode($customer->create_customer($password), true); // Send create call to miniorange and check response content
                    if (strcasecmp($create_content['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS') == 0) {
                        $key_content = json_decode($customer->get_customer_key($password), true);
                        if (isset($key_content['id'])) {
                            CD::save_customer($key_content);
                            Flash::success("User retrieved successfully.");
                        } else {
                            Flash::error("Incorrect password entered on existing account.");
                        }
                    } elseif (strcasecmp($create_content['status'], 'SUCCESS') == 0) {
                        CD::save_customer($create_content);
                        Flash::success("Thank you for registering with miniOrange.");
                    }
                } elseif (strcasecmp($check_content['status'], 'SUCCESS') == 0) {
                    $key_content = json_decode($customer->get_customer_key($password), true);
                    if (isset($key_content['id'])) {
                        CD::save_customer($key_content);
                        Flash::success("User retrieved successfully.");
                    } else {
                        Flash::error("Incorrect password entered on existing account.");
                    }
                }
            }
        }
        return Redirect::to(Backend::url('miniorange/samlsp/accountcontroller/update/1'));
    }

    public function onChange()
    {
        CD::remove_customer();
        return Redirect::to(Backend::url('miniorange/samlsp/accountcontroller/update/1'));
    }

    public function upgrade()
    {
        return Redirect::to(Backend::url('miniorange/samlsp/accountcontroller/update/1'));
    }
    public function removeCustomer(){
        CD::remove_customer();
        return Redirect::to(Backend::url('miniorange/samlsp/accountcontroller/update/1'));
    }
}

function isLogged()
{
    if (CD::get_option('cust_reg_status') == 'logged') {
        return true;
    } else {
        return false;
    }
}

<?php namespace Miniorange\Samlsp\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use October\Rain\Support\Facades\Flash as Flash;
use Backend;
use Redirect;
use Miniorange\Samlsp\Classes\CustomerSaml as CustomerSaml;
use Miniorange\Samlsp\Helper\CustomerDetails as CD;

class supportcontroller extends Controller
{
    public $implement = ['Backend\Behaviors\FormController'];

    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Miniorange.Samlsp', 'main-menu-item', 'side-menu-item2');
    }

    public function onSendMail()
    {
        $email = post('email');
        $first_name=post('first_name');
       // $last_name=post('last_name');
        $phone = post('phone');
        $query = post('query');
        if(!empty($email) or !is_null($email)){
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    Flash::error('Please enter a valid email address');
                }
                else{
                    if(empty($query) or is_null($query)){
                        Flash::error('Please fill out a valid query');
                    }
                    else{
                        goto sendMail;
                    }
                }
        }
        else{
            Flash::error("Please enter a valid email address");
            return;
        }
        sendMail:
        $email = post('email');
        $phone = post('phone');
         $first_name=post('first_name');
        //$last_name=post('last_name');
        $query = post('query');
        $url = 'https://login.xecurify.com/moas/api/notify/send';
        $ch = curl_init($url);

        $customerKey = "16555";
        $apiKey = "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";


        $currentTimeInMillis = round(microtime(true) * 1000);
        $stringToHash = $customerKey . number_format($currentTimeInMillis, 0, '', '') . $apiKey;
        $hashValue = hash("sha512", $stringToHash);
        $customerKeyHeader = "Customer-Key: " . $customerKey;
        $timestampHeader = "Timestamp: " . number_format($currentTimeInMillis, 0, '', '');
        $authorizationHeader = "Authorization: " . $hashValue;
        $fromEmail = $email;
        $subject = "OctoberCMS SAML Plugin Support Query - ".$email;

        $content = '<div >Hello, <br><br><b>Company :</b><a href="' . $_SERVER['SERVER_NAME'] . '" target="_blank" >' . $_SERVER['SERVER_NAME'] .    '</a><br><br><b>Name :</b>' . $first_name .      '</a><br><br><b>Phone Number :</b>' . $phone .                      '<br><br><b>Email :<a href="mailto:' . $fromEmail . '" target="_blank">' . $fromEmail . '</a></b><br><br><b>Query: ' . $query . '</b></div>';

      //  $test_email_id = 'ashwini@xecurify.com';
        $support_email_id = 'info@xecurify.com';
        $support_cc_email_id='saml2support@xecurify.com';
        $fields = array(
            'customerKey' => $customerKey,
            'sendEmail' => true,
            'email' => array(
                'customerKey' => $customerKey,
                'fromEmail' => $fromEmail,
                'toName'        => $support_email_id,
                'toEmail' => $support_email_id,
                'bccEmail'=> $support_cc_email_id,
                //'ccEmail' => $support_cc_email_id,
                //'toEmail'       => 'info@xecurify.com',
                //'toName'        => 'samlsupport@xecurify.com',
                //'bccEmail'      => 'samlsupport@xecurify.com',
                'subject' => $subject,
                'content' => $content
            ),
        );
        $field_string = json_encode($fields);


        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls

        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", $customerKeyHeader,
            $timestampHeader, $authorizationHeader));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
        $content = curl_exec($ch);

        if (curl_errno($ch)) {
            Flash::error("CURL error");
        }
        curl_close($ch);
        Flash::success("Support query sent ! We will get in touch with you shortly.");
        return Redirect::to(Backend::url('miniorange\samlsp\supportcontroller\update\1'));
    }
    public function onRefreshTime()
    {
        return [
            '#target' => $this->renderPartial('_support-form')
        ];
    }

}



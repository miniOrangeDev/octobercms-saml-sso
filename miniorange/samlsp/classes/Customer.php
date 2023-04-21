<?php namespace Miniorange\Samlsp\Classes;
use Miniorange\Samlsp\Helper\DB;
use Miniorange\Samlsp\Helper\CustomerDetails as CD;

    class Customer{
        public $email;

        function create_customer() {
		
            $url = DB::get_option ( 'mo_saml_host_name' ) . '/moas/rest/customer/add';
            
            $ch = curl_init ( $url );
            // $current_user = wp_get_current_user();
            $this->email = DB::get_option ( 'mo_saml_admin_email' );
            $password = DB::get_option ( 'mo_saml_admin_password' );
            
            $fields = array (
                    'companyName' => $_SERVER ['SERVER_NAME'],
                    'areaOfInterest' => 'OctoberCMS SAML Plugin',
                    'email' => $this->email,
                    'password' => $password 
            );
            $field_string = json_encode ( $fields );
            
            curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt ( $ch, CURLOPT_ENCODING, "" );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); // required for https urls
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt ( $ch, CURLOPT_MAXREDIRS, 10 );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
                    'Content-Type: application/json',
                    'charset: UTF - 8',
                    'Authorization: Basic' 
            ) );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $field_string );
            $content = curl_exec ( $ch );
            
            if (curl_errno ( $ch )) {

                echo 'Request Error:' . curl_error ( $ch );
                exit ();
            }
            
            curl_close ( $ch );
            return $content;
        }

        function submit_contact_us($email, $phone, $query) {
            $query = '[OctoberCMS SAML Plugin] ' . $query;
            $fields = array (
                    'company' => $_SERVER ['SERVER_NAME'],
                    'email' => $email,
                    'phone' => $phone,
                    'query' => $query 
            );
            $field_string = json_encode ( $fields );
            
            $url = DB::get_option ( 'mo_saml_host_name' ) . '/moas/rest/customer/contact-us';
            
            $ch = curl_init ( $url );
            curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt ( $ch, CURLOPT_ENCODING, "" );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false ); // required for https urls
            curl_setopt ( $ch, CURLOPT_MAXREDIRS, 10 );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
                    'Content-Type: application/json',
                    'charset: UTF-8',
                    'Authorization: Basic' 
            ) );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $field_string );
           
            $content = curl_exec ( $ch );
            
            if (curl_errno ( $ch )) {

                echo 'Request Error:' . curl_error ( $ch );
                return false;
            }
            // echo " Content: " . $content;
            
            curl_close ( $ch );
            
            return true;
        }

        function check_customer() {
            $url = "https://login.xecurify.com/moas/rest/customer/check-if-exists";
            $ch = curl_init ( $url );

            $fields = array (
                    'email' => $this->email
            );
            $field_string = json_encode ( $fields );
            
            curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt ( $ch, CURLOPT_ENCODING, "" );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); // required for https urls
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt ( $ch, CURLOPT_MAXREDIRS, 10 );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
                    'Content-Type: application/json',
                    'charset: UTF - 8',
                    'Authorization: Basic' 
            ) );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $field_string );
            
            $content = curl_exec ( $ch );
    
            if (curl_errno ( $ch )) {
                echo "129";
                echo "$ch Error in sending curl Request";
                exit ();
            }
            curl_close ( $ch );
            
            return $content;
        }

        function get_customer_key($password) {
            $url = "https://login.xecurify.com/moas/rest/customer/key";
            $ch = curl_init ( $url );
            $email = $this->email;
            $fields = array (
                    'email' => $email,
                    'password' => $password 
            );
            $field_string = json_encode ( $fields );

            curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt ( $ch, CURLOPT_ENCODING, "" );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); // required for https urls
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt ( $ch, CURLOPT_MAXREDIRS, 10 );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
                    'Content-Type: application/json',
                    'charset: UTF - 8',
                    'Authorization: Basic' 
            ) );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $field_string );
            
            $content = curl_exec ( $ch );
            return $content;
        }

        function mo_saml_vl($code,$active) {
            $url = "";
            if($active)
                $url = 'https://login.xecurify.com/moas/api/backupcode/check';
            else
                $url = 'https://login.xecurify.com/moas/api/backupcode/verify';
            
            $ch = curl_init ( $url );
            
            /* The customer Key provided to you */
            $customerKey = CD::get_option ( 'cust_key' );
            
            /* The customer API Key provided to you */
            $apiKey = CD::get_option ( 'cust_api_key' );
            
            /* Current time in milliseconds since midnight, January 1, 1970 UTC. */
            $currentTimeInMillis = round ( microtime ( true ) * 1000 );
            
            /* Creating the Hash using SHA-512 algorithm */
            $stringToHash = $customerKey . number_format ( $currentTimeInMillis, 0, '', '' ) . $apiKey;
            $hashValue = hash ( "sha512", $stringToHash );
            
            $customerKeyHeader = "Customer-Key: " . $customerKey;
            $timestampHeader = "Timestamp: " . number_format ( $currentTimeInMillis, 0, '', '' );
            $authorizationHeader = "Authorization: " . $hashValue;
            
            $fields = '';
            
            // *check for otp over sms/email
            
            $fields = array (
                    'code' => $code ,
                    'customerKey' => $customerKey,
                    'additionalFields' => array(
                        'field1' => $this->saml_get_current_domain()
                    )
                    
            );

            
            $field_string = json_encode ( $fields );
            
            curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt ( $ch, CURLOPT_ENCODING, "" );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); // required for https urls
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt ( $ch, CURLOPT_MAXREDIRS, 10 );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
                    "Content-Type: application/json",
                    $customerKeyHeader,
                    $timestampHeader,
                    $authorizationHeader 
            ) );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $field_string );
            curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
            curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
            
            $content = curl_exec ( $ch );
            if (curl_errno ( $ch )) {
                echo "241";
                echo $ch+" Error in sending curl Request";
                exit ();
            }
            
            curl_close ( $ch );
            return $content;
        }

        function check_customer_ln(){
		
            $url = 'https://login.xecurify.com/moas/rest/customer/license';
            $ch = curl_init($url);
            $customerKey = CD::get_option( 'cust_key' );
            
            $apiKey = CD::get_option( 'cust_api_key' );
            $currentTimeInMillis = round(microtime(true) * 1000);
            $stringToHash = $customerKey . number_format($currentTimeInMillis, 0, '', '') . $apiKey;
            $hashValue = hash("sha512", $stringToHash);
            $customerKeyHeader = "Customer-Key: " . $customerKey;
            $timestampHeader = "Timestamp: " . $currentTimeInMillis;
            $authorizationHeader = "Authorization: " . $hashValue;
            $fields = array(
                'customerId' => $customerKey,
                'applicationName' => 'jenkins_saml_premium_plan'
                
                // 'applicationName' => 'octobercms_saml_sp_premium_plan'
            );
            $field_string = json_encode($fields);
            //var_dump($field_string);exit;
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_ENCODING, "" );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  # required for https urls
            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", $customerKeyHeader, $timestampHeader, $authorizationHeader));
            curl_setopt( $ch, CURLOPT_POST, true);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $field_string);
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt( $ch, CURLOPT_TIMEOUT, 20);
            
            $content = curl_exec($ch);
            //var_dump($content, $customerKeyHeader, $timestampHeader, $authorizationHeader);exit;
            if(curl_errno($ch))
                return false;
            curl_close($ch);
            return $content;		
        }

        function saml_get_current_domain() {
            $http_host = $_SERVER['HTTP_HOST'];
            if(substr($http_host, -1) == '/') {
                $http_host = substr($http_host, 0, -1);
            }
            $request_uri = $_SERVER['REQUEST_URI'];
            if(substr($request_uri, 0, 1) == '/') {
                $request_uri = substr($request_uri, 1);
            }
        
            $is_https = (isset($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') == 0);
            $relay_state = 'http' . ($is_https ? 's' : '') . '://' . $http_host;
            return $relay_state;
        }

    }

    
?>
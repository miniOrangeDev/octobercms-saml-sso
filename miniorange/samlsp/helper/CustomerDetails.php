<?php
namespace Miniorange\Samlsp\Helper;

use Miniorange\Samlsp\Helper\Utilities;
use Miniorange\Samlsp\Helper\DB as DB;

/**
 * This class contains some constant variables to be used
 * across the plugin.
 * All the SP settings are done here.
 * The SP SAML settings and the IDP settings have to be set
 * here.
 */
class CustomerDetails
{
    const table = "miniorange_samlsp_customer_details";

    public static function get_option($key){
        return DB::get_option(self::table, $key);
    }

    public static function update_option($key, $value) {
        DB::update_option(self::table, $key, $value);
    }

    public static function save_customer($content){
        self::update_option('cust_key',$content['id']);
        self::update_option('cust_api_key',$content['apiKey']);
        self::update_option('cust_token',$content['token']);
        self::update_option('cust_reg_status', 'logged');
    }
    public static function remove_customer(){
        self::update_option('cust_email', Null);
        self::update_option('cust_key',Null);
        self::update_option('cust_api_key',Null);
        self::update_option('cust_token',Null);
        self::update_option('cust_reg_status', Null);
    }
}
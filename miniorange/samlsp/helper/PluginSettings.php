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
class PluginSettings
{

    private static $obj;
    public $table = 'miniorange_samlsp_saml_config';

    public static function getPluginSettings()
    {
        if (! isset(self::$obj)) {
            self::$obj = new PluginSettings();
        }

        return self::$obj;
    }

    public function getIdpName()
    {
        return DB::get_option($this->table,'idp_name');
    }

    public function getIdpEntityId()
    {
        return DB::get_option($this->table,'idp_entity_id');
    }

    public function getSamlLoginUrl()
    {
        return DB::get_option($this->table,'idp_login_url');
    }

    public function getX509Certificate()
    {
        return DB::get_option($this->table,'idp_certificate');
    }

    public function getSamlLogoutUrl()
    {
        return DB::get_option($this->table,'idp_logout_url');
    }

    public function getLoginBindingType()
    {
        return DB::get_option($this->table,'saml_login_binding_type');
    }

    public function getSiteBaseUrl()
    {
        return DB::get_option($this->table,'sp_base_url');
    }

    public function getSpEntityId()
    {
        return DB::get_option($this->table,'sp_entity_id');
    }

    public function getAcsUrl()
    {
        return DB::get_option($this->table,'sp_acs_url');
    }


    public function getRelayStateUrl()
    {
        return DB::get_option($this->table,'relaystate_url');
    }

    public function getSiteLogoutUrl()
    {
        return DB::get_option($this->table,'site_logout_url');
    }

    public function getSessionIndex()
    {
        $sessionIndex = DB::get_option($this->table,'session_index');
        DB::delete_option('session_index');
        return $sessionIndex;
    }

    public function setSessionIndex($index)
    {
        DB::update_option($this->table,'session_index', $index);
    }
    public function getUserno()
    {
           return DB::get_option($this->table,'user_no');
    }
}